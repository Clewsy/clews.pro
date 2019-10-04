# clews.pro


I am slowly removing my dependency on cloud services (google in particular) by self-hosting open alternatives.


Herein lies the docker-compose.yml file with which I establish my personal web site and various web apps under sub-domains.

I use this file with docker-compose to set up the following containers:
* nginx-proxy - [jwilder/nginx-proxy](https://hub.docker.com/r/jwilder/nginx-proxy) - used to reverse-proxy the  domain and sub-domains.
* letsencrypt - [jrcs/letsencrypt-nginx-proxy-companion](https://hub.docker.com/r/jrcs/letsencrypt-nginx-proxy-companion) - used for https encryption of the domain and sub-domains.
* nextcloud-app - [nextcloud](https://hub.docker.com/_/nextcloud) - my personal nextcloud instance.
* nextcloud-cron - [nextcloud-cronjob](https://hub.docker.com/r/rcdailey/nextcloud-cronjob) - used to regularly run the cron.php script for my nextcloud instance.
* mariadb-nextcloud - [mariadb](https://hub.docker.com/_/mariadb) - the database required by the nextcloud container.
* collabora-app - [collabora/code](https://hub.docker.com/r/collabora/code) - allows me to edit documents within my nextcloud instance.
* bitwarden-app - [bitwardenrs/server](https://hub.docker.com/r/bitwardenrs/server) - my personal password management server.
* nginx-clews.pro - [nginx](https://hub.docker.com/_/nginx) - clews.pro html and css.