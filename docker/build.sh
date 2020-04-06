#!/bin/bash

docker build -f ../docker/$1.machine -t $1 .
