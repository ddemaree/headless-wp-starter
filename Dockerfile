FROM wordpress:latest

WORKDIR /usr/src
RUN apt-get install -y curl

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
RUN chmod +x wp-cli.phar
RUN mv wp-cli.phar /usr/local/bin/wp

RUN curl -O http://robo.li/robo.phar
RUN chmod +x robo.phar && mv robo.phar /usr/bin/robo

ADD ./RoboFile.php /usr/src/RoboFile.php

RUN groupadd -r wordpress && useradd -m -r -g wordpress wordpress
RUN chown -R wordpress:wordpress /usr/src 
USER wordpress

RUN wp core download --version=4.8.2 --force
RUN wp core config --skip-check --dbname=wp_headless --dbuser=wp_headless --dbpass=wp_headless --dbhost=127.0.0.1

