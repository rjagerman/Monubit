# Import standard libraries
import MySQLdb
import MySQLdb.cursors
import re

# Import modules
import config

# Gets all the monuments from the database
def getMonuments():
    fields = ['name', 'description', 'subCategory', 'province', 'town', 'street', 'zipCode']
    db = getDatabase()
    db.execute('SELECT monument.id AS id, ' + ', '.join(fields) + ' FROM `monument`, `location` WHERE monument.location_id = location.id')
    rows = db.fetchall()
    monuments = [row for row in rows]
    return monuments
   
# Returns a concatenated string from given documents using given fields and weights   
def getConcatenatedString(documents, field_weights):
    result = []
    for document in documents:
        text = ''
        for field in field_weights:
            text = text + ' ' + ((document[field]+' ') * field_weights[field])
        result.append(text)
    return result

# Returns a connection to the database
def getDatabase():
    dbhost = config.parameters.get('database_host')
    dbuser = config.parameters.get('database_user')
    dbpassword = config.parameters.get('database_password')
    dbname = config.parameters.get('database_name')
    db = MySQLdb.connect(dbhost, dbuser, dbpassword, dbname, cursorclass=MySQLdb.cursors.DictCursor)
    return db.cursor()
