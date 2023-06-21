#!/bin/bash
cd ./develop
docker-compose up -d --build
cd ../release
docker-compose up -d --build
cd ../production
docker-compose up -d --build
