FROM redis:7-alpine

EXPOSE 6379

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD redis-cli ping

CMD ["redis-server", "--requirepass", "${REDIS_PASSWORD:-portfolio_redis_dev_password}", "--protected-mode", "yes"]
