# Import standard libraries
import logging
import sys, getopt
import pickle
import json
import numpy as np
from gensim import corpora, models, similarities

# Import modules
import config
import tokenizer

# Set logging
logging.basicConfig(format='%(asctime)s : %(levelname)s : %(message)s', level=logging.CRITICAL)

# Queries the monuments with given query and offset
def query(query, offset):

    # Load data
    ids = pickle.load(open(config.data_directory + '/monuments.ids', 'r'))
    dictionary = corpora.Dictionary.load(config.data_directory + '/monuments.dict')
    corpus = corpora.MmCorpus(config.data_directory + '/monuments.mm') 
    lsi = models.LsiModel.load(config.data_directory + '/monuments.lsi')
    tfidf = models.TfidfModel.load(config.data_directory + '/monuments.tfidf')
    tfidfIndex = similarities.Similarity.load(config.data_directory + '/monuments.tfidf.index')
    lsiIndex = similarities.Similarity.load(config.data_directory + '/monuments.lsi.index')

    # Convert query to a document
    tokenized = tokenizer.tokenize(query)
    vec_bow = dictionary.doc2bow(tokenized)
    
    # Determine how similar the query is to the other documents
    # and select the most similar documents
    similarity_treshold = 0.2
    vec_tfidf = tfidf[vec_bow]
    vec_lsi = lsi[vec_bow]
    sims_tfidf = tfidfIndex[vec_tfidf]
    sims_lsi = lsiIndex[vec_lsi]
    sims_avg = (np.array(sims_lsi) + 2 * np.array(sims_tfidf)) / 3
    sims_avg = sorted(enumerate(sims_avg), key=lambda item: -item[1])
    sims = sims_avg
    sims = [s for s in sims if s[1] > similarity_treshold]
    offset = int(min(offset, len(sims)))
    results = [ids[sim[0]] for sim in sims[offset:int(min(offset+10, len(sims)))]]
    
    # Print json result
    print json.dumps({'nrOfResults': len(sims), 'startResult': offset, 'endResult': min(offset+10, len(sims)), 'results': results})
    

# Main executable
def main(argv):
    q = ''
    offset = 0
    try:
        opts, args = getopt.getopt(argv,"hq:o:",["query=","offset="])
    except getopt.GetoptError:
        print 'query.py -q <query> -o <offset>'
        sys.exit(2)
    for opt, arg in opts:
        if opt == '-h':
            print 'test.py -q <query> -o <offset>'
            sys.exit()
        elif opt in ("-q", "--query"):
            q = arg
        elif opt in ("-o", "--offset"):
            offset = int(arg)
    
    query(q, offset)

# Run the appropriate main method when starting the script
if __name__ == "__main__":
    main(sys.argv[1:])



