# Import libraries
import re

# Get the stoplist to remove stopwords
stoplist = [line.strip() for line in open('monubit/search/stoplist.txt')]

# Tokenises a string into a collection of wors
def tokenize(str):
    """Tokenizes a string
        
    >>> tokenize("test string")
    ['test', 'string']
    >>> tokenize("test longer. string, with extra (characters)!")
    ['test', 'longer', 'string', 'with', 'extra', 'characters']
    """

    # Extract tokens
    str = re.sub('-', '', str.lower())
    tokens = re.sub('[^a-zA-Z0-9]', ' ', str).split()
    
    # Return the unigrams after removing stopwords
    return [token for token in tokens if token not in stoplist]

if __name__ == "__main__":
    import doctest
    doctest.testmod()