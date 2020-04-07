#!/bin/bash

docker run --detach -it -p $2:22/tcp $1
