import tweepy
from pymongo import MongoClient
import json
import re
#-----------------remove emojis----------
emoticons_str = r"""
    (?:
        [:=;] # Eyes
        [oO\-]? # Nose (optional)
        [D\)\]\(\]/\\OpP] # Mouth
    )"""

regex_str = [
    emoticons_str,
    r'<[^>]+>',  # HTML tags
    r'(?:@[\w_]+)',  # @-mentions
    r"(?:\#+[\w_]+[\w\'_\-]*[\w_]+)",  # hash-tags
    r'http[s]?://(?:[a-z]|[0-9]|[$-_@.&amp;+]|[!*\(\),]|(?:%[0-9a-f][0-9a-f]))+',  # URLs

    r'(?:(?:\d+,?)+(?:\.?\d+)?)',  # numbers
    r"(?:[a-z][a-z'\-_]+[a-z])",  # words with - and '
    r'(?:[\w_]+)',  # other words
    r'(?:\S)'  # anything else
]
#------tokenize--------------
tokens_re = re.compile(r'(' + '|'.join(regex_str) + ')', re.VERBOSE | re.IGNORECASE)
emoticon_re = re.compile(r'^' + emoticons_str + '$', re.VERBOSE | re.IGNORECASE)


def tokenize(s):
    return tokens_re.findall(s)


#------preprocessing---------
def preprocess(s, lowercase=False):
    tokens = tokenize(s)
    if lowercase:
        tokens = [token if emoticon_re.search(token) else token.lower() for token in tokens]
    return tokens
#------fetch and preprocess the tweets and  then saved in mongodb------------

class StdOutListener(tweepy.StreamListener):
    productType ="iphone"

    def on_data(self, data):
        #print (data)
        try:
            filterlist = "iphone"
            client = MongoClient('localhost', 27017)
            db = client['review_db']
            collection = db['iphone']
            tweet = json.loads(data)
            print(tweet["text"])
            record = collection.find({"user_id":str( tweet["user"]["id_str"]),"timestamp_ms":str(tweet["timestamp_ms"]),"text":str(tweet["text"])})
            if record.count() == 0:
                #for st in preprocess(tweet["text"]):
                  #  print(st)
                if 'iphone' in  str(tweet["text"]).lower() :
                    dataf = {}
                    dataf['location'] = ""
                    dataf['timestamp_ms'] = ""
                    dataf['user_id'] = tweet["user"]["id_str"]
                    dataf['user_name'] = tweet["user"]["name"]
                    dataf['text'] = tweet["text"]
                    dataf['timestamp_ms'] = tweet["timestamp_ms"]
                    dataf['Status'] = 0
                    dataf['ProductType'] = "iphone"
                    try:
                        dataf['location'] = str(tweet["location"])
                        dataf['timestamp_ms'] = tweet["timestamp_ms"]
                    except BaseException:
                        pass
                    # dumps helps in creating backup in database
                    json_dataf = json.loads(json.dumps(dataf))
                    collection.update(json_dataf,json_dataf,True)
                    print("\n Record found \n")
                #return True
        except BaseException:
            print("ss")
            pass
        return True

    def on_error(self, status):
        print (status)

if __name__ == '__main__':

    #This handles Twitter authetification and the connection to Twitter Streaming API
    l = StdOutListener()
    auth = tweepy.OAuthHandler('4RsN6sfEQgBX1xWA9eP2vhxW9', 'zmXgEBpAXdTDGtOYlATeTtBQQ4LdqW3ThgHKiNXcrCGo9mxA9p')
    auth.set_access_token('28552319-N7WBAo3OlsCBACXiRrOO2J9aGuH66EyujkvzMBYUT', 'SOWbNqJzN9VeY13K9ekwY0M0XVxIXZtf5B6dUxumjG8ao')
    api = tweepy.API(auth)
    stream = tweepy.Stream(auth, l)
    #This line filter Twitter Streams to capture data by the keywords: 'python', 'javascript', 'ruby'
    stream.filter(track=['iphone'])
