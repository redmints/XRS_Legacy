#!/bin/bash

docker run --detach --name projet_$1 -it -p $2:22/tcp save_$1
