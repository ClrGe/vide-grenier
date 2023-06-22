#!/bin/bash
cd ./release
docker-compose down --volumes
docker-compose up --build -d

docker exec site-grenier-release sh -c ./pull.sh