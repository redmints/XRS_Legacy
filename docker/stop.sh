#!/bin/bash

docker commit projet_$1 save_$1
docker rm $(docker stop $(docker ps -a -q --filter "name=projet_$1" --format="{{.ID}}"))
