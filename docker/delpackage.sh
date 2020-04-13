#!/bin/bash

sshpass -p f4212b127a ssh -o StrictHostKeychecking=no root@xeyrus.com -p $1 "apt-get autoremove -y --purge $2"
