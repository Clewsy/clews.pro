<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.php"); ?>
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
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/apt_all">apt_all</a></th>
					<td>Runs apt-get update, apt-get dist-upgrade, apt-get autoremove and apt-get autoclean on a provided host or list of hosts.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/p0wer_switch">p0wer_switch</a></th>
					<td>Written for use with <a href="https://termux.com/">termux</a> to connect to a server that can control wireless mains outlets via <a href="https://gitlab.com/Clewsy/p0wer">p0wer</a>.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/polly">polly</a></th>
					<td>Called as a cronjob to regularly poll a web site and check the return code.  Logs the result and uses a <a href="https://blink1.thingm.com/">blink(1)</a> as a visual status indicator.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/pong">pong</a></th>
					<td>Runs through a list of servers, pings each once for a second then returns a success or fail result.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/sneak">sneak</a></th>
					<td>Use rsync to pull the contents of a directory on a remote machine to the local machine.  Intended to be implemented as a cronjob to responsibly transfer files under limited bandwidth restrictions.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/stuff">stuff</a></th>
					<td>Pulls and lists a bunch of useful (to me) info about the host (hardware, disks/mounts, OS, network, etc).</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/terbling">terbling</a></th>
					<td>Prints an ascii-art logo and some basic system info to the command line.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/vpn">vpn</a></th>
					<td>Kills current <a href="https://openvpn.net/">openvpn</a> service then reconnects and confirms.  Useful for quickly establishing or re-establishing a vpn connection.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/wami">wami</a></th>
					<td>Pulls and displays info (IP, country, city, etc) from <a href="https://ifconfig.co/">ifconfig.co</a>.  Useful to verify vpn/wireguard connection.  Previously wami used <i>ipinfo.io</i> to source ip data, but <i>ifconfig.co</i> is a great, open-source, self-hostable project and is generally just a lot nicer.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/whodis">whodis</a></th>
					<td>Grabs the contents of the /tmp/dhcp.leases file on a remote router, pretties it up and prints it to stdout.</td>
				</tr>
			</table>
			<br />
			<br />
			<h2 class="align-center">Archived scripts</h2>
			<p>Additional assorted scripts I developed but no longer use.  These are still available on <a href="https://gitlab.com/clewsy/scripts/-/tree/master/archive">gitlab</a>.  Click on the script name to go directly to the gitlab page.</p>
			<table class="text-table">
				<tr>
					<th scope="col">Name</th>
					<th scope="col">Description</th>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/ball">ball</a></th>
					<td>Runs bu on a bunch of remote host or list of hosts.  Deprecated thanks to <a href="https://www.ansible.com/">Ansible</a>.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/bu">bu</a></th>
					<td>Uses <a href="https://rsync.samba.org/">rsync</a> to back up files and directories defined in a list file to a remote server.  Also deprecated thanks to <a href="https://www.ansible.com/">Ansible</a>.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/archive/cal_backup.sh">cal_backup.sh</a></th>
					<td>Generates an *.ics file from a <a href="https://nextcloud.com/">nextcloud</a> calendar and archives it.  Intended to be used as a cronjob.  No longer used since migrating my nextcloud service to a <a href="https://www.docker.com/">docker</a> container.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/archive/chuck.sh">chuck.sh</a></th>
					<td>Very similar to grab.sh, but used to upload to the remote server.  Originally used to circumvent some corporate proxy restrictions - no longer used.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/archive/grab.sh">grab.sh</a></th>
					<td>Uses <a href="https://rsync.samba.org/">rsync</a> (to allow resume after interruption) to download a specified file from a remote server.  Originally used to circumvent some corporate proxy restrictions - no longer used.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/archive/nc_backup.sh">nc_backup.sh</a></th>
					<td>Creates a local copy of all the data files from a <a href="https://nextcloud.com/">nextcloud</a> instance - including a mysqldump of the database.  No longer used since migrating my nextcloud service to a <a href="https://www.docker.com/">docker</a> container.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/archive/roll_out.sh">roll_out.sh</a></th>
					<td>Attempt to copy a specified file/directory to a destination (relative to home directory) on a list of remote hosts.   I used this to sync my custom scripts to a list of hosts.  Now deprecated as I manage this task with <a href= "https://docs.ansible.com/">Ansible</a>.</td>
				</tr>
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/scripts/blob/master/ytdl">ytdl</a></th>
					<td>Written for use with <a href="https://termux.com/">termux</a> to download a youtube video direct to the device.  No longer used often since running <a href="https://newpipe.schabi.org/">NewPipe</a> instead of the youtube app.  NewPipe has direct download capability.</td>
				</tr>
			</table>
			<br />
			<br />
		</div>
	</body>
</html>
