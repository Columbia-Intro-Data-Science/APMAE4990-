Apologies to the class. I came up with these questions on the subway and didn't intend them to be used as exercises, so there are alot of things that are ambiguious or underspecified. However, that's how actual business and real world problems are presented anyway.

##  Give a count of all videos currently out.

If you interpret the word videos as the actual physical DVD disk then it's just
```
select count(1) from rentals where return_date is null;
```

If you read "videos" as unique "films" so that if the same film was out to two different people, then we have some work to do.

```
select count(distinct I.film_id) from rental R
   JOIN inventory I on I.inventory_id = R.inventory_id
 where R.return_date is null;
```
or
```
select count(1) from
  (select I.film_id from rental R
   JOIN inventory I on I.inventory_id = R.inventory_id 
  where R.return_date is null
   group by 1) X
```
or a few other ways really. 


## Make a list of all customer names who have videos out and how much they owe.

```
select late_videos, C.first_name, C.last_name
 FROM
 (select count(1) as late_videos,  R.customer_id
    from rental R
    where R.return_date is null 
    group by R.customer_id) T
 JOIN customer C on C.customer_id = T.customer_id;
```

I chose to do it this way however you could also join Customer directly without the subquery like this

```
select count(1) as late_videos,  C.first_name, C.last_name
    from rental R
       JOIN customer C on C.customer_id = R.customer_id
    where R.return_date is null 
    group by R.customer_id, C.first_name, C.last_name;
```

This is fine, I just don't like the look of the 3 things in the group by. We are forced into it because of SQL demands we group by everything we don't aggregate by. You could also hack it by adding an unneedede aggregation function to name

```
select count(1) as late_videos,  MAX(C.first_name), MAX(C.last_name)
    from rental R
       JOIN customer C on C.customer_id = R.customer_id
    where R.return_date is null 
    group by (R.customer_id);
```

GROUP BY can make you do unnecessary things. That's just the way it is.  Note, ordering is not guaranteed unless you actually ORDER BY something. You will get results in whatever way the DBMS found convenient at the time.

## Give the most popular actors by store location.

There are a bunch of problems with this question. It's my fault for not being specific:
 * 'most popular'. Top 5, top 10 ? Let's assume 5
 * Is location "city" or is location "store". There are two stores, each in different cities so it doesn't really matter.
 * Finally, the worst problem is that I didn't actual show you enough SQL to do this in one command 

With what you learned in class, you can only query all stores and order by STORE then popularity.

```
select count(1) as rental_count, A.first_name, A.last_name, C.city
-- now a lot of joins !
  from rental R
   JOIN staff ST on ST.staff_id = R.staff_id
  JOIN store S on S.store_id = ST.store_id
  JOIN address AD on AD.address_id=S.address_id
  JOIN city C on C.city_id = AD.city_id
-- now the other side,this is hard !
 JOIN inventory I on I.inventory_id = R.inventory_id
-- we can skip the film table
 JOIN film_actor FA on FA.film_id = I.film_id
 JOIN actor A on A.actor_id = FA.actor_id
group by 2,3,4
order by 4 asc, 1 desc
```

But that's not exactly *most* popular by store. If you use LIMIT you will get an unbalanced mix of stores. You could run one query for each store adding `where store_id=` and hard code each store id. So, two queries. 
```
select count(1) as rental_count, A.first_name, A.last_name, C.city
  from rental R
   JOIN staff ST on ST.staff_id = R.staff_id
  JOIN store S on S.store_id = ST.store_id
  JOIN address AD on AD.address_id=S.address_id
  JOIN city C on C.city_id = AD.city_id
 JOIN inventory I on I.inventory_id = R.inventory_id
 JOIN film_actor FA on FA.film_id = I.film_id
 JOIN actor A on A.actor_id = FA.actor_id
WHERE S.store_id = 1  --- and then =2
group by 2,3,4
order by 1 desc
limit 5
```

This is a good a time as any to learn about `UNION ALL`. if you think of JOIN as gluing tables together horizontally, then UNION ALL does it vertically. `UNION ALL` allows you to merge two tables as long as they have the same columns. It's used for tables like this:

```
select * from T1 UNION ALL T2
```

but... remember that you can replace T1 with a subquery like `(select ...) T1`, so a marginalyl more elegant solution is to run two queries like above, hard coding the store_id, once for each store and doing a `UNION ALL`

