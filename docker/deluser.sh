#!/bin/bash

sshpass -p f4212b127a ssh root@xeyrus.com -p $1 "userdel $2"
