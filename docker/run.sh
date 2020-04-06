#!/bin/bash

if [[ "$(docker ps -q -f ancestor=$1 2> /dev/null)" == "" ]]; then
        docker run --detach -it -p $2:22/tcp $1
else
        echo "déjà lancé"
fi
