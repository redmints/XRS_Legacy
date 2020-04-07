#!/bin/bash

sshpass -p f4212b127a ssh root@xeyrus.com -p $1 "useradd -m -s \"/bin/bash\" $2 && printf \"$3\n$3\n\" | passwd $2"
