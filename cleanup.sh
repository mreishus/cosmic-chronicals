#!/bin/bash
export UID=$(id -u)
export GID=$(id -g)
echo "Stopping and removing all containers, networks, volumes, and images..."
docker-compose down -v --rmi all
echo "Removing any dangling images..."
docker image prune -f
echo "Cleanup complete. All Docker resources related to this project have been removed."
