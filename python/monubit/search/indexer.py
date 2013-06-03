# Import standard libraries
import gensim
import logging
import re
import sys
import math
import numpy
import scipy
import os
import gensim
import pickle
from gensim import corpora, models, similarities

# Import modules
from monubit.database import database
import config
import tokenizer

# Set logging
logging.basicConfig(format='%(asctime)s : %(levelname)s : %(message)s', level=logging.INFO)

# Create data directory to store indices
if not os.path.exists(config.data_directory):
    os.makedirs(config.data_directory)

# Get all monument features
print '\033[1;33mObtaining monument features from the database\033[0;m'
monuments = database.getMonuments()
field_weights = {'name': 5, 'description': 2, 'town': 4, 'subCategory': 2, 'street': 1, 'province': 1, 'zipCode': 1}
ids = [monument['id'] for monument in monuments]
monuments = database.getConcatenatedString(monuments, field_weights)

# Save monuments identifiers
print '\033[1;33mSaving monument identifiers to file\033[0;m'
pickle.dump(ids, open(config.data_directory + '/monuments.ids', 'w'))

# Tokenise all the descriptions
print '\033[1;33mTokenizing monuments\033[0;m'
monuments = [[word for word in tokenizer.tokenize(monument) if len(word) > 2] for monument in monuments]

# Generate the dictionary
print '\033[1;33mGenerating dictionary\033[0;m'
dictionary = corpora.Dictionary(monuments)
stoplist = [line.strip() for line in open('monubit/search/stoplist.txt')]
stop_ids = [dictionary.token2id[stopword] for stopword in stoplist if stopword in dictionary.token2id]
#once_ids = [tokenid for tokenid, docfreq in dictionary.dfs.iteritems() if docfreq == 1]
dictionary.filter_tokens(stop_ids)
dictionary.compactify()

# Save the dictionary
print '\033[1;33mSaving dictionary to file\033[0;m'
dictionary.save(config.data_directory + '/monuments.dict')

# Convert descriptions to vectors
print '\033[1;33mConverting descriptions to vectors\033[0;m'
corpus = [dictionary.doc2bow(monument) for monument in monuments]

# Save the corpus
print '\033[1;33mSaving corpus to file\033[0;m'
corpora.MmCorpus.serialize(config.data_directory + '/monuments.mm', corpus)

# Generate tfidf model
print '\033[1;33mGenerating tfidf model\033[0;m'
tfidf = models.TfidfModel(corpus)

# Save the tfidf model
print '\033[1;33mSaving tfidf model to file\033[0;m'
tfidf.save(config.data_directory + '/monuments.tfidf')

# Generate latent semantic index
lsi_num_topics = 500
print '\033[1;33mGenerating latent semantic index model with ' + str(lsi_num_topics) + ' topics\033[0;m'
lsi = models.LsiModel(corpus, id2word=dictionary, num_topics=lsi_num_topics)

# Save the latent semantic index
print '\033[1;33mSaving latent semantic index to file\033[0;m'
lsi.save(config.data_directory + '/monuments.lsi')

# Generate the similarity matrix for tfidf
print '\033[1;33mGenerating similarity matrix for tfidf\033[0;m'
tfidfIndex = similarities.Similarity(config.data_directory + '/monuments.tfidf.index',  tfidf[corpus], len(dictionary.keys()))

# Save the similarity matrix for tfidf
print '\033[1;33mSaving similarity matrix for tfidf to file\033[0;m'
tfidfIndex.save(config.data_directory + '/monuments.tfidf.index')

# Generate the similarity matrix for lsi
print '\033[1;33mGenerating similarity matrix for lsi\033[0;m'
lsiIndex = similarities.Similarity(config.data_directory + '/monuments.lsi.index',  lsi[corpus], lsi_num_topics)

# Save the similarity matrix for lsi
print '\033[1;33mSaving similarity matrix for lsi to file\033[0;m'
lsiIndex.save(config.data_directory + '/monuments.lsi.index')

# Notify user everything completed
print '\033[1;32mDone!\033[0;m'
