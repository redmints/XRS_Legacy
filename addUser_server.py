import psycopg2
import sys
from os import urandom

"""
Usage : python addUser.py NOM Prenom status
"""

chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789"
password = "".join(chars[ord(c) % len(chars)] for c in urandom(10))

mydb = psycopg2.connect(
  host="127.0.0.1",
  port="5432",
  user="xeyrus",
  password="ov7pZUn<FJh>n4VM",
  database="xeyrus"
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