```
select * from

(select count(1) as rental_count, A.first_name, A.last_name, C.city
  from rental R
   JOIN staff ST on ST.staff_id = R.staff_id
  JOIN store S on S.store_id = ST.store_id
  JOIN address AD on AD.address_id=S.address_id
  JOIN city C on C.city_id = AD.city_id
 JOIN inventory I on I.inventory_id = R.inventory_id
 JOIN film_actor FA on FA.film_id = I.film_id
 JOIN actor A on A.actor_id = FA.actor_id
WHERE S.store_id = 1
group by 2,3,4
order by 1 desc
limit 5) S1

UNION ALL

(select count(1) as rental_count, A.first_name, A.last_name, C.city
  from rental R
   JOIN staff ST on ST.staff_id = R.staff_id
  JOIN store S on S.store_id = ST.store_id
  JOIN address AD on AD.address_id=S.address_id
  JOIN city C on C.city_id = AD.city_id
 JOIN inventory I on I.inventory_id = R.inventory_id
 JOIN film_actor FA on FA.film_id = I.film_id
 JOIN actor A on A.actor_id = FA.actor_id
WHERE S.store_id = 2
group by 2,3,4
order by 1 desc
limit 5) ;
```

But I think we can all agree that that is *brutally* inelegant, and it forces us to know
how many stores there are and their ids at the time we write the query.

