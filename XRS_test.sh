#!/bin/bash
if ping -c 1 8.8.8.8 &> /dev/null
then
  echo 0
else
  echo 1
fi
