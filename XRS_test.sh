#!/bin/bash
if ping -c 1 gshertjhtr.gt &> /dev/null
then
  echo 0
else
  echo 1
fi