The best way to do this is to use an "analytic" or "window" function. [Here's a tutorial.](http://www.postgresqltutorial.com/postgresql-window-function/) This allows you to apply a function across a subset of rows, grouped by something, in a certain order.  In this case, I'm going to apply a RANK() function across the rows, but partitioned by store so each store gets it's own RANK() ordering.

It works something like this;
```

rank() over (PARTITION by S.store_id order by count(1) desc)  store_rank

For each store_id
     group by actor names
     order by rental_count desc
     write in the order of these records into a new column field called store_rank
     throw it all back into the pile
```

Because this is partitioned by store, each rank list is separate for each store.
Let's make the results of this a subquery, (T1) and then just filter out 
the rows with rank <= 5
```
select * from

(select count(1) as rental_count, A.first_name, A.last_name, S.store_id, C.city,
   rank() over (PARTITION by S.store_id order by count(1) desc)  store_rank
-- now a lot of joins !
  from rental R
   JOIN staff ST on ST.staff_id = R.staff_id
  JOIN store S on S.store_id = ST.store_id
  JOIN address AD on AD.address_id=S.address_id
  JOIN city C on C.city_id = AD.city_id
-- now the other side,this is hard !
 JOIN inventory I on I.inventory_id = R.inventory_id
-- we can skip the film table
 JOIN film_actor FA on FA.film_id = I.film_id
 JOIN actor A on A.actor_id = FA.actor_id
group by 2,3,4,5 ) T1
where store_rank <= 5
order by city, store_rank;

rental_count | first_name |  last_name  | store_id |    city    | store_rank
--------------+------------+-------------+----------+------------+------------
          421 | Susan      | Davis       |        1 | Lethbridge |          1
          378 | Gina       | Degeneres   |        1 | Lethbridge |          2
          353 | Matthew    | Carrey      |        1 | Lethbridge |          3
          337 | Angela     | Witherspoon |        1 | Lethbridge |          4
          335 | Mary       | Keitel      |        1 | Lethbridge |          5
          404 | Susan      | Davis       |        2 | Woodridge  |          1
          375 | Gina       | Degeneres   |        2 | Woodridge  |          2
          339 | Mary       | Keitel      |        2 | Woodridge  |          3
          325 | Matthew    | Carrey      |        2 | Woodridge  |          4
          323 | Walter     | Torn        |        2 | Woodridge  |          5
(10 rows)
```

## Using a $1 per day late fee. Find out which users owe the most assuming all rentals are a week long

* Now that I'm looking more carefully at the schema I see that each movie has it's own rental period (in the Film Table). Let's stick with 7 days but feel free to do it the hard way if you like

So let's say someone rented on 1/1/2017. I guess there's some ambiguity here about if they rent 5 minutes before the store closes should they count that as a day ? Let's be generous and say that we always round down. So For a rental done on 1/1 they need to return by 1/8. if they return on 1/9 they get one late day. 1/10 is two etc.

How are we going to do all this rounding ? Looking at postgres documentation on datetime and date I see a `date` function which rounds down. Also, adding and subtracting dates seems to work !

```
postgres=# select rental_date, date(rental_date) + 7 as due_date from rental limit 10;
     rental_date     |  due_date
---------------------+------------
 2005-05-24 22:54:33 | 2005-05-31
 2005-05-24 23:03:39 | 2005-05-31
 2005-05-24 23:04:41 | 2005-05-31
 2005-05-24 23:05:21 | 2005-05-31
 2005-05-24 23:08:07 | 2005-05-31
 ```
 
Ok. These rentals are from 2005. These rental fees are gonna be "YUUUUUGE".

```
postgres=# select C.first_name, C.last_name, C.customer_id, sum(date(NOW()) - (date(rental_date) + 7)) * 1.00 fees from rental R
JOIN Customer c on c.customer_id = R.customer_id
where return_date IS NULL group by 1,2,3 order by fees desc limit 20;

 first_name | last_name  | customer_id |   fees
------------+------------+-------------+----------
 Tammy      | Sanders    |          75 | 12171.00
 Bill       | Gavin      |         457 |  8114.00
 Miguel     | Betancourt |         448 |  8114.00
 Cathy      | Spencer    |         163 |  8114.00
 Annette    | Olson      |         175 |  8114.00
 Mildred    | Bailey     |          60 |  8114.00
 Helen      | Harris     |          15 |  8114.00
 Morris     | Mccarter   |         576 |  8114.00
 Florence   | Woods      |         107 |  8114.00
 Sonia      | Gregory    |         284 |  8114.00
 Jordan     | Archuleta  |         560 |  8114.00
 Cassandra  | Walters    |         269 |  8114.00
 Margie     | Wade       |         267 |  8114.00
 Allison    | Stanley    |         228 |  8114.00
 Natalie    | Meyer      |         216 |  8114.00
 Heather    | Morris     |          53 |  8114.00
 Carolyn    | Perez      |          42 |  8114.00
 Lucy       | Wheeler    |         208 |  8114.00
 Justin     | Ngo        |         354 |  8114.00
 Lawrence   | Lawton     |         361 |  8114.00
(20 rows)
```
So that data DOES look fishy, everyone with movies out rented them at the same time ! Except Tammy. Poor tammy.
But this is crappy simulated data, so that's what it is.


## What hour of the day to people rent the most ?

This question forces you to go to the postgres manual. (surprise !) and learn about [datetime functions](https://www.postgresql.org/docs/9.6/static/functions-datetime.html).

It looks like `SELECT EXTRACT(HOUR from TIMESTAMP '2000-12-16 12:21:13');` is what we need.

Now it's simple, we just extract the hour from `rental` and group by.
```
select EXTRACT( HOUR from rental_date) h , count(1) c from rental group by h order by c desc;

 h  |  c
----+-----
 15 | 887
  8 | 696
  0 | 694
 18 | 688
  3 | 684
  4 | 681
...
 ```
 As this data was randomly generated, this isn't realistic, obviously. But the answer is 3pm.
 
## Which store is more profitable, assuming all movies cost $15 per inventory item to purchase.
Clarifications:
 - ignore late fees for now
 - assume rental rate is the one from film.rental_rate
 - I see that the film table actually has a 'replacement cost' but let's stick with $15 per film
 - ignore rentals currently in progress. who knows how late they will be.
 
Meaning... for the store to purchase. This, again is an underspecified question as we only have a few days of sales. But let's at least see which is on their way to making more money.

So, first let's calculate how much each store has spent in inventory.

```
postgres=# select store_id, count(1) * 15.0 as spent from inventory group by store_id;
 store_id |  spent
----------+---------
        1 | 34050.0
        2 | 34665.0
```

Ok we can use that in a subquery. 
Now over the data in the database, how much has each store made ?

Let's look at the film schema.
```
      Column      |            Type             |                       Modifiers
------------------+-----------------------------+--------------------------------------------------------
 film_id          | integer                     | not null default nextval('film_film_id_seq'::regclass)
 title            | character varying(255)      | not null
 description      | text                        |
 release_year     | year                        |
 language_id      | smallint                    | not null
 rental_duration  | smallint                    | not null default 3
 rental_rate      | numeric(4,2)                | not null default 4.99
...
 replacement_cost | numeric(5,2)                | not null default 19.99
...
 
```
Oh look it also has a replacement cost ! I guess I should have used that for the purchase cost, but whatever, let's just pretend that they all cost $15.00 to the store.

Now let's calculate how many days each film has been rented so far. For convenience let's ignore the titles currently out (return_date is null) and just focus on completed transaction.

Let's use the date() function you can find in postgres documentation to chop off the time part of the date, and let's check that we can do some date arithmetic and it makes sense.

```
elect rental_date, return_date, date(return_date) - date(rental_date) from rental limit 10;
     rental_date     |     return_date     | ?column?
---------------------+---------------------+----------
 2005-05-24 22:54:33 | 2005-05-28 19:40:33 |        4
 2005-05-24 23:03:39 | 2005-06-01 22:12:39 |        8
 2005-05-24 23:04:41 | 2005-06-03 01:43:41 |       10
...
 ```

that looks reasonable. Now, we have different rental costs depending on the film, so we need to join to FILM to see that. Let's put store_id, rate and period in a subquery, then do the multiplication in an outer query and groupy. Note the use of SUM.

```
postgres=# select sum(rental_rate * rental_period) as income, store_id from
  (select I.store_id, date(return_date) - date(rental_date) as rental_period, F.rental_rate from rental R
  JOIN Inventory I on I.inventory_id = R.inventory_id
  JOIN Film F on F.film_id = R.inventory_id
  WHERE R.return_date IS NOT NULL) T1
  GROUP BY store_id;
  
    income  | store_id
----------+----------
 26591.27 |        1
 25499.38 |        2
```

Looks good. All that remains is to JOIN to our earier query which calculated expense, on store, and we have our result (and a monster query)

```

select Spent.store_id, Spent.spent, Income.income, Income.income - Spent.spent as profit
from

(select store_id, count(1) * 15.0 as spent from inventory group by store_id) Spent
JOIN
(select sum(rental_rate * rental_period) as income, store_id from
  (select I.store_id, date(return_date) - date(rental_date) as rental_period, F.rental_rate from rental R
  JOIN Inventory I on I.inventory_id = R.inventory_id
  JOIN Film F on F.film_id = R.inventory_id
  WHERE R.return_date IS NOT NULL) T1
  GROUP BY store_id ) Income
on Income.store_id = Spent.store_id


 store_id |  spent  |  income  |  profit
----------+---------+----------+----------
        1 | 34050.0 | 26591.27 | -7458.73
        2 | 34665.0 | 25499.38 | -9165.62
(2 rows)
```

So it looks like both are losing money, but store 1 is losing *less* money for now. Maybe if we counted late fees and waited a few weeks more we'd see some profit.


## Given a movie name, find out movies to recommend, based on the most popular movies rented by people who rented *that* movie.

So you know how I said you can JOIN two tables ?
You can also JOIN a table with itself. MIND BLOWN !

This one is going to take some more planning.

* let's find the film_id of a given movie
* Let's find all the people who rented that given movie.
* Then let's look at all the movies that THEY rented, put them all together and rank them by number of rentals

One thing that will be useful here is the WHERE x IN ( ... )
which allows you to use a returned list of items in a where clause.
But you can also do it with JOIN.

So let's pick a random film to use as input into our query later.

```
postgres=# select title from film order by random() limit 1;
      title
------------------
 Academy Dinosaur
(1 row)
```

ok. So we will need to join back from that to rentals via inventory and get all the customers.

```
postgres=# select distinct R.customer_id from film F
  JOIN Inventory I on I.film_id =  F.film_id
  JOIN rental R on R.inventory_id = I.inventory_id
   where F.title like 'Academy Dinosaur'
;
 customer_id
-------------
         170
         554
          34
         344
           8
         359
         252
          39
         587
         345
```

Note I used DISTINCT. I'm assuming the same person hasn't rented the same film twice, but if they have, I decided to eliminate that. Let's make this a subquery and name it "customer_list". Now we want to find all the rentals that this set of customers has made. We can do this by joining BACK to Rentals and back to films

```
postgres=# select F.film_id, F.title, count(1) c from
  Film F
    JOIN Inventory I on I.film_id =  F.film_id
     JOIN rental R on R.inventory_id = I.inventory_id
     JOIN

(select distinct R.customer_id from film F
  JOIN Inventory I on I.film_id =  F.film_id
  JOIN rental R on R.inventory_id = I.inventory_id
   where F.title like 'Academy Dinosaur') CustomerList

   on CustomerList.customer_id = R.customer_id
  group by F.film_id
  order by c desc
  LIMIT 10;
 film_id |        title        | c
---------+---------------------+----
       1 | Academy Dinosaur    | 23
     489 | Juggler Hardly      |  4
     285 | English Bulworth    |  4
     415 | High Encino         |  4
     203 | Daisy Menagerie     |  4
     284 | Enemy Odds          |  3
     665 | Patton Interview    |  3
      51 | Balloon Homeward    |  3
     477 | Jawbreaker Brooklyn |  3
     179 | Conquerer Nuts      |  3
(10 rows)
```
 There you go. The world's cheapest collaborative filter reccomendation engine. Sell it to Netflix.
 
I might as well introduce some nice syntax here. I would have prefered to write this with  `WHERE x in ( <subquery w one column> )`. Style wise, it's just clearer what the intentions are.

```
select F.film_id, F.title, count(1) c from
  Film F
    JOIN Inventory I on I.film_id =  F.film_id
    JOIN rental R on R.inventory_id = I.inventory_id

  WHERE R.customer_id IN 
  (select distinct R.customer_id from film F
  JOIN Inventory I on I.film_id =  F.film_id
  JOIN rental R on R.inventory_id = I.inventory_id
   where F.title like 'Academy Dinosaur')
  
  group by F.film_id
  order by c desc
  LIMIT 10;
```

Note I didn't need to name the subquery in this case, becuase it isn't though of as a table. SQL is picky !


