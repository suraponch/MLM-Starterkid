#!/bin/sh
set -e

# ตั้งค่า ownership ของโฟลเดอร์ storage และ cache ให้กับ user ของ Apache
# เพื่อให้ Laravel สามารถเขียนไฟล์ log และ cache ได้
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# รันคำสั่ง entrypoint เดิมของอิมเมจ (ซึ่งจะไปเรียก CMD ที่ตั้งไว้คือ "apache2-foreground")
exec docker-php-entrypoint "$@"