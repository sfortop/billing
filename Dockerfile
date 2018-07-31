FROM fortop/php:core

ARG ENV=dev
COPY . /var/www/billing
COPY ./.build/do.sh /bin/do.sh
COPY "./.build/www.$ENV.conf" /usr/local/etc/php-fpm.d/www.conf
COPY .build/billing.nginx.conf /etc/nginx/sites-enabled/default
COPY .build/log.nginx.conf /etc/nginx/conf.d/
COPY ./.build/fpm-config.ini /usr/local/etc/php/conf.d/
#WORKDIR /tmp
#RUN wget https://dev.mysql.com/get/mysql-apt-config_0.8.10-1_all.deb
#RUN echo DEBIAN_FRONTEND
#RUN export DEBIAN_FRONTEND=noninteractive \
#&& echo mysql-apt-config mysql-apt-config/enable-repo select mysql-8-dmr | debconf-set-selections
#RUN dpkg -i mysql-apt-config_0.8.10-1_all.deb
#RUN rm /tmp/mysql-apt-config_0.8.10-1_all.deb
WORKDIR /var/www/billing

RUN composer install -n --no-progress
CMD ["bash","-c","/bin/do.sh"]

