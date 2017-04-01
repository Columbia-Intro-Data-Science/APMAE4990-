# The purpose of this program is to take each userid/url pair, convert that into a row/column, and output the data so we can later
# generate a sparse matrix with RA_generate_neighbors.py

from scipy import sparse
from numpy import linalg
from numpy.random import rand
import pandas as pd
import numpy as np

# Load in all userid/event files and merge them into one dataframe.
df_eventurl0 = pd.read_csv('../RAUseridEventurl.csv', delim_whitespace=True, error_bad_lines=False)
df_eventurl1 = pd.read_csv('../RAUseridEventurl-1.csv', delim_whitespace=True, error_bad_lines=False)
df_eventurl2 = pd.read_csv('../RAUseridEventurl-2.csv', delim_whitespace=True, error_bad_lines=False)
df_eventurl3 = pd.read_csv('../RAUseridEventurl-3.csv', delim_whitespace=True, error_bad_lines=False)
df_eventurl0 = df_eventurl0.drop_duplicates()
df_eventurl1 = df_eventurl1.drop_duplicates()
df_eventurl2 = df_eventurl2.drop_duplicates()
df_eventurl3 = df_eventurl3.drop_duplicates()
mylist = [df_eventurl0, df_eventurl1, df_eventurl2, df_eventurl3]
df_eventurl = pd.concat(mylist).drop_duplicates()

# Simply gets the event number from the URL (number after the ?)
def get_event_num(event_url):
    try:
        pos = event_url.find('?')
    except:
        return 0
    if pos:
        return event_url[pos+1:]
    else:
        return 0
row = np.array(df_eventurl['userid'])
df_eventurl['url2'] = df_eventurl['url'].apply(get_event_num)
col = np.array(df_eventurl['url'].apply(get_event_num))
df_userids = df_eventurl['userid'].drop_duplicates()


# Filter out the corrupt data in the dataframe 
df_eventurl = df_eventurl[df_eventurl['url'].notnull()]
df_eventurl = df_eventurl[df_eventurl['url'] != 'e']
df_eventurl = df_eventurl[df_eventurl['userid'] != 'e']
df_eventurl['url2'] = df_eventurl['url'].apply(get_event_num)

# Reset the index after the merge so we can associate rows/columsn with userid/events.
df_useridrow = df_eventurl['userid'].drop_duplicates().reset_index(drop=True)
df_eventcolumn = df_eventurl['url'].drop_duplicates().reset_index(drop=True)


# Print out the row, column, userid and url now - the output will then be used in RA_neighbors_generator.py

print 'row column userid url'


# Get rid of the corrupt data which was in the file - some URLS were not valid.
bad_index1 = df_eventurl['userid'].str.contains("h")
df_eventurl = df_eventurl[bad_index1 == False]
df_eventurl = df_eventurl[df_eventurl['url'].str.contains("http") == True]
df_userids = df_eventurl['userid'].drop_duplicates().reset_index(drop=True)
df_urls =  df_eventurl['url'].drop_duplicates().reset_index(drop=True)

# Go through entire list and print row/col, userid/event. This output will be used by RA_neighbors_geneartor.py to form sparse matrix.
for i in range(0, len(df_eventurl)):
	try:	
		print df_userids[df_userids == df_eventurl['userid'][i]].index.tolist()[0], df_urls[df_urls == df_eventurl['url'][i]].index.tolist()[0], df_eventurl['userid'][i], df_eventurl['url'][i], i
	except:
		pass
