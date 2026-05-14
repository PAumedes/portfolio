#!/bin/sh
set -e

# Use REDIS_PASSWORD env var if set, otherwise use default
PASSWORD="${REDIS_PASSWORD:-portfolio_redis_dev_password}"

# Start Redis with the password
exec redis-server --requirepass "$PASSWORD" --protected-mode yes
