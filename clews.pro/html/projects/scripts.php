<!DOCTYPE html>
<html>
	<head>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/head.html"); ?>
	</head>
	<body>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.html"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">scripts</h2>
			<p>An assortment of bash scripts I have developed for various reasons.  For the most part, they just make it faster or simpler for me to carry out certain tasks.  These are all available on <a href="https://gitlab.com/clewsy/scripts">gitlab</a>.  Click on the script name to go directly to the gitlab page.</p>
			<table class="text-table">
				<tr>
					<th scope="col">Name</th>
					<th scope="col">Description</th>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/apt_all.sh">apt_all.sh</a></th>
					<td>Runs apt-get update, apt-get dist-upgrade, apt-get autoremove and apt-get autoclean on a provided host or list of hosts.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/ball.sh">ball.sh</a></th>
					<td>Runs bu.sh on a bunch of remote host or list of hosts.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/bu.sh">bu.sh</a></th>
					<td>Uses rsync to back up files and directories in a list file to a remote server.  Falls back to scp if rsync is not installed.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/p0wer_switch.sh">p0wer_switch.sh</a></th>
					<td>Written for use with termux (android) to connect to a server that can control wireless mains outlets via p0wer (<a href="https://gitlab.com/Clewsy/p0wer">gitlab link</a>).</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/pong.sh">pong.sh</a></th>
					<td>Runs through a list of servers, pings each once for a second then returns a success or fail result.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/polly.sh">polly.sh</a></th>
					<td>Called as a cronjob to regularly poll a web site and check the return code.  Logs site status to file and uses a <a href="https://blink1.thingm.com/">blink(1)</a> as a visual status indicator.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/roll_out.sh">roll_out.sh</a></th>
					<td>Attempt to copy a specified file/directory to a destination (relative to home directory) on a list of remote hosts.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/stuff.sh">stuff.sh</a></th>
					<td>Pulls and lists a bunch of useful (to me) info about the host (hardware, disks/mounts, OS, network).</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/vpn.sh">vpn.sh</a></th>
					<td>Kills current openvpn service then reconnects and confirms.  Useful for quickly re-establishing connection if it goes bad.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/wami.sh">wami.sh</a></th>
					<td>Pulls and displays info (IP, country, city, etc) from "ipinfo.io" - useful to verify vpn operation.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/whodis.sh">whodis.sh</a></th>
					<td>Grabs the contents of the /tmp/dhcp.leases file on a remote router, pretties it up and prints it to stdout.</td>
				</tr>
			</table>
			<br />
			<br />
			<h2 class="align-center">Archived scripts</h2>
			<p>Additional assorted scripts I developed but no longer use.  These are still available on <a href="https://gitlab.com/clewsy/scripts/archive">gitlab</a>.  Click on the script name to go directly to the gitlab page.</p>
			<table class="text-table">
				<tr>
					<th scope="col">Name</th>
					<th scope="col">Description</th>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/archive/cal_backup.sh">cal_backup.sh</a></th>
					<td>Generates an *.ics file from a nextcloud calendar and archives it.  Intended to be used as a cronjob.  No longer used since migrating my nextcloud service to a docker container.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/archive/chuck.sh">chuck.sh</a></th>
					<td>Very similar to grab.sh, but used to upload to the remote server.  Originally used to circumvent some corporate proxy restrictions - no longer used.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/archive/grab.sh">grab.sh</a></th>
					<td>Uses rsync (to allow resume after interruption) to download a specified file from a remote server.  Originally used to circumvent some corporate proxy restrictions - no longer used.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/archive/nc_backup.sh">nc_backup.sh</a></th>
					<td>Creates a local copy of all the important files related to a nextcloud instance - including a mysqldump of the database.  No longer used since migrating my nextcloud service to a docker container.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/archive/ytdl.sh">ytdl.sh</a></th>
					<td>ytdl.sh - Written for use with termux (android) to download a youtube video direct to the device.  Archived as I no longer use this since switching to <a href="https://lineageos.org/">LineageOS</a> and running <a href="https://newpipe.schabi.org/">NewPipe</a> instead of the youtube app.  Newpipe has direct download capability.</td>
				</tr>
			</table>
		</div>
	</body>
</html>
