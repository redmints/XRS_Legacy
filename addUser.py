import mysql.connector
import sys
from os import urandom

"""
Usage : python addUser.py NOM Prenom status
"""

chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789"
password = "".join(chars[ord(c) % len(chars)] for c in urandom(10))

mydb = mysql.connector.connect(
  host="localhost",
  port="8889",
  user="root",
  passwd="root",
  database="XRS_bdd"
)

mycursor = mydb.cursor()

sql = "INSERT INTO utilisateur (nom, prenom, email, password, status) VALUES (%s, %s, %s, %s, %s)"
val = (sys.argv[1], sys.argv[2], "", "", sys.argv[3])
mycursor.execute(sql, val)

sql = "INSERT INTO cle (valeur, id_utilisateur) VALUES (%s, %s)"
val = (password, mycursor.lastrowid)
mycursor.execute(sql, val)
mydb.commit()

print sys.argv[1]
print sys.argv[2]
print password
