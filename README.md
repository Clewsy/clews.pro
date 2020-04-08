# clews.pro

I am slowly removing my dependency on cloud services (google in particular) by self-hosting open alternatives.

Herein lies the docker-compose.yml file with which I establish my personal web site and various web apps under sub-domains.

I use this file with docker-compose to set up the following containers:
* nginx-proxy - [jwilder/nginx-proxy][link_dockerhub_jwilder_nginx-proxy] - used to reverse-proxy the  domain and sub-domains.
* letsencrypt - [jrcs/letsencrypt-nginx-proxy-companion][link_dockerhub_jrcs_letsencrypt] - used for https encryption of the domain and sub-domains.
* nextcloud-app - [nextcloud][link_dockerhub_nextcloud] - my personal nextcloud instance.
* nextcloud-db - [linuxserver/mariadb][link_dockerhub_linuxserver_mariadb] - the database required by the nextcloud container.
* nextcloud-cron - [rcdailey/nextcloud-cronjob][link_dockerhub_rcdailey_nextcloud-cronjob] - used to regularly run the cron.php script for my nextcloud instance.
* nextcloud-bu - [clewsy/ncbu][link_dockerhub_clewsy_ncbu] - container for syncing the nextcloud data and database for convenient backup access.
* collabora-app - [collabora/code][link_dockerhub_collabora_code] - allows me to edit documents within my nextcloud instance.
* airsonic-app - [linuxserver/airsonic][link_dockerhub_linuxserver_airsonic] - for streaming my music collection - either via the web interface or an f-droid app (I like [UltraSonic][link_web_ultrasonic]).
* bitwarden-app - [bitwardenrs/server][link_dockerhub_bitwardenrs_server] - my personal password management server.
* calibre-app - [linuxserver/calibre][link_dockerhub_linuxserver_calibre] - for ebook management (converting, editing metadata, etc), only accessible locally.
* calibre-web-app - [linuxserver/calibre-web][link_dockerhub_linuxserver_calibre-web] - web-based ebook library, uses library/database created and managed by calibre-app.
* nginx-clews.pro - [nginx][link_dockerhub_nginx] - html and css files for my personal web site [clews.pro][link_clews].  The html and css for clews.pro is also contained within this repository.

I switched from the official mariadb container for the nextcloud database to the linuxserver/mariadb container because the [linuxserver.io][link_web_linuxserver] developers allow you to specify uid and gid - this fixed the errors I encountered when attempting to create physical backups of database files belonging to an unknown user (uid 999).

The nextcloud-bu container (docker image: [clewsy/ncbu][link_dockerhub_clewsy_ncbu] is my own project.  The source is on gitlab: [clewsy/ncbu][link_gitlab_clewsy_ncbu].  I tried a few different methods of backing up my nextcloud files and database but eventually decided it would be an ideal project for learning how to create my own docker image.

Also in this repo is a systemd unit file ([clews.service][link_repo_clews.service]).  I created this so that docker-compose is run automatically after a reboot of the host machine.

The [clews.pro/html][link_repo_html] directory contains the html and css I developed for my personal web site.

![clews.pro][image_clews.pro]

[link_dockerhub_jwilder_nginx-proxy]:https://hub.docker.com/r/jwilder/nginx-proxy
[link_dockerhub_jrcs_letsencrypt]:https://hub.docker.com/r/jrcs/letsencrypt-nginx-proxy-companion
[link_dockerhub_nextcloud]:https://hub.docker.com/_/nextcloud
[link_dockerhub_linuxserver_mariadb]:https://hub.docker.com/r/linuxserver/mariadb
[link_dockerhub_rcdailey_nextcloud-cronjob]:https://hub.docker.com/r/rcdailey/nextcloud-cronjob
[link_dockerhub_clewsy_ncbu]:https://hub.docker.com/r/clewsy/ncbu
[link_dockerhub_collabora_code]:https://hub.docker.com/r/collabora/code
[link_dockerhub_linuxserver_airsonic]:https://hub.docker.com/r/linuxserver/airsonic
[link_dockerhub_bitwardenrs_server]:https://hub.docker.com/r/bitwardenrs/server
[link_dockerhub_linuxserver_calibre]:https://hub.docker.com/r/linuxserver/calibre
[link_dockerhub_linuxserver_calibre-web]:https://hub.docker.com/r/linuxserver/calibre-web
[link_dockerhub_nginx]:https://hub.docker.com/_/nginx
[link_web_ultrasonic]:https://f-droid.org/en/packages/org.moire.ultrasonic/
[link_web_linuxserver]:https://www.linuxserver.io/
[link_gitlab_clewsy_ncbu]:https://gitlab.com/clewsy/ncbu
[link_repo_clews.service]:https://gitlab.com/clewsy/clews.pro/blob/master/clews.service
[link_repo_html]:https://gitlab.com/clewsy/clews.pro/-/tree/master/clews.pro/html
[link_clews]:https://clews.pro

[image_clews.pro]:https://clews.pro/images/clews_logo.png
