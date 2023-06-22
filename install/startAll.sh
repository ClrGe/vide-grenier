#!/bin/bash
cd ./develop
docker-compose up -d
cd ../release
docker-compose up -d
cd ../production
docker-compose up -d
