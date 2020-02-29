# clews.pro

I am slowly removing my dependency on cloud services (google in particular) by self-hosting open alternatives.

Herein lies the docker-compose.yml file with which I establish my personal web site and various web apps under sub-domains.

I use this file with docker-compose to set up the following containers:
* nginx-proxy - [jwilder/nginx-proxy](https://hub.docker.com/r/jwilder/nginx-proxy) - used to reverse-proxy the  domain and sub-domains.
* letsencrypt - [jrcs/letsencrypt-nginx-proxy-companion](https://hub.docker.com/r/jrcs/letsencrypt-nginx-proxy-companion) - used for https encryption of the domain and sub-domains.
* nextcloud-app - [nextcloud](https://hub.docker.com/_/nextcloud) - my personal nextcloud instance.
* nextcloud-db - [linuxserver/mariadb](https://hub.docker.com/r/linuxserver/mariadb) - the database required by the nextcloud container.
* nextcloud-cron - [nextcloud-cronjob](https://hub.docker.com/r/rcdailey/nextcloud-cronjob) - used to regularly run the cron.php script for my nextcloud instance.
* nextcloud-bu - [clewsy/ncbu](https://hub.docker.com/r/clewsy/ncbu) - container for syncing the nextcloud data and database for convenient backup access.
* collabora-app - [collabora/code](https://hub.docker.com/r/collabora/code) - allows me to edit documents within my nextcloud instance.
* airsonic-app - [linuxserver/airsonic](https://hub.docker.com/r/linuxserver/airsonic) - for streaming my music collection - either via the web interface or an f-droid app (I like [UltraSonic](https://f-droid.org/en/packages/org.moire.ultrasonic/)).
* bitwarden-app - [bitwardenrs/server](https://hub.docker.com/r/bitwardenrs/server) - my personal password management server.
* calibre-app - [linuxserver/calibre](https://hub.docker.com/r/linuxserver/calibre) - for ebook management (converting, editing metadata, etc), only accessible locally.
* calibre-web-app - [linuxserver/calibre-web](https://hub.docker.com/r/linuxserver/calibre-web) - web-based ebook library, uses library/database created and managed by calibre-app.
* nginx-clews.pro - [nginx](https://hub.docker.com/_/nginx) - html and css files for my personal web site [clews.pro](https://clews.pro).

I switched from the official mariadb container for the nextcloud database to the linuxserver/mariadb container because the [linuxserver.io](https://www.linuxserver.io/) team allow you to specify uid and gid - this fixed the errors I encountered when attempting to create physical backups of database files belonging to an unknown user (uid 999).

The nextcloud-bu container (image: [clewsy/ncbu](https://hub.docker.com/r/clewsy/ncbu)) is my own project.  The source is on gitlab: [clewsy/ncbu](https://gitlab.com/clewsy/ncbu).  I tried a few different methods of backing up my nextcloud files and database but eventually decided it would be an ideal project for learning how to create my own docker image.

Also in this repo is a systemd unit file ([clews.service](https://gitlab.com/clewsy/clews.pro/blob/master/clews.service)).  I created this so that docker-compose is run automatically after a reboot of the host machine.
