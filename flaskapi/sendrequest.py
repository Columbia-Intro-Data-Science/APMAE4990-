import requests
dictToSend = {'question':'what is the answer?'}
dictToSend=[
	{'Age': 85, 'Sex': 'male', 'Embarked': 'S'},
    {'Age': 24, 'Sex': 'female', 'Embarked': 'C'},
    {'Age': 3, 'Sex': 'male', 'Embarked': 'C'},
    {'Age': 21, 'Sex': 'male', 'Embarked': 'S'}]
res = requests.post('http://0.0.0.0:80/predict', json=dictToSend)
print 'response from server:',res.text
dictFromServer = res.json()
