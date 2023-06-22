#!/bin/bash
cd ./develop
docker-compose up -d --build
cd ../release
docker-compose up -d --build
docker exec site-grenier-release sh -c ./pull.sh
cd ../production
docker-compose up -d --build
docker exec site-grenier-Prod sh -c ./pull.sh
