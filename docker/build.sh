#!/bin/bash

docker build -f ../docker/$1.machine -t $1 .
docker run --detach --name projet_$1 -it $1
docker stop projet_$1
docker commit projet_$1 save_$1
docker rm projet_$1
