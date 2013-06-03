# Import libraries
import re

# Get the stoplist to remove stopwords
stoplist = [line.strip() for line in open('monubit/search/stoplist.txt')]

# Tokenises a string into a collection of wors
def tokenize(str):

    # Extract tokens
    tokens = re.sub('[^a-zA-Z0-9]', ' ', str.lower()).split()
    
    # Find unigrams by removing stopwords
    unigrams = [token for token in tokens if token not in stoplist]
    
    # Find bigrams by combining unigrams
    #bigrams = []
    #for i in xrange(0, len(tokens)-1):
    #    bigrams.append(tokens[i] + ' ' + tokens[i+1])

    # Find trigrams by combining unigrams
    #trigrams = []
    #for i in xrange(0, len(tokens)-2):
    #    trigrams.append(tokens[i] + ' ' + tokens[i+1] + ' ' + tokens[i+2])
    
    result = []
    result.extend(unigrams)
    #result.extend(bigrams)
    #result.extend(trigrams)
    return result
