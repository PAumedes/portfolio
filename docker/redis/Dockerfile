FROM redis:7-alpine

COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 6379

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD redis-cli -a "${REDIS_PASSWORD:-portfolio_redis_dev_password}" ping

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
