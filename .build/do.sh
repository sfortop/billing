set -x

while ! mysqladmin ping -h"$MYSQL_HOST" --silent; do
    sleep 1
done

vendor/bin/phinx migrate -c config/phinx.php

composer clear-config-cache

cd /var/www/billing/public
php-fpm > /var/log/php-fpm.billing.log &
nginx -g "daemon off;"