#!/bin/bash
cd ./develop
docker-compose down
cd ../release
docker-compose down
cd ../production
docker-compose down
