#!/bin/bash
cd ./production
docker-compose down --volumes
docker-compose up --build -d

docker exec site-grenier-prod sh -c ./pull.sh