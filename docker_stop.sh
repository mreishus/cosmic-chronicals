#!/bin/bash
export UID=$(id -u)
export GID=$(id -g)
echo "Stopping all containers..."
docker-compose stop
echo "All containers have been stopped."
