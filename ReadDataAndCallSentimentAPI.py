from pymongo import MongoClient
import json
import re
import time
import requests
import threading
import datetime


url = "http://api.meaningcloud.com/sentiment-2.1"


headers = {'content-type': 'application/x-www-form-urlencoded'}

#response = requests.request("POST", url, data=payload, headers=headers)

#print(response.text)


client = MongoClient('localhost', 27017)
db = client['review_db']
collection = db['iphone']
collection1 = db['iphone_textAnalysis']
tweets_iterator = collection.find({"Status":0})
countw = 0
for tweet in tweets_iterator:
  print(tweet)
  dataf = {}
  dataf['location'] = str(tweet["location"])
  dataf['user_id'] = tweet["user_id"]
  dataf['user_name'] = tweet["user_name"]
  dataf['text'] = tweet["text"]
  dataf['timestamp_ms'] = tweet["timestamp_ms"]
  try:
      payload = "key=d68f17589967b2e13ef1d9a28c5974fb &lang=en&txt="+ tweet["text"] + "&model=general"
      response = requests.request("POST", url, data=payload, headers=headers)
      dataf['TextAnalysis'] = json.loads(response.text)
      #print(response.text)
      json_dataf = json.loads(json.dumps(dataf))
      collection1.update(json_dataf, json_dataf, True)
  except BaseException:
         pass

  time.sleep(2)
  try:
     post = collection.find_one({"_id": tweet["_id"]})
     if post is not None:
        post['Status'] = 1
        collection.update({'_id': tweet["_id"]}, {"$set": post}, upsert=False)
        print("Record update")
  except BaseException:
     pass



