# Import libraries
import gensim
import logging
import re
import sys
import math
import csv
import MySQLdb
from gensim import corpora, models, similarities

con = MySQLdb.connect('127.0.0.1', 'root', 'rootroot1', 'monubit')
con.autocommit(True)
cursor = con.cursor()

print '\033[1;33mFixing monument descriptions...\033[0;m'

# Get all monument identifiers
idlist = [line.strip() for line in open('monument_ids.txt')]
total = len(idlist)
point = total / 100
bar_size = 50
increment = total / bar_size
c = 1

# Get the correct descsriptions from the CSV file
data = []
csvReader = csv.reader(open('descriptions.csv', 'rb'), delimiter=";", quotechar='"')
csvReader.next()
for row in csvReader:
	if row[0] in idlist:
		# Update the MySQL database with the correct description from the CSV file
		contents = re.sub('\r\n', ' <br /> ', row[1])
		id = int(row[0])
		cursor.execute("UPDATE monument SET description = %s WHERE id = %s", (contents, id))
		done = int(math.floor(c / increment))
		todo = bar_size - done
		sys.stdout.write("\r\033[1;37m(\033[1;42m" + " " * done + "\033[1;47m" +  " " * todo + " \033[0;m\033[1;37m) " +  str(c / point) + "% (" + str(c) + "/" + str(total) + ")\033[0;m")
		sys.stdout.flush()
		c = c + 1

# Notify user everything completed
print '\n\033[1;32mDone!\033[0;m'
