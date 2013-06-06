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
def query(query, offset, rpp):

    # Load the indexed data
    ids = pickle.load(open(config.data_directory + '/monuments.ids', 'r'))
    dictionary = corpora.Dictionary.load(config.data_directory + '/monuments.dict')
    corpus = corpora.MmCorpus(config.data_directory + '/monuments.mm') 
    lsi = models.LsiModel.load(config.data_directory + '/monuments.lsi')
    tfidf = models.TfidfModel.load(config.data_directory + '/monuments.tfidf')
    tfidfIndex = similarities.Similarity.load(config.data_directory + '/monuments.tfidf.index')
    lsiIndex = similarities.Similarity.load(config.data_directory + '/monuments.lsi.index')

    # Convert query to a tokenized document and project it as a vector in tfidf and lsi
    tokenized = tokenizer.tokenize(query)
    vector = dictionary.doc2bow(tokenized)
    tfidf_vector = tfidf[vector]
    lsi_vector = lsi[vector]
    
    # Determine how similar the query vector is to the other documents in
    # the same spaces (tfidf and lsi), and select the most similar documents
    tfidf_similarity = tfidfIndex[tfidf_vector]
    lsi_similarity = lsiIndex[lsi_vector]
    similarity = np.array(lsi_similarity) * np.array(tfidf_similarity)
    similarity = sorted(enumerate(similarity), key=lambda item: -item[1])
    sims = similarity
    sims = [s for s in sims if s[1] > 0]
    offset = int(min(offset, len(sims)))
    results = [str(ids[sim[0]]) for sim in sims[offset:int(min(offset+rpp, len(sims)))]]
    
    # Print json result
    print json.dumps({
        'nrOfResults': len(sims),
        'startResult': offset,
        'endResult': min(offset+rpp, len(sims)),
        'results': results})
    

# Main executable
def main(argv):
    q = ''
    offset = 0
    rpp = 10
    try:
        opts, args = getopt.getopt(argv,"hq:o:p",["query=","offset=","resultsPerPage="])
    except getopt.GetoptError:
        print 'query.py -q <query> -o <offset> -p <resultsPerPage>'
        sys.exit(2)
    for opt, arg in opts:
        if opt == '-h':
            print 'query.py -q <query> -o <offset> -p <resultsPerPage>'
            sys.exit()
        elif opt in ("-q", "--query"):
            q = arg
        elif opt in ("-o", "--offset"):
            offset = int(arg)
        elif opt in ("-p", "--resultsPerPage"):
            rpp = int(arg)
    
    query(q, offset, rpp)

# Run the appropriate main method when starting the script
if __name__ == "__main__":
    main(sys.argv[1:])



