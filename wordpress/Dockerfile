FROM wordpress:latest

# Install unzip to unpack plugins
RUN apt-get update && apt-get install -y unzip

# Tell PHP to allow larger uploads
COPY uploads.ini /usr/local/etc/php/conf.d/uploads.ini

# Install wp-cli to /usr/local/bin/wp
ADD https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar /usr/local/bin/wp
RUN chmod +rx /usr/local/bin/wp

# Remove default themes and install Postlight headless theme
RUN rm -r /usr/src/wordpress/wp-content/themes/twenty*
COPY wp-content/themes/postlight-headless-wp /usr/src/wordpress/wp-content/themes/postlight-headless-wp

# Copy plugins from this repo into wp-content
# TODO: Load these ones too from wordpress.org
COPY wp-content/plugins/advanced-custom-fields-pro /usr/src/wordpress/wp-content/plugins/advanced-custom-fields-pro 
COPY wp-content/plugins/acf-to-wp-api /usr/src/wordpress/wp-content/plugins/acf-to-wp-api 
COPY wp-content/plugins/custom-post-type-ui /usr/src/wordpress/wp-content/plugins/custom-post-type-ui 

# Auth0 plugin (allows federated login)
# TODO: Write script to remove all this repeated shit
RUN curl -o auth0.zip -SL https://downloads.wordpress.org/plugin/auth0.zip \
      && unzip auth0.zip -d /usr/src/wordpress/wp-content/plugins/ \
      && rm auth0.zip

# Gutenberg editor beta
RUN curl -o gutenberg.zip -SL https://downloads.wordpress.org/plugin/gutenberg.zip \
      && unzip gutenberg.zip -d /usr/src/wordpress/wp-content/plugins/ \
      && rm gutenberg.zip

# WordPress data importer
RUN curl -o wordpress-importer.zip -SL https://downloads.wordpress.org/plugin/wordpress-importer.zip \
      && unzip wordpress-importer.zip -d /usr/src/wordpress/wp-content/plugins/ \
      && rm wordpress-importer.zip

# Google Cloud Storage for assets
RUN curl -o gcs.zip -SL https://downloads.wordpress.org/plugin/gcs.zip \
      && unzip gcs.zip -d /usr/src/wordpress/wp-content/plugins/ \
      && rm gcs.zip

# Remove default plugins
RUN rm /usr/src/wordpress/wp-content/plugins/hello.php
RUN rm -r /usr/src/wordpress/wp-content/plugins/akismet

COPY ./wp-config-sample.php /usr/src/wordpress/wp-config-sample.php
COPY ./wp-config.php /usr/src/wordpress/wp-config.php

RUN chown -R www-data:www-data /usr/src/wordpress

RUN mkdir -p /var/www/sites/wordpress
RUN cp -R /usr/src/wordpress/* /var/www/sites/wordpress/
RUN chown -R www-data:www-data /var/www/sites/wordpress

# Replace default site config so that Apache will use the WP build outside the volume
COPY ./default-site.conf /etc/apache2/sites-available/000-default.conf
COPY ./htaccess.conf /var/www/sites/wordpress/.htaccess
RUN chown www-data:www-data /var/www/sites/wordpress/.htaccess

CMD apache2-foreground
