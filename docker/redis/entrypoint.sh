#!/bin/sh
set -e

# Start Redis without password requirement in development
# Password is configured via environment variables in the client (Laravel config)
exec redis-server --protected-mode no
