<!DOCTYPE html>
<html>
	<head>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/head.html"); ?>
	</head>
	<body>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.html"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">ncbu</h2>
			<a href="https://hub.docker.com/"><img class="image align-left" src="images/ncbu/ncbu_01.png" alt="Dockerhub" /></a>
			<h3>Description:</h3>
			<p>ncbu - or <a href="https://nextcloud.com/">NextCloud</a> Back-Up - is a <a href="https://www.docker.com/">docker</a> container image created to simplify and automate perodic physical snapshots of a self-hosted nextcloud service.  The snapshots serve as a backup of the nextcloud volume and also (if applicable) the nextcloud database volume.</p>
			<p>The intention is to run this image as a container alongside the nextcloud app and database containers.  Management of the "live" nextcloud/database volumes can therefore be left to docker.  When the ncbu back-up script is initialised, it first locks the nextcloud instance (i.e. puts nextcloud into maintenance mode) before syncing the volumes to a user-defined location.  Once complete, the script unlocks nextcloud so that normal usage can resume.</p>
			<p>By locking nextcloud first, ncbu ensures that the backup is effectively a "snapshot" of the nextcloud and database volumes.</p>
			<hr/>

			<h3>Why:</h3>
			<p>I discovered docker on my journey to rid myself of cloud-based services not within my control.  A docker implementation of nextcloud is great for robustness and portability.  It also facillitated simple back-ups by binding the data volumes to a user-accessible directory.  Initially I set up an <a href="https://rsync.samba.org/">rsync</a> cronjob to automate my backups and this was fine, but I saw potential benefits in containerising the backup service.  Mostly, I wanted to have a go at learning docker and creating my own container image.</p>
			<p>Now my backup automation is implmented simultaneously alongside the nextcloud and database containers thanks to <a href="https://docs.docker.com/compose/">docker-compose</a> and a single *.yml file.  Refer to my <a href="/projects/clews.php">clews.pro</a> project for more information of my self-hosting implementation.</p>
			<a href="https://nextcloud.com/"><img class="image align-right" src="images/ncbu/ncbu_02.png" alt="Nextcloud" /></a>
			<hr/>

			<h3>What:</h3>
			<p>Once spun up, provided the correct environment variables and volumes are defined, ncbu will run an initialisation script (<a href="https://gitlab.com/clewsy/ncbu/-/blob/master/root/ncbu_init">ncbu_init</a>) to do some basic error-checking, then it will simply kick off cron in the foreground.  There is a single cron job set (at a user-defined time, midnight every day by default) which will execute the backup script.</p>
			<p>The backup script (<a href="https://gitlab.com/clewsy/ncbu/-/blob/master/root/ncbu">ncbu</a>) will first put the nextcloud instance into maintenance mode, effectively "freezing" the nextcloud data files and database.  Rsync is then used to copy all of the files from the nextcloud and database volumes to a backup directory.  Once complete, maintenance mode is disabled.</p>
			<p>A third script within the container (<a href="https://gitlab.com/clewsy/ncbu/-/blob/master/root/ncbu_restore">ncbu_restore</a>) is used to restore nextcloud and database containers from a stored backup.  The restore script can only be run manually by the user.  It will similarly put nextcloud into maintenance mode and then sync all the nextcloud and database files in the reverse direction before exiting maintenance mode.  The restore script will also initialise a scan of the data files and update the database accordingly - this helps if the user is "restoring" to a new host.</p>
			<hr/>

			<h3>How:</h3>
			<p>The following commands may be useful, but much more detail can be found at the <a href="https://gitlab.com/clewsy/ncbu">gitlab</a> or <a href="https://hub.docker.com/r/clewsy/ncbu">dockerhub</a> repositories.</p>
			<hr/>

			<h4>Create the container:</h4>
			<p>Build from source:</p>
			<div class="code"><p class="terminal">
				$ git clone git@gitlab.com:clewsy/ncbu<br/>
				$ cd ncbu<br/>
				$ docker build -t ncbu/ncbu .
			</p></div>
			<p>Pull from <a href="https://hub.docker.com/r/clewsy/ncbu">dockerhub</a>:</p>
			<div class="code"><p class="terminal">
				$ docker pull clewsy/ncbu
			</p></div>
			<hr/>

			<h4>Run the container:</h4>
			<p>Run using the <i>docker run</i> command:</p>
			<div class="code"><p class="terminal">
				$ docker run -ti \<br/>
				-h ncbu \<br/>
				-e NEXTCLOUD_CONTAINER=nextcloud-app \<br/>
				-e NEXTCLOUD_DATABASE_CONTAINER=nextcloud-db \<br/>
				-e NEXTCLOUD_BACKUP_CRON="0 0 * * *" \<br/>
				-v /etc/localtime:/etc/localtime:ro \<br/>
				-v /var/run/docker.sock:/var/run/docker.sock:ro \<br/>
				-v nextcloud-app:/mnt/nextcloud-app \<br/>
				-v nextcloud-db:/mnt/nextcloud-db \<br/>
				-v ./nextcloud-bu:/backup \<br/>
				clewsy/ncbu
			</p></div>
			<p>Alternatively, a better/recommended method of running ncbu is via docker-compose.  Here is an <a href="https://gitlab.com/clewsy/clews.pro/blob/master/docker-compose.yml">example docker-compose.yml file</a>.</p>
			<div class="code"><p class="terminal">
				$ cd /home/docker <span class="comment">#Substitute directory for location of the docker-compose.yml file.</span><br/>
				$ docker-compose pull &amp;&amp; docker-compose up -d
			</p></div>
			<p>In any case, if configured correctly, the container should be running.  This can be confirmed by running the command <b>docker ps</b> (or <b>docker-compose ps</b> if using docker-compose).  The output of this command will show the status of all running containers.</p>
			<div class="code"><p class="terminal">
				$ cd /home/docker <span class="comment">#Substitute directory for location of the docker-compose.yml file.</span><br \>
				$ docker-compose ps
			</p></div>
			<div class="code"><table class="terminal">
				<tr>
					<td>Name</td>
					<td>Command</td>
					<td>State</td>
					<td>Ports</td>
				</tr>
				<tr>
					<td>-----------------</td>
					<td>---------------------------------</td>
					<td>---------------</td>
					<td>----------------------------------------</td>
				</tr>
				<tr>
					<td>collabora-app</td>
					<td>/bin/sh -c bash start-libr ...</td>
					<td>Up</td>
					<td>9980/tcp</td>
				</tr>
				<tr>
					<td>letsencrypt</td>
					<td>/bin/bash /app/entrypoint. ...</td>
					<td>Up</td>
					<td> </td>
				</tr>
				<tr>
					<td>nextcloud-app</td>
					<td>/entrypoint.sh apache2-for ...</td>
					<td>Up</td>
					<td>80/tcp</td>
				</tr>
				<tr>
					<td>nextcloud-bu</td>
					<td>ncbu_init</td>
					<td>Up (healthy)</td>
					<td> </td>
				</tr>
				<tr>
					<td>nextcloud-cron</td>
					<td>tini -- /entrypoint.sh</td>
					<td>Up (healthy)</td>
					<td> </td>
				</tr>
				<tr>
					<td>nextcloud-db</td>
					<td>/init</td>
					<td>Up</td>
					<td>3306/tcp</td>
				</tr>
				<tr>
					<td>nginx-proxy</td>
					<td>/app/docker-entrypoint.sh ...</td>
					<td>Up</td>
					<td>0.0.0.0:443->443/tcp, 0.0.0.0:80->80/tcp</td>
				</tr>
			</table></div>
			<p>I included a "healthcheck" script (<a href="https://gitlab.com/clewsy/ncbu/-/blob/master/root/ncbu_healthcheck">ncbu_healthcheck</a>) in the container image which is executed every 10 minutes.  As per the example above, the container state should read "Up (healthy)" if everything is running as expected.</p>
			<p>The script will identify the state as "unhealthy" if either of two conditions are met:</p>
			<ol>
				<li>The cron daemon (crond) is not running; or</li>
				<li>The user defined nextcloud app container ($NEXTCLOUD_CONTAINER) is missing/not running.</li>
			</ol>
			<hr/>

			<h4>Confirm successful initialisation of ncbu:</h4>
			<p> Confirm inintialisation was successful by checking the log.  This should clarify any errors that may have occurred.  Command below followed by output for a successful initialisation:</p>
			<div class="code"><p class="terminal">
				$ docker logs ncbu
			</p></div>
			<div class="code"><p class="terminal">
				<b>2020-03-30 11:13:29</b> - Initialising ncbu (nextcloud-backup)...<br/>
				<b>2020-03-30 11:13:29</b> - Checking environment variables provided:<br/>
				&emsp;&emsp;&emsp;	NEXTCLOUD_CONTAINER=nextcloud-app<br/>
				&emsp;&emsp;&emsp;	NEXTCLOUD_DATABASE_CONTAINER=nextcloud-db<br/>
				<b>2020-03-30 11:13:29</b> - Checking mounted volumes:<br/>
				&emsp;&emsp;&emsp;	Nextcloud app volume successfully mounted to /mnt/nextcloud_app<br/>
				&emsp;&emsp;&emsp;	Nextcloud database volume successfully mounted to /mnt/nextcloud_db<br/>
				<b>2020-03-30 11:13:29</b> - Checking backup volume:<br/>
				&emsp;&emsp;&emsp;	Backup exists.<br/>
				<b>2020-03-30 11:13:29</b> - Updating crontab with: "0 0 * * * ncbu"<br/>
				<b>2020-03-30 11:13:29</b> - Running crond in the foreground...
			</p></div>
			<hr/>

			<h4>Initiate a manual backup (with sample output):</h4>
			<div class="code"><p class="terminal">
				$ docker exec ncbu ncbu
			</p></div>
			<div class="code"><p class="terminal">
				<b>2020-03-30 10:22:14</b> - Running ncbu (nextcloud backup)...<br/>
				<b>2020-03-30 10:22:14</b> - Putting nextcloud-app into maintenance mode...<br/>
				&emsp;&emsp;&emsp;	Maintenance mode enabled<br/>
				<b>2020-03-30 10:22:14</b> - Nextcloud data backup: Syncing nextcloud-app volume to /backup...<br/>
				sending incremental file list<br/>
				config/config.php<br/>
				1.02K 100%    0.00kB/s    0:00:00 (xfr#1, ir-chk=1026/15502)<br/>
				<br/>
				sent 1.12M bytes  received 4.14K bytes  749.39K bytes/sec<br/>
				total size is 24.82G  speedup is 22,078.86<br/>
				<b>2020-03-30 10:22:15</b> - Finished nextcloud data sync.<br/>
				<b>2020-03-30 10:22:15</b> - Setting permission of nextcloud data directory to :33<br/>
				<b>2020-03-30 10:22:15</b> - Ensure user on host machine is part of group id GID=33 for read access to backup.<br/>
				<b>2020-03-30 10:22:15</b> - Nextcloud database backup (physical copy): Syncing nextcloud-db volume to /backup...<br/>
				sending incremental file list<br/>
				<br/>
				sent 9.77K bytes  received 18 bytes  19.58K bytes/sec<br/>
				total size is 691.70M  speedup is 70,661.44<br/>
				<b>2020-03-30 10:22:15</b> - Finished nextcloud database sync.<br/>
				<b>2020-03-30 10:22:15</b> - Taking nextcloud-app out of maintenance mode...<br/>
				&emsp;&emsp;&emsp;	Maintenance mode disabled<br/>
				<b>2020-03-30 10:22:15</b> - All done.
			</p></div>
			<hr/>

			<h4>Initiate restoration from a backup (with sample output):</h4>
			<div class="code"><p class="terminal">
				$ docker exec ncbu ncbu_restore
			</p></div>
			<div class="code"><p class="terminal">
				<b>2020-03-30 11:34:12</b> - Running ncbu restore...<br/>
				<b>2020-03-30 11:34:12</b> - Putting nextcloud-app into maintenance mode...<br/>
				Maintenance mode enabled<br/>
				<b>2020-03-30 11:34:12</b> - Nextcloud data restore from ncbu: Syncing /backup/nextcloud_app to nextcloud-app volume...<br/>
				sending incremental file list<br/>
				config/config.php<br/>
				&emsp;&emsp;&emsp;	1.02K 100%    0.00kB/s    0:00:00 (xfr#1, ir-chk=1026/15502)<br/>
				<br/>
				sent 1.12M bytes  received 4.14K bytes  749.46K bytes/sec<br/>
				total size is 24.82G  speedup is 22,079.13<br/>
				<b>2020-03-30 11:34:13</b> - Finished nextcloud data sync from backup.<br/>
				<b>2020-03-30 11:34:13</b> - Nextcloud database restore from ncbu physical copy: Syncing /backup/nextcloud_db to nextcloud-db volume...<br/>
				sending incremental file list<br/>
				<br/>
				sent 9.82K bytes  received 18 bytes  19.67K bytes/sec<br/>
				total size is 692.82M  speedup is 70,429.63<br/>
				<b>2020-03-30 11:34:13</b> - Finished nextcloud database sync from backup.<br/>
				<b>2020-03-30 11:34:13</b> - Taking nextcloud-app out of maintenance mode...<br/>
				Maintenance mode disabled<br/>
				<b>2020-03-30 11:34:14</b> - Scanning the nextcloud-app data files and updating the cache accordingly.<br/>
				&emsp;&emsp;&emsp;	(This may take a while but the nextcloud instance should be accessible while the scan runs.)<br/>
				Starting scan for user 1 out of 1 (jadon)<br/>
				&emsp;&emsp;&emsp;	Folder 			/jadon/<br/>
				&emsp;&emsp;&emsp;	Folder 			/jadon/files_trashbin<br/>
				&emsp;&emsp;&emsp;	Folder 			/jadon/files_trashbin/files<br/>
				&emsp;&emsp;&emsp;	File&emsp;&emsp;	/jadon/files_trashbin/files/Michael Crichton - Timeline.epub.d1581224543<br/>
				&emsp;&emsp;&emsp;	File&emsp;&emsp;	/jadon/files_trashbin/files/Nextcloud intro.mp4.d1580532366<br/>
				&emsp;&emsp;&emsp;	File&emsp;&emsp;	/jadon/files_trashbin/files/wami_irl_b4t-phone_daily_2020-02-28_b4t-phone.gpx.d1584916818<br/>
				&emsp;&emsp;&emsp;	File&emsp;&emsp;	/jadon/files_trashbin/files/wami_irl_monthly_2019-12_b4t-phone.gpx.d1584916819<br/>
				&emsp;&emsp;&emsp;	File&emsp;&emsp;	/jadon/files_trashbin/files/wami_irl_b4t-phone.gpx.d1580552369<br/>
				&emsp;&emsp;&emsp;	File&emsp;&emsp;	/jadon/files_trashbin/files/Screenshot from 2020-01-27 11-57-03.png.d1581051578<br/>
				&emsp;&emsp;&emsp;	File&emsp;&emsp;	/jadon/files_trashbin/files/wami_irl_b4t-phone_daily_2020-02-14_b4t-phone.gpx.d1584916817<br/>
				&emsp;&emsp;&emsp;	File&emsp;&emsp;	/jadon/files_trashbin/files/Screenshot from 2020-01-27 11-54-06.png.d1581051577<br/>
				&emsp;&emsp;&emsp;	File&emsp;&emsp;	/jadon/files_trashbin/files/Screenshot from 2020-01-27 11-53-25.png.d1581051587</p>
			</div>
			<h1><center>...</center></h1>
			<div class="code"><p class="terminal">
				&emsp;&emsp;&emsp;	Folder			/jadon/files_versions/InstantUpload/Camera/2020/02<br/>
				&emsp;&emsp;&emsp;	File&emsp;&emsp;	/jadon/files_versions/InstantUpload/Camera/2020/02/IMG_20200202_165550.jpg.v1580622950<br/>
				&emsp;&emsp;&emsp;	Folder			/jadon/files_versions/Photos<br/>
				<br/>
				+---------+-------+--------------+<br/>
				| Folders			| Files | Elapsed time				|<br/>
				+---------+-------+--------------+<br/>
				| 248&emsp;&emsp;&emsp;&emsp;	| 17352 | 00:03:04&emsp;&emsp;&emsp;&emsp;	|<br/>
				+---------+-------+--------------+<br/>
				<b>2020-03-30 11:38:44</b> - All done.
			</p></div>
			<hr/>

			<h3>Debugging:</h3>
			<p>To assist in tracking down any issues, the scripts output info to a logfile.  All output from any <i>rsync</i> commands also goes into the logs.</p>
			<p>The logfile is located within the <b>/backup</b> directory within the container.  Provided this directory is bound to another directory oin the host machine, then it can be read by the host.  If the previously referenced <a href="https://gitlab.com/clewsy/clews.pro/blob/master/docker-compose.yml">example docker-compose.yml</a>is used along with the demo configurations above, then the logfile will be located at <b>/home/docker/nextcloud-bu/ncbu.log</b>.  Example logs are shown below:
			<div class="code"><p class="terminal">
				$ cat /home/docker/nextcloud-bu/ncbu.log<br/>
				<br/>
				<b>2021-06-18 00:00:00</b> - Running ncbu (nextcloud backup)...<br/>
				<b>2021-06-18 00:00:00</b> - Putting nextcloud-app into maintenance mode...<br/>
				<b>2021-06-18 00:00:00</b> - Nextcloud data backup: Syncing nextcloud-app volume to /backup...<br/>
				2021/06/18 00:00:00 [35874] building file list<br/>
				2021/06/18 00:00:01 [35874] >f..t...... config/config.php<br/>
				2021/06/18 00:00:02 [35874] >f.st...... data/nextcloud.log<br/>
				2021/06/18 00:00:02 [35874] >f.st...... data/appdata_oc037zsrujze/appstore/apps.json<br/>
				2021/06/18 00:00:02 [35874] .d..t...... data/appdata_oc037zsrujze/preview/0/6/c/d/4/1/6/<br/>
			</p></div>
			<h1><center>...</center></h1>
			<div class="code"><p class="terminal">
				2021/06/18 00:00:06 [35874] sent 67.01M bytes  received 44.01K bytes  10.32M bytes/sec<br/>
				2021/06/18 00:00:06 [35874] total size is 34.27G  speedup is 511.07<br/>
				<b>2021-06-18 00:00:06</b> - Finished nextcloud data sync.<br/>
				<b>2021-06-18 00:00:06</b> - Setting permission of nextcloud data directory to :33<br/>
				<b>2021-06-18 00:00:07</b> - Ensure user on host machine is part of group id GID=33 for read access to backup.<br/>
				<b>2021-06-18 00:00:07</b> - Nextcloud database backup (physical copy): Syncing nextcloud-db volume to /backup...<br/>
				2021/06/18 00:00:07 [35901] building file list<br/>
				2021/06/18 00:00:07 [35901] >f..t...... databases/ib_logfile0<br/>
				2021/06/18 00:00:08 [35901] >f..t...... databases/ib_logfile1<br/>
			</p></div>
			<h1><center>...</center></h1>
			<div class="code"><p class="terminal">
				2021/06/18 00:00:10 [35901] >f.st...... log/mysql/mariadb-bin.index<br/>
				2021/06/18 00:00:10 [35901] sent 386.56M bytes  received 436 bytes  110.45M bytes/sec<br/>
				2021/06/18 00:00:10 [35901] total size is 878.59M  speedup is 2.27<br/>
				<b>2021-06-18 00:00:10</b> - Finished nextcloud database sync.<br/>
				<b>2021-06-18 00:00:10</b> - Taking nextcloud-app out of maintenance mode...<br/>
				<b>2021-06-18 00:00:10</b> - Rotating logfile if required...<br/>
				<b>2021-06-18 00:00:10</b> - All done.<br/>
			</p></div>
			<hr/>
			<a class="align-center" href="/index.php"><img src="/images/clews_logo.png" title="Logo" width="100" /></a>
		</div>
	</body>
</html>
