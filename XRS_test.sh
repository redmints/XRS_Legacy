#!/bin/bash
if ping -c 1 8.8.8.8 &> /dev/null
then
  exit 0
else
  exit 1
fi
