#!/bin/bash
cd ./production
docker-compose down --volumes
docker-compose up --build -d

docker exec site-grenier-Prod sh -c ./pull.sh