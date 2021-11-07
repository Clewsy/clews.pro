# clews.pro

I am slowly removing my dependency on cloud services (google in particular) by self-hosting open alternatives.

Herein lies the [docker-compose.yml][link_repo_docker-compose.yml] file with which I establish my personal web site and various web apps under sub-domains.

I use this file with [docker-compose][link_web_docker-compose] to set up the following containers:

|Container Name |Image                                                                  |Website                                                 |Description                                                                                                                                                                                                      |
|---------------|-----------------------------------------------------------------------|--------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
|nginx-proxy    |[nginxproxy/nginx-proxy][link_dockerhub_nginxproxy_nginx_proxy]        |[nginx-proxy][link_github_nginx_proxy]                  |Used to reverse-proxy the domain and sub-domains  Formerly the image was named [jwilder/nginx-proxy][link_dockerhub_jwilder_nginx-proxy].                                                                        |
|acme-companion |[nginxproxy/acme-companion][link_dockerhub_nginxproxy_acme_companion]  |[acme-companion][link_github_nginx_proxy_acme_companion]|Used for automatic Let's Encrypt / ACME domain validation to facilitate encryption of the domain and sub-domains.  Formerly named [jrcs/letsencrypt-nginx-proxy-companion][link_dockerhub_jrcs_letsencrypt].     |
|nextcloud-app  |[/nextcloud][link_dockerhub_nextcloud]                                 |[Nextcloud][link_web_nextcloud]                         |My personal nextcloud instance.  General file storage.                                                                                                                                                           |
|nextcloud-db   |[linuxserver/mariadb][link_dockerhub_linuxserver_mariadb]              |[MariaDB][link_web_mariadb]                             |The database used by the nextcloud container.                                                                                                                                                                    |
|nextcloud-cron |[rcdailey/nextcloud-cronjob][link_dockerhub_rcdailey_nextcloud-cronjob]|[nextcloud-cronjob][link_github_nextcloud_cronjob]      |Used to regularly run the cron.php script for my nextcloud instance.                                                                                                                                             |
|nextcloud-bu   |[registry.gitlab.com/clewsy/ncbu][link_gitlab_clewsy_ncbu_container]                              |[ncbu][link_clews_ncbu]                                 |Container for syncing the nextcloud data and database for convenient backup access.                                                                                                                              |
|collabora-app  |[collabora/code][link_dockerhub_collabora_code]                        |[CODE][link_web_collabora_code]                         |Integrates with my nextcloud instance to facillitate online, web-based file editing.                                                                                                                             |
|navidrome-app  |[deluan/navidrome][link_dockerhub_deluan_navidrome]                    |[Navidrome][link_web_navidrome]                         |For streaming music - either via the webui or an f-droid app (I like [UltraSonic][link_web_ultrasonic]).                                                                                                         |
|vaultwarden-app|[vaultwarden/server][link_dockerhub_vaultwarden_server]                |[vaultwarden][link_github_vaultwarden]                  |My personal password management server (formerly known as [bitwardenrs/server][link_dockerhub_bitwardenrs]).                                                                                                     |
|calibre-app    |[linuxserver/calibre][link_dockerhub_linuxserver_calibre]              |[calibre][link_web_calibre]                             |For ebook management (converting, editing metadata, etc).  Only accessible locally.                                                                                                                              |
|calibre-web-app|[linuxserver/calibre-web][link_dockerhub_linuxserver_calibre-web]      |[calibre-web][link_github_calibre-web]                  |Web-based ebook library.  Uses library/database created and managed by calibre-app.                                                                                                                              |
|php            |[/php][link_dockerhub_php]                                             |[php][link_web_php]                                     |Accessed by nginx containers in order to execute php scripts.                                                                                                                                                    |
|nginx-clews.pro|[/nginx][link_dockerhub_nginx]                                         |[NGINX][link_web_nginx]                                 |Html and css files for my personal web site [clews.pro][link_clews].  The html and css for [clews.pro][link_clews] is also contained within this repository.                                                                   |
|nginx-clews.dev|[/nginx][link_dockerhub_nginx]                                         |[NGINX][link_web_nginx]                                 |Html and css files for my other personal web site [clews.dev][link_clews.dev].  The html and css for [clews.dev][link_clews.dev] is also contained within this repository.                                                         |
|nginx-clews.tech|[/nginx][link_dockerhub_nginx]                                         |[NGINX][link_web_nginx]                                 |Html and css files for one more personal web site [clews.tech][link_clews.tech].  The html and css for [clews.tech][link_clews.tech] is also contained within this repository.                                                                   |
|watchtower     |[containrrr/watchtower][link_dockerhub_watchtower]                     |[Watchtower][link_web_watchtower]                       |Configured to check for updated container images.  Will download and run automatically.                                                                                                                          |

---

I switched from the official mariadb container for the nextcloud database to the linuxserver/mariadb container because the [linuxserver.io][link_web_linuxserver] developers allow you to specify uid and gid - this fixed the errors I encountered when attempting to create physical backups of database files belonging to an unknown user (uid 999).

