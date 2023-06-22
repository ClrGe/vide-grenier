#!/bin/bash
cd ./develop
docker-compose down --volumes 
cd ../release
docker-compose down --volumes 
cd ../production
docker-compose down --volumes 
