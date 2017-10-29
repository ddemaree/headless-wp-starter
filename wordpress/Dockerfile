FROM wordpress:latest

# COPY wp-content/plugins/* /usr/src/wordpress/wp-content/plugins/
WORKDIR /usr/src/wordpress/wp-content
COPY wp-content/plugins/advanced-custom-fields-pro plugins/advanced-custom-fields-pro 
COPY wp-content/plugins/acf-to-wp-api plugins/acf-to-wp-api 
COPY wp-content/themes/postlight-headless-wp themes/postlight-headless-wp
RUN rm plugins/hello.php
RUN rm -r plugins/akismet
RUN rm -r themes/twenty* 

ADD wp-content/plugins/gcs.zip plugins/gcs 
# ADD --chown=www-data:www-data https://downloads.wordpress.org/plugin/gcs.0.1.3.zip plugins/
# RUN unzip plugins/gcs.0.1.3.zip