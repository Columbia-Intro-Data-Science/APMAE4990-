

import urllib2
import time
import sys
import smtplib
import os.path
import os
import MySQLdb

# Connect to MYSQL database
db = MySQLdb.connect(host="localhost", # your host, usually localhost
                     user="speakit9", # your username
                      passwd="Dorianbassem@11", # your password
                      db="speakit9_RA") # name of the data base

# you must create a Cursor object. It will let
#  you execute all the queries you need
cur = db.cursor()

# Select all entries from ticket_advisor table.
cur.execute("SELECT * FROM ticket_advisor")

# print all the first cell of all the rows

# Gmail account login information

fromaddr = 'raticketapp2@gmail.com'
msg='Tickets are now available on RA'
username='raticketapp2@gmail.com'
password='hntpcv01!!'

fromaddr = 'speakit9@speakinimages.com'
msg = 'Tickets are now available on RA'
username='speakit9'
password='Dorianbassem@11'
# Go through every line in the RAEventFile


for row in cur.fetchall(): #for lines in rafile:
        # If the event hasn't already sent out tickets, then access the email_list file for the event and send out emails to everyone
        if row[2] == 0:
                print "Haven't sent out tickets yet"
                soup = urllib2.urlopen(row[1]).read()
                if soup.find('<a id="addToBasket" href="#" title="Add to basket">Add to basket</a>')==-1:
                        print('None')
                else:
                        server = smtplib.SMTP('localhost:25')
                    #server.ehlo()
                        server.starttls()
                        server.login(username,password)
                        sql_string = "UPDATE ticket_advisor SET sent=1 WHERE email='" + row[0] + "' and url='" + row[1] + "'"
                        print sql_string
                        cur.execute(sql_string);
                        print 'Sending email'
                        msg = "\r\n".join([
                                "From: RATicketAdvisor@gmail.com",
                                "To: user@gmail.com",
                                "Subject: Tickets for the event at " + row[1] + " are now available!",
                                "",
                                "Tickets for the event at <a href='" + row[1] + "'>" + row[1] + "</a> are now available!"
                                ])
                        server.sendmail('raticketapp2@gmail.com',row[0],msg)
                        server.quit()
                        print('Tickets available!')