Another switch I made was the music-streaming service I use.  Previously I had [airsonic-advanced][link_dockerhub_airsonicadvanced_airsonic-advanced] set up, but I migrated to [navidrome][link_dockerhub_deluan_navidrome] which seems more modern and up-to-date.

The nextcloud-bu container (GitLab image: [registry.gitlab.com/clewsy/ncbu][link_gitlab_clewsy_ncbu_container], Docker Hub image: [clewsy/ncbu][link_dockerhub_clewsy_ncbu]) is my own project.  The source is on [gitlab][link_gitlab_clewsy_ncbu].  I tried a few different methods of backing up my nextcloud files and database but eventually decided it would be an ideal project for learning how to create my own docker image.  Originally I just hosted the image at Docker Hub, but changes have made it impossible to automate image builds without a paid account.  So I now recommend pulling the image from GitLab's container registry.

Also in this repo is a systemd unit file ([clews.service][link_repo_clews.service]).  I created this so that docker-compose is run automatically after a reboot of the host machine (just in case the containers were brought down).

The [clews.pro/html][link_repo_html] directory contains the html and css I developed for my personal web site.

![clews.pro][image_clews.pro]

[link_clews]:https://clews.pro
[link_clews_ncbu]:https://clews.pro/projects/ncbu.php
[link_clews.dev]:https://clews.dev
[link_clews.tech]:https://clews.tech

[link_dockerhub_airsonicadvanced_airsonic-advanced]:https://hub.docker.com/r/airsonicadvanced/airsonic-advanced
[link_dockerhub_bitwardenrs]:https://hub.docker.com/r/bitwardenrs/server
[link_dockerhub_clewsy_ncbu]:https://hub.docker.com/r/clewsy/ncbu
[link_dockerhub_collabora_code]:https://hub.docker.com/r/collabora/code
[link_dockerhub_deluan_navidrome]:https://hub.docker.com/r/deluan/navidrome
[link_dockerhub_netdata]:https://hub.docker.com/r/netdata/netdata
[link_dockerhub_nginx]:https://hub.docker.com/_/nginx
[link_dockerhub_nginxproxy_nginx_proxy]:https://hub.docker.com/r/nginxproxy/nginx-proxy
[link_dockerhub_nginxproxy_acme_companion]:https://hub.docker.com/r/nginxproxy/acme-companion
[link_dockerhub_jrcs_letsencrypt]:https://hub.docker.com/r/jrcs/letsencrypt-nginx-proxy-companion
[link_dockerhub_jwilder_nginx-proxy]:https://hub.docker.com/r/jwilder/nginx-proxy
[link_dockerhub_linuxserver_calibre]:https://hub.docker.com/r/linuxserver/calibre
[link_dockerhub_linuxserver_calibre-web]:https://hub.docker.com/r/linuxserver/calibre-web
[link_dockerhub_linuxserver_mariadb]:https://hub.docker.com/r/linuxserver/mariadb
[link_dockerhub_nextcloud]:https://hub.docker.com/_/nextcloud
[link_dockerhub_php]:https://hub.docker.com/_/php
[link_dockerhub_rcdailey_nextcloud-cronjob]:https://hub.docker.com/r/rcdailey/nextcloud-cronjob
[link_dockerhub_vaultwarden_server]:https://hub.docker.com/r/vaultwarden/server
[link_dockerhub_watchtower]:https://hub.docker.com/r/containrrr/watchtower

[link_github_calibre-web]:https://github.com/janeczku/calibre-web
[link_github_nextcloud_cronjob]:https://github.com/rcdailey/nextcloud-cronjob
[link_github_nginx_proxy]:https://github.com/nginx-proxy/nginx-proxy
[link_github_nginx_proxy_acme_companion]:https://github.com/nginx-proxy/acme-companion
[link_github_vaultwarden]:https://github.com/dani-garcia/vaultwarden

[link_gitlab_clewsy_ncbu]:https://gitlab.com/clewsy/ncbu
[link_gitlab_clewsy_ncbu_container]:https://gitlab.com/clewsy/ncbu/container_registry

[link_repo_docker-compose.yml]:docker-compose.yml
[link_repo_clews.service]:clews.service
[link_repo_html]:clews.pro/html

[link_web_calibre]:https://calibre-ebook.com/
[link_web_collabora_code]:https://www.collaboraoffice.com/code/
[link_web_docker-compose]:https://docs.docker.com/compose/
[link_web_mariadb]:https://mariadb.org/
[link_web_navidrome]:https://www.navidrome.org/
[link_web_nextcloud]:https://nextcloud.com/
[link_web_nginx]:https://nginx.org/
[link_web_php]:https://www.php.net/
[link_web_ultrasonic]:https://f-droid.org/en/packages/org.moire.ultrasonic/
[link_web_linuxserver]:https://www.linuxserver.io/
[link_web_watchtower]:https://containrrr.dev/watchtower/

[image_clews.pro]:clews.pro/html/images/clews_logo/clews_logo_00.png
