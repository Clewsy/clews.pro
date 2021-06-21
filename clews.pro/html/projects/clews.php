<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.php"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">clews.pro</h2>
			<a href="images/clews/clews_01.png"><img class="photo align-left" src="images/clews/clews_01.png" alt="Whoah." /></a>
			<p>Clews.pro is this web site.  A place to document my various projects.  I do this mostly just for fun and education.</p>
			<p>I started with the knowledge of installing apache, exposing port 80 and some very basic HTML skills.</p>
			<p>Now I have a modular set of web apps served at different subdomains and all encrypted with SSL.</p>
			<p>To further develop said HTML skills and additionally learn CSS, I made my way through <a href="http://www.htmlandcssbook.com/"><i>HTML & CSS</i> by Jon Duckett</a>.</p>
			<p>Initially I used a small amount of javascript for the sole purpose of duplicating a common header across multiple pages.  I since learned that the same functionality is super easy with PHP so clews.pro no longer uses any javascript.</p>
			<p>Containerisation of this site and various subdomains has been implemented with <a href="https://docs.docker.com/">docker</a> and <a href="https://docs.docker.com/compose/">docker-compose</a>.  I wish I discovered Docker sooner!  It makes backing-up very straightforward.  It also allows me to tear it all down then pull it all back up on a different machine in a flash.  This part is made even easier thanks to <a href="https://docs.ansible.com/">ansible</a> automation and the playbooks/roles I made for deployment, configuration and maintenance of these containers (see project <a href="/projects/clewsy_ansible.php">clewsy_ansible</a>).</p>
			<p>The <a href="https://gitlab.com/clewsy/clews.pro/-/blob/master/docker-compose.yml">docker-compose.yml</a> file pulls the following container images:</p>
			<table class="text-table">
				<tr><td style="width: 180px"><b>Container</b></td><td style="width: 260px"><b>Image</b></td>						<td><b>Description</b></td></tr>
				<tr><td>nginx-proxy</td>	<td><a href="https://hub.docker.com/r/nginxproxy/nginx-proxy">nginxproxy/nginx-proxy</a></td>		<td>Used to reverse-proxy multiple domains and subdomains.</td></tr>
				<tr><td>acme-companion</td>	<td><a href="https://hub.docker.com/r/nginxproxy/acme-companion">nginxproxy/acme-companion</a></td>	<td>Used to implement certificates and encryption for sites served by nginx-proxy.</td></tr>
				<tr><td>Nextcloud</td>		<td><a href="https://hub.docker.com/_/nextcloud">nextcloud</a></td>					<td>Web app for file storage and a bunch of other features.  My method of replacing google drive.</td></tr>
				<tr><td>MariaDB</td>		<td><a href="https://hub.docker.com/r/linuxserver/mariadb">linuxserver/mariadb</a></td>			<td>Database linked to the Nextcloud container.</td></tr>
				<tr><td>Nextcloud-Cronjob</td>	<td><a href="https://hub.docker.com/r/rcdailey/nextcloud-cronjob">rcdailey/nextcloud-cronjob</a></td>	<td>Used for scheduled execution of Nextcloud's cron.php script.  As an aside, I <a href="https://github.com/rcdailey/nextcloud-cronjob/commit/e90dcc60d206c21749f8b8bc054e045cb3867446">contributed</a> to this project with a minor <a href="https://github.com/rcdailey/nextcloud-cronjob/pull/4">pull request</a> that reduced the container image size by about 75%.</td></tr>
				<tr><td>ncbu</td>		<td><a href="https://hub.docker.com/r/clewsy/ncbu">clewsy/ncbu</a></td>					<td>I <a href="/projects/ncbu.php">created</a> this container image to simplify automated backups of my nextcloud data and database.</td></tr>
				<tr><td>Collabora</td>		<td><a href="https://hub.docker.com/r/collabora/code">collabora/code</a></td>				<td>Implemented to enable web-based editing of documents/spreadsheets within the Nextcloud instance.</td></tr>
				<tr><td>Navidrome</td>		<td><a href="https://hub.docker.com/r/deluan/navidrome">deluan/navidrome</a></td>			<td>Music library and streaming app.  Stream via web interface or android app (such as <a href="https://www.f-droid.org/en/packages/org.moire.ultrasonic/">UltraSonic</a>).</td></tr>
				<tr><td>Calibre</td>		<td><a href="https://hub.docker.com/r/linuxserver/calibre">linuxserver/calibre</a></td>			<td>Ebook library/database management system.</td></tr>
				<tr><td>Calibre-Web</td>	<td><a href="https://hub.docker.com/r/linuxserver/calibre-web">linuxserver/calibre-web</a></td>		<td>Web-based ebook library access system.</td></tr>
				<tr><td>Vaultwarden</td>	<td><a href="https://hub.docker.com/r/vaultwarden/server">vaultwarden/server</a></td>			<td>Password management system (formerly bitwardenrs/server). </td></tr>
				<tr><td>NGINX</td>		<td><a href="https://hub.docker.com/_/nginx">nginx</a></td>						<td>For serving up the html/css/php that forms this (and other) sites.</td></tr>
				<tr><td>PHP</td>		<td><a href="https://hub.docker.com/_/php">php</a></td>							<td>Configured for access by NGINX containers to enable serving php scripts.</td></tr>
				<tr><td>Watchtower</td>		<td><a href="https://hub.docker.com/r/containrrr/watchtower">containrrr/watchtower</a></td>		<td>Periodically checks for updates to all container images.  Downloads and runs when new images are discovered.</td></tr>
			</table>
			<p>The logo for clews.pro also intended to be a learning exercise - this time in vector graphics editing - specifically <a href="https://inkscape.org/">Inkscape</a>.</p>
			<p> I've been doodling the <a href="https://en.wikipedia.org/wiki/Penrose_triangle">Penrose triangle</a> since I discovered it in primary school, so it served as a geometric starting point.  I exploded it into the three identical but rotated parts and rearranged them to differ from the original.  I felt the result was a bit too angular/aggressive, so I put the whole thing into a circle.  I clearly lack the designer gene but it serves the purpose.</p>
			<p><a class="align-center" href="images/clews/clews_02.png"><img class="photo" src="images/clews/clews_02.png" alt="I don't know what I'm doing." /></a></p>
		</div>
	</body>
</html>
