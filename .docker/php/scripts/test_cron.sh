#!/bin/bash

# Цикл 12 раз по 5 секунд
for i in {1..12}; do
  echo "[cron-test] $(date '+%Y-%m-%d %H:%M:%S')" >> /var/log/test_cron.log
  sleep 5
done
