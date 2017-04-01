# This program loads in all of the previous event history and then for each userid, will output
# userid, events_dj1-5, events_promoter1-5, events_venue1-5 where events_dj,events_promoter and events_venue
# are future events which have djs, promoters and venues in userid's history.

import pandas as pd
import numpy as np
import itertools

# Load in all event history from the 4 files below and merge them.
mylist = [pd.read_csv('RAevent_data%d.csv' % i, delim_whitespace=True, error_bad_lines=False) for i in range(1,4)]
df_f = pd.concat(mylist).drop_duplicates()

# These are the future urls - must be modified depending on date.
future_urls = df_4.drop_duplicates()[-2400:]

# List all of the users past djs.
def get_djs(userid):
    df_user = df_f[df_f['userid']==userid]
    mylist = list(df_user['dj1']) + list(df_user['dj2']) + list(df_user['dj3'])
    return mylist

# List all of the users past promoters.
def get_promoters(userid):
    df_user = df_f[df_f['userid']==userid]
    mylist = list(df_user['promoter1']) + list(df_user['promoter2']) + list(df_user['promoter3'])
    return mylist

# List all of the users past venues.
def get_venues(userid):
    df_user = df_f[df_f['userid']==userid]
    mylist = list(df_user['venue'])
    return mylist


# Find all future events which have a dj in the list of userids dj list gotten from get_djs().
def future_dj(userid):
    dj_list = list(get_djs(userid))
    event_list = []
    dj_favs = []
    for dj in dj_list:
        if dj != 'None':
            events_dj1 = future_urls[future_urls['dj1'] == dj]
            events_dj2 = future_urls[future_urls['dj2'] == dj]
            events_dj3 = future_urls[future_urls['dj3'] == dj]
            event_list.append(list(events_dj1['url'].drop_duplicates()))
            event_list.append(list(events_dj2['url'].drop_duplicates()))
            event_list.append(list(events_dj3['url'].drop_duplicates()))
            if len(events_dj1) > 0 or len(events_dj2) > 0 or len(events_dj3) > 0 and dj != 'None' and dj not in dj_favs:
                dj_favs.append(dj)
    return list(itertools.chain(*event_list)), dj_favs, userid

# Find all future events which have a promoter in the list of userid's promoter list gotten from get_promoters()
def future_promoters(userid):
    promoter_list = list(get_promoters(userid))
    event_list = []
    promoter_favs = []
    for promoter in promoter_list:
        if promoter != 'None':
            events_dj1 = future_urls[future_urls['promoter1'] == promoter]
            events_dj2 = future_urls[future_urls['promoter2'] == promoter]
            events_dj3 = future_urls[future_urls['promoter3'] == promoter]
            event_list.append(list(events_dj1['url'].drop_duplicates()))
            event_list.append(list(events_dj2['url'].drop_duplicates()))
            event_list.append(list(events_dj3['url'].drop_duplicates()))
            if len(events_dj1) > 0 or len(events_dj2) > 0 or len(events_dj3) > 0 and promoter != 'None' and promoter not in promoter_favs:
                promoter_favs.append(promoter)
    return list(itertools.chain(*event_list)), promoter_favs, userid
    
# Find all future events with venue userid has attended previously.

def future_venue(userid):
    venue_list = list(get_venues(userid))
    event_list = []
    venue_favs = []
    for venue in venue_list:
        if venue != 'None':
            events_dj1 = future_urls[future_urls['venue'] == venue]
            event_list.append(list(events_dj1['url'].drop_duplicates()))
            if len(events_dj1) > 0 and venue != 'None' and venue not in venue_favs:
                venue_favs.append(venue)
    return list(itertools.chain(*event_list)), venue_favs, userid

# Next need to find future events with these particular performers!

# Load three arrays, url_djs, url_promoters, url_venues with the above data, up to a maximum of 5 urls.
def generate_favs(userid):
    urls1, djs, uid = future_dj(userid)
    urls2, promoters, uid = future_promoters(userid)
    urls3, venues, uid = future_venue(userid)
    length1 = len(urls1)
    length2 = len(urls2)
    length3 = len(urls3)
    url_djs = []
    url_promoters = []
    url_venues = []

    # Fill url_djs array with suggested urls.
    for i in range(0, min(length1,5)):
        url_djs.append(urls1[i])

    # Fill url_promoters with suggested urls.
    for i in range(0, min(length2,5)):
        url_promoters.append(urls2[i])

    # Fill url_venues with suggested urls.
    for i in range(0, min(length3,5)):
        url_venues.append(urls3[i])
      
    # If there aren't enough, simply put None as a place holder for each.
    if length1 < 5:
        for i in range(length1, 5):
            url_djs.append('None')
    if length2 < 5:
        for i in range(length2, 5):
            url_promoters.append('None')
    if length3 < 5:
        for i in range(length3, 5):
            url_venues.append('None')
    return url_djs, url_promoters, url_venues



# Go through all users, and list suggestions as userid, event_djs, event_promoters, event_venues. This data will be
# loaded into SQL after being outputted to file.

for user in list(df_f['userid'].drop_duplicates()):
	result = generate_favs(user)
	print user,
	for i in range(0,3):
    		for j in range(0,5):
        		print result[i][j],
	print ''
