FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
        cron \
        supervisor \
        libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && apt-get remove -y exim4 exim4-daemon-light exim4-base exim4-config \
    && apt-get autoremove -y \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN useradd -u 1000 -m phpuser

RUN mkdir -p /var/spool/cron/crontabs \
    && ln -s /tmp/crond.pid /var/run/crond.pid \
    && chown -R phpuser:phpuser /var/spool/cron /tmp

COPY crontab /etc/cron.d/app_cron
RUN chmod 0644 /etc/cron.d/app_cron \
    && chown root:root /etc/cron.d/app_cron \
    && crontab /etc/cron.d/app_cron

COPY scripts/test_cron.sh /usr/local/bin/test_cron.sh
RUN chmod +x /usr/local/bin/test_cron.sh

RUN mkdir -p /var/log/supervisor \
    && touch /var/log/supervisor/supervisord.log \
    && chmod -R 0755 /var/log/supervisor \
    && chmod -R 0755 /var/run

COPY supervisor.conf /etc/supervisor/supervisor.conf

WORKDIR /var/www/

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisor.conf"]
