# Import standard libraries
import MySQLdb
import MySQLdb.cursors
import re

# Import modules
import config

# Gets all the monuments from the database
def getMonuments():
    fields = ['name', 'description', 'mainCategory', 'subCategory', 'province', 'town', 'street', 'zipCode']
    db = getDatabase()
    db.execute('SELECT monument.id AS id, ' + ', '.join(fields) + ' FROM `monument`, `location` WHERE monument.location_id = location.id')
    rows = db.fetchall()
    monuments = []
    for row in rows:
        db.execute('SELECT tagname FROM tag, monuments_tags WHERE tag_id = id AND monument_id = ' + str(row['id']))
        trows = db.fetchall()
        tags = ', '.join([trow['tagname'] for trow in trows])
        row['tags'] = tags
        monuments.append(row)
    return monuments
   
# Returns a concatenated string from given documents using given fields and weights   
def getConcatenatedString(document, field_weights):
    """Gets a concatenated string based on given document and field_weights
        
    >>> getConcatenatedString({"test": "some testing", "bla": "stuff"}, {"test": 2, "bla": 1})
    ' some testing some testing  stuff '
    """
    result = ''
    for field in field_weights:
        result = result + ' ' + ((document[field]+' ') * field_weights[field])
    return result

# Returns a connection to the database
def getDatabase():
    dbhost = config.parameters.get('database_host')
    dbuser = config.parameters.get('database_user')
    dbpassword = config.parameters.get('database_password') 
    if dbpassword == None:
	    dbpassword = ''
    dbname = config.parameters.get('database_name')
    db = MySQLdb.connect(dbhost, dbuser, dbpassword, dbname, cursorclass=MySQLdb.cursors.DictCursor)
    return db.cursor()


if __name__ == "__main__":
    import doctest
    doctest.testmod()
