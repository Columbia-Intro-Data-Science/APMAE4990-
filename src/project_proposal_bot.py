import os
import pandas as pd
import random
df = pd.read_csv('data/student_presentations.csv')
df_not_presented = df[df['Presented'].isnull()]
df_not_presented.reset_index(inplace=True)
student_num = random.randint(0,len(df_not_presented))

student = df_not_presented.loc[student_num]
name = student['Name']
uni = student['UNI']
print name
print uni
msg = name + " @" + uni + " - you have been selected to present!"
command = 'curl https://slack.com/api/chat.postMessage -X POST -d "channel=#projects" -d "text=' + msg + '" -d "username=project_proposals" -d "token={REMOVED}" -d "icon_emoji=:simple_smile:"'

os.system(command)
