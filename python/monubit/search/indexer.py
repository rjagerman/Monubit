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
print '\033[1;33mObtaining monument information from the database\033[0;m'
monuments = database.getMonuments()

# Save monuments identifiers
print '\033[1;33mSaving monument identifiers to file\033[0;m'
ids = [monument['id'] for monument in monuments]
pickle.dump(ids, open(config.data_directory + '/monuments.ids', 'w'))

# Normalize fields based on description length
print '\033[1;33mNormalizing features based on description length\033[0;m'
monument_texts = []
for idx, monument in enumerate(monuments):
    w = max(int(round((len(tokenizer.tokenize(monument['description']))/5))), 1)
    field_weights = {'name': w, 'description': 1, 'town': w, 'mainCategory': w, 'subCategory': w, 'street': w, 'province': w, 'zipCode': w}
    monument_texts.append(database.getConcatenatedString(monument, field_weights))

# Tokenise all the descriptions
print '\033[1;33mTokenizing monuments\033[0;m'
monuments_tokens = [[word for word in tokenizer.tokenize(monument_text) if len(word) > 2] for monument_text in monument_texts]

# Generate the dictionary
print '\033[1;33mGenerating dictionary\033[0;m'
dictionary = corpora.Dictionary(monuments_tokens)
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
corpus = [dictionary.doc2bow(monument_tokens) for monument_tokens in monuments_tokens]

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
lsi_num_topics = 100
print '\033[1;33mGenerating latent semantic index model with ' + str(lsi_num_topics) + ' topics\033[0;m'
lsi = models.LsiModel(corpus, id2word=dictionary, num_topics=lsi_num_topics)
lsi.print_topics(lsi_num_topics)

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
