#!/bin/bash
cd ./release
docker-compose down --volumes
docker-compose up --build -d