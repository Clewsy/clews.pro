<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.php"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">clewsy_ansible</h2>
			<a href="https://docs.ansible.com/"><img class="image align-left" src="images/clewsy_ansible/clewsy_ansible_01.png" alt="Just the ansible logo." /></a>
			<p><a href="https://docs.ansible.com/">Ansible</a> is software for secure, push-style, agentless, system configuration management.  I guess it's more than that, but I'm new.  It had a moderate learning curve and then required a reasonable amount of configuration, but now I have some basic playbooks and roles written that will save me a lot of time in the future.  This project is purely about using ansible to configure machines on my personal home network.</p>
			<p>My biggest problem has been completely forgetting why or how I configured a system, shortly after initially getting it up and running.  Ansible playbooks are self-documenting, so even if I want to do something manually in the future, the instructions are all there, built-in to the ansible playbooks stored in my <a href="https://gitlab.com/clewsy/clewsy_ansible">gitlab repo</a>.</p>
			<p>The repo includes a host-spcific playbook and variables file for each managed host machine/device on my home network.</p>
			<p>Some minimal configuration is required on a host to prepare it for being automatically configured by the ansible playbook:</p>
			<ol>
				<li>Install the operating system.</li>
				<li>Create the user - must match the username defined in the host variables file (<i>host_vars/hostname.yml</i>).</li>
				<li>Give the user sudo access.  The sudo password must be as defined (encrypted) by the host-specific setup-password variable (also in <i>host_vars/hostname.yml</i>).</li>
				<li>Ensure a static IP has been assigned to the MAC address of the machine's network interface.  I use a hosts file on my dhcp server, so in my hosts.yml file all machines are identified by hostname, not ip address.  I find it easier to remember character names from <a href="https://en.wikipedia.org/wiki/List_of_Futurama_characters">Futurama</a> than IP addresses.</li>
			</ol>
			<hr />
			<h3>Android Phone Automation</h3>
			<p>The flexo.yml playbook is a special case.  Flexo is the hostname assigned to my smartphone, so to configure it with ansible (using the <i>droid</i> role) the pre-requisites differ:</p>
			<ol>
				<li><a href="https://termux.com/">Termux</a> must be installed.</li>
				<li>Within termux, a couple of packages need to be manually installed:</li>
				<ul>
					<li><a href="https://www.python.org/">python</a></li>
					<li><a href="https://www.openssh.com/">openssh</a></li>
				</ul>
				<li>Termux ssh sessions don't really have a "user" in the traditional sense, but a password must be configured (i.e. run <i>passwd</i>).</li>
				<li>The ssh daemon must be running (i.e run <i>sshd</i>).  By default, the ssh daemon will serve on port 8022.</li>
			</ol>
			<hr />

			<h3>File Server / Backup Automation box</h3>
			<p>For a few years I used <a href="https://www.openmediavault.org/">openmediavault</a> (omv) on a headless system.  Omv has many features, of which I really used only two:</p>
			<ol>
				<li><b>Network Accessible Storage / File Server</b>:  It is in this box that I keep bulk file storage including media.  I create a few network shares so that video/music/image files can be accessed elswhere on the local network.</li>
				<li><b>Backups</b>:  With rsync and a few cron jobs, this machine would create daily backups of important files.  It pulled files from various machines to create on-site backups, and it also pushed these backups to an off-site box.</li>
			</ol>
			<p>Omv has a nice web-based graphical interface with which I had no issues, but it obfuscated some of the workings of the tasks I used it for.  Additionally, deployment via ansible would require learning omv-specific commands.  I expect automation would be possible this way, but it occurred to me I could easily automate file-sharing and rsync cron jobs with a minimal Ubuntu system.  The only loss would be the webUI, but I only ever needed that when initially setting up omv.</p>
			<p>So I replaced omv with <a href="https://ubuntu.com/download/server">Ubuntu Server</a> and created a couple of roles that serve my minimal needs:</p>
			<ol>
				<li><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/file_server">file_server</a>: This role mounts disks/partitions and creates <a href="https://en.wikipedia.org/wiki/Network_File_System_(protocol)">nfs</a> and/or <a href="http://cifs.com/">cifs</a> shares to access them across the LAN.</li>
				<li><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/rsync_server">rsync_server</a>: This role creates cron jobs for <a href="https://rsync.samba.org/">rsync</a> pull and push backups.</li>
			</ol> 
			<hr />

			<h2 class="align-center">Hosts</h2>
			<p><center>The following table lists the machines I have on my network and the roles I assigned them.</center></p>
			<table class="text-table"><col style="width:auto"><col style="width:auto"><col style="width:600px"><col style="width:auto">

				<!-- column headings -->
				<tr>
					<th scope="col">Hostname</th>
					<th scope="col">Base OS</th>
					<th scope="col">Description</th>
					<th scope="col">Roles</th>
				</tr>

				<!-- b4t-cam -->
				<tr>
					<th scope="row">b4t-cam</th>
					<td><a href="https://www.raspberrypi.org/software/">Raspberry Pi OS</a></td>
					<td>
						<p>An old <a href="https://www.raspberrypi.org/">raspberry pi</a> 2 with a wifi dongle and an old usb webcam.</p>
						<p>Configured as an ip cam.</p>
					</td>
					<td>
						<ul>
							<li>common</li>
							<li>motion</li>
						</ul>
					</td>
				</tr>

				<!-- b4t.site -->
				<tr>
					<th scope="row">b4t.site</th>
					<td><a href="https://ubuntu.com/">Ubuntu</a></td>
					<td>
						<p>Off-site box (VPS) used for backup storage.</p>
						<p>Also doubles as a <a href="https://www.wireguard.com/">wireguard</a> endpoint.</p>
					</td>
					<td>
						<ul>
							<li>common</li>
							<li>docker</li>
							<li>headless</li>
							<li>secure</li>
							<li>vpn</li>
							<li>wireguard</li>
						</ul>
					</td>
				</tr>

				<!-- calculon -->
				<tr>
					<th scope="row">calculon</th>
					<td><a href="https://ubuntu.com/raspberry-pi">Ubuntu (for Pi)</a></td>
					<td>
						<p>(Currently not in service).  Home automation stuff.</p>
						<p>A <a href="https://www.raspberrypi.org/">raspberry pi</a> 4 with "supervised" <a href="https://www.home-assistant.io/">home assistant</a>.</p>
						<p>This pi runs home assistant on top of of an <a href="https://ubuntu.com/download/raspberry-pi">ubuntu server</a> base.</p>
					</td>
					<td>
						<ul>
							<li>common</li>
							<li>homeassistant</li>
						</ul>
					</td>
				</tr>

				<!-- farnsworth -->
				<tr>
					<th scope="row">farnsworth</th>
					<td><a href="https://ubuntu.com/">Ubuntu</a></td>
					<td>
						<p>My main desktop machine.</p>
					</td>
					<td>
						<ul>
							<li>clews.pro</li>
							<li>common</li>
							<li>desktop</li>
							<li>develop</li>
							<li>docker</li>
							<li>headless</li>
							<li>mpd</li>
							<li>node</li>
							<li>secure</li>
							<li>vpn</li>
							<li>wireguard</li>
						</ul>
					</td>
				</tr>

				<!-- flexo -->
				<tr>
					<th scope="row">flexo</th>
					<td><a href="https://lineageos.org/">LineageOS</a></td>
					<td>
						<p>My smortphone.</p>
					</td>
					<td>
						<ul>
							<li>droid</li>
						</ul>
					</td>
				</tr>

				<!-- hermes -->
				<tr>
					<th scope="row">hermes</th>
					<td><a href="https://www.raspberrypi.org/software/">Raspberry Pi OS</a></td>
					<td>
						<p>Minimal Raspberry Pi OS image on an old Raspberry Pi 2 with <a href="https://www.cups.org/">CUPS</a> installed.</p>
						<p>Configured to serve a connected laser printer on the local network.</p>
					</td>
					<td>
						<ul>
							<li>common</li>
							<li>cups</li>
						</ul>
					</td>
				</tr>

				<!-- hypnotoad -->
				<tr>
					<th scope="row">hypnotoad</th>
					<td><a href="https://osmc.tv/">OSMC</a></td>
					<td>
						<p>Media server installed on a <a href="https://www.raspberrypi.org/">raspberry pi</a> 3 connected to a tv.</p>
						<p>Serves media stored on zapp using <a href="https://en.wikipedia.org/wiki/Network_File_System_(protocol)">nfs</a> shares.</p>
						<p>Refer to the <a href="/projects/media_center.php">media_center</a> project page.</p>
					</td>
					<td>
						<ul>
							<li>common</li>
						</ul>
					</td>
				</tr>

				<!-- nibbler -->
				<tr>
					<th scope="row">nibbler</th>
					<td><a href="https://pop.system76.com/">Pop!_OS</a></td>
					<td>
						<p>My laptop.</p>
					</td>
					<td>
						<ul>
							<li>common</li>
							<li>desktop</li>
							<li>develop</li>
							<li>mpd</li>
							<li>node</li>
							<li>secure</li>
							<li>vpn</li>
							<li>wireguard</li>
						</ul>
					</td>
				</tr>

				<!-- p0wer -->
				<tr>
					<th scope="row">p0wer</th>
					<td><a href="https://www.raspberrypi.org/software/">Raspberry Pi OS</a></td>
					<td>
						<p>A <a href="https://www.raspberrypi.org/">raspberry pi</a> zero W with an RF remote connected to the gpio.</p>
						<p>Refer to the <a href="/projects/p0wer.php">p0wer</a> project page or <a href="https://gitlab.com/clewsy/p0wer">gitlab repo</a>.</p>
					</td>
					<td>
						<ul>
							<li>common</li>
							<li>p0wer</li>
						</ul>
					</td>
				</tr>

				<!-- pazuzu -->
				<tr>
					<th scope="row">pazuzu</th>
					<td><a href="https://www.raspberrypi.org/software/">Raspberry Pi OS</a></td>
					<td>
						<p><a href="https://www.raspberrypi.org/">Raspberry pi</a> zero W connected to a raspberry pi cam.</p>
						<p>Configured as an ip cam.</p>
					</td>
					<td>
						<ul>
							<li>common</li>
							<li>motion</li>
						</ul>
					</td>
				</tr>

				<!-- rad10 -->
				<tr>
					<th scope="row">rad10</th>
					<td><a href="https://ubuntu.com/raspberry-pi">Ubuntu (for Pi)</a></td>
					<td>
						<p>A <a href="https://www.raspberrypi.org/">raspberry pi</a> 3 with an encoder connected to the gpio.</p>
						<p>Refer to the <a href="/projects/rad10.php">rad10</a> project page or <a href="https://gitlab.com/clewsy/rad10d">gitlab repo</a>.</p>
					</td>
					<td>
						<ul>
							<li>common</li>
							<li>mpd</li>
							<li>rad10</li>
						</ul>
					</td>
				</tr>

				<!-- scruffy -->
				<tr>
					<th scope="row">scruffy</th>
					<td><a href="https://ubuntu.com/raspberry-pi">Ubuntu (for Pi)</a></td>
					<td>
						<p>A <a href="https://www.raspberrypi.org/">raspberry pi</a> 4 configured to serve the <a href="https://github.com/ccrisan/motioneye/">motioneye</a> frontend.</p>
						<p>Pulls various camera streams together into a single point of access.</p>
					</td>
					<td>
						<ul>
							<li>common</li>
							<li>secure</li>
							<li>docker</li>
							<li>motioneye</li>
						</ul>
					</td>
				</tr>

				<!-- seymour -->
				<tr>
					<th scope="row">seymour</th>
					<td><a href="https://www.debian.org/">Debian</a></td>
					<td>
						<p><a href="https://beagleboard.org/black/">Beaglebone Black</a> connected to the LAN via ethernet.</p>
						<p>Always-on box that serves as a network admin node</p>
						<p>Also runs some custom cron job admin/maintenance scripts.</p>
					</td>
					<td>
						<ul>
							<li>common</li>
							<li>headless</li>
							<li>node</li>
							<li>polly</li>
							<li>secure</li>
						</ul>
					</td>
				</tr>

				<!-- zapp -->
				<tr>
					<th scope="row">zapp</th>
					<td><a href="https://ubuntu.com/">Ubuntu</a></td>
					<td>
						<p>File-server, backup storage and torrent client.</p>
						<p>Shares media using <a href="https://en.wikipedia.org/wiki/Network_File_System_(protocol)">nfs</a> and acts as my on-site backup storage.</p>
						<p>Includes some specific rsync cron jobs to facillitate on-site and off-site backups.</p>
						<p>For a few years I used <a href="https://www.openmediavault.org/">openmediavault</a> (omv) as the operating system for backups and file serving, but I switched to a minimal Ubuntu server install which allowed me to fully automate deployment/redeployment without needing to use the omv gui or learn the omv command-line options.</p> 
					</td>
					<td>
						<ul>
							<li>common</li>
							<li>docker</li>
							<li>file_server</li>
							<li>headless</li>
							<li>qbittorrent</li>
							<li>rsync_server</li>
							<li>vpn</li>
							<li>wireguard</li>
						</ul>
					</td>
				</tr>

				<!-- zoidberg -->
				<tr>
					<th scope="row">zoidberg</th>
					<td><a href="https://ubuntu.com/">Ubuntu</a></td>
					<td>
						<p>Web server machine.</p>
						<p>Serves various web sites and web apps.</p>
						<p>Refer to the <a href="/projects/clews.php">clews.pro</a> project page or <a href="https://gitlab.com/clewsy/clews.pro">gitlab repo</a>.</p>
					</td>
					<td>
						<ul>
							<li>clews.pro</li>
							<li>common</li>
							<li>docker</li>
							<li>headless</li>
							<li>polly</li>
							<li>secure</li>
						</ul>
					</td>
				</tr>

			</table>
			<br /><br />
			<hr />
			<h2 class="align-center">Roles</h2>
			<p><center>The following table describes the various roles I created and use.</center></p>
			<table class="text-table">

				<!-- column headings -->
				<tr>
					<th scope="col">Role</th>
					<th scope="col">Description/Tasks</th>
				</tr>

				<!-- clews.pro -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/clews.pro">clews.pro</a></th>
					<td>Will configure a box as a containerised web server, clone the <a href="https://gitlab.com/clewsy/clews.pro">clews.pro repo</a>, and spin up the containers defined in the <a href="https://gitlab.com/clewsy/clews.pro/-/blob/master/docker-compose.yml">docker-compose.yml</a> file.</td>
				</tr>

				<!-- common -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/common">common</a></th>
					<td>Configurations common to all hosts - hostname, timezone, ssh keys/configs, apt upgrades, common packages, <a href="https://www.vim.org/">vim</a>, <a href="https://git-scm.com/">git</a>, host-specific packages, motd, .bashrc, aliases, cron jobs, mounts/fstab, common scripts (<a href="https://gitlab.com/clewsy/scripts/-/blob/master/bu">bu</a>, <a href="https://gitlab.com/clewsy/scripts/-/blob/master/stuff">stuff</a>, <a href="https://gitlab.com/clewsy/scripts/-/blob/master/wami">wami</a>).</td>
				</tr>

				<!-- cups -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/cups">cups</a></th>
					<td>Will allow configuration of a printer that is connected directly (USB) or on the network.  Can effectively convert a direct connected printer into a network printer.</td>
				</tr>

				<!-- desktop -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/desktop">desktop</a></th>
					<td>Configurations for systems with a desktop - <a href="https://github.com/brndnmtthws/conky">conky</a>, <a href="https://gitlab.com/clewsy/scripts/-/blob/master/terbling">terbling</a>, <a href="https://github.com/software-jessies-org/jessies/wiki/Terminator">terminator</a>, <a href="http://guake-project.org/">guake</a>, <a href="https://www.gnome.org/">gnome</a> settings and others.</td>
				</tr>

				<!-- develop -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/develop">develop</a></th>
					<td>Install <a href="https://code.visualstudio.com/">VSCode</a>, the AVR toolchain (including <a href="http://savannah.nongnu.org/projects/avr-libc">avr-libc</a>, <a href="http://savannah.nongnu.org/projects/avrdude">avrdude</a> and dependencies) and other miscellaneous development packages.</td>
				</tr>

				<!-- docker -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/docker">docker</a></th>
					<td>Install <a href="https://www.docker.com/">docker</a> and <a href="https://docs.docker.com/compose/">docker-compose</a>.  Start the docker service and create a standard docker-compose staging directory.  Also create alias dc='docker-compose'.</td>
				</tr>

				<!-- droid -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/droid">droid</a></th>
					<td>A special role created to configure an android smartphone running <a href="https://termux.com/">Termux</a>.  This role has tasks similar to common that had to be implemented dfferently (configure ssh, install packages, install scripts).  Installs some termux "shortcuts" which are basically scripts that can be run from a widget.  Also copies specified files onto the device (e.g. ringtones, wallpapers).</td>
				</tr>

				<!-- file_server -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/file_server">file_server</a></th>
					<td>Mounts a number of disks and configures specified disks or directories as <a href="https://en.wikipedia.org/wiki/Network_File_System_(protocol)">nfs</a> shares for access over the local network.</td>
				</tr>

				<!-- headless -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/headless">headless</a></th>
					<td>Install and configure some <a href="https://en.wikipedia.org/wiki/Ncurses">ncurses</a> apps useful for headless systems and systems that are often accessed remotely.  Includes <a href="https://hisham.hm/htop/">htop</a>, <a href="http://www.ex-parrot.com/pdw/iftop/">iftop</a>, <a href="https://dev.yorhel.nl/ncdu">ncdu</a>, <a href="https://github.com/tmux/tmux/wiki">tmux</a> and <a href="https://midnight-commander.org/">Midnight Commander</a>.</td>
				</tr>

				<!-- homeassistant -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/homeassistant">homeassistant</a></th>
					<td>First configure docker role as a pre-requisite.  Then install/remove certain packages as required by the <a href="https://github.com/home-assistant/supervised-installer">home assistant supervised installer script</a>.  Finally download and run the installer script that will install <a href="https://www.home-assistant.io/">home assistant supervised</a>.</td>
				</tr>

				<!-- motion -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/motion">motion</a></th>
					<td>Turn a <a href="https://www.raspberrypi.org/">raspberry pi</a> into a web-cam.  Install, configure and enable <a href="https://motion-project.github.io/">motion</a> for streaming over the lan.</td>
				</tr>

				<!-- motioneye -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/motioneye">motioneye</a></th>
					<td>Install and configure <a href="https://github.com/ccrisan/motioneye/">motioneye</a> - a web-based frontend for pulling together multiple camera streams.  This is installed as a <a href="https://www.docker.com/">docker</a> container, so first the docker role is run, then a docker-compose.yml file is copied and used to pull and run the <a href="https://hub.docker.com/r/ccrisan/motioneye/">motioneye container</a>.</td>
				</tr>

				<!-- mpd -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/mpd">mpd</a></th>
					<td>Use on boxes that will be used for streaming audio or playing mp3s.  Install the required and useful packages (<a href="https://www.musicpd.org/">mpd</a>, <a href="https://www.musicpd.org/clients/mpc/">mpc</a>, <a href="https://rybczak.net/ncmpcpp/">ncmpc</a>) then configure and run the mpd daemon.</td>
				</tr>

				<!-- node -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/node">node</a></th>
					<td>Set up some common packages and scripts on key boxes that are used for maintaining other boxes.  Install networking packages (<a href="https://github.com/netdiscover-scanner/netdiscover">netdiscover</a>, <a href="https://nmap.org/">nmap</a>), install <a href="https://docs.ansible.com/">ansible</a>, clone the <a href="https://gitlab.com/clewsy/clewsy_ansible">clewsy_ansible gitlab repository</a> and install some custom scripts (<a href="https://gitlab.com/clewsy/scripts/-/blob/master/apt_all">apt_all</a>, <a href="https://gitlab.com/clewsy/scripts/-/blob/master/ball">ball</a>, <a href="https://gitlab.com/clewsy/scripts/-/blob/master/pong">pong</a>, <a href="https://gitlab.com/clewsy/scripts/-/blob/master/whodis">whodis</a>).</td>
				</tr>

				<!-- p0wer -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/p0wer">p0wer</a></th>
					<td>Configure a <a href="https://www.raspberrypi.org/">raspberry pi</a> with gpio connected to an RF remote control used to switch on/off mains-connected devices via scripts or a webui.  Clone <a href="https://gitlab.com/clewsy/p0wer">p0wer repo</a>, compile executable, install webserver packages (<a href="https://httpd.apache.org/">Apache</a>) and copy html/php files.</td>
				</tr>

				<!-- polly -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/polly">polly</a></th>
					<td>Configue a box to control a <a href="https://blink1.thingm.com/">thingm blink1</a> device, then install <a href="https://gitlab.com/clewsy/scripts/-/blob/master/polly">polly</a> script which polls <a href="https://clews.pro/">clews.pro</a>, logs the result and uses the blink1 to indicate the site status.</td>
				</tr>

				<!-- qbittorrent -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/qbittorrent">qbittorrent</a></th>
					<td>Install and configure <a href="https://www.qbittorrent.org/">qbittorrent</a> client.  This is installed as a <a href="https://www.docker.com/">docker</a> container, so first the docker role is run, then a docker-compose.yml file is copied and used to pull and run the <a href="https://hub.docker.com/r/linuxserver/qbittorrent">qbittorrent container</a>.</td>
				</tr>

				<!-- rad10 -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/rad10">rad10</a></th>
					<td>Configure a <a href="https://www.raspberrypi.org/">raspberry pi</a> as an internet radio/music streamer with hardware control and a webui.  First run the mpd role, then clone the <a href="https://gitlab.com/clewsy/rad10d">rad10d repo</a>, compile the daemon and configure a unit-file for systemd auto-starting.  Will also install web server packages (<a href="https://httpd.apache.org/">Apache</a>) and copy the html/php files for the rad10 webui.</td>
				</tr>

				<!-- rsync_server -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/rsync_server">rsync_server</a></th>
					<td>Creates a series of <a href="https://en.wikipedia.org/wiki/Cron">cron</a> jobs that use <a href="https://rsync.samba.org/">rsync</a> to create specified local and remote backups to/from various machines..</td>
				</tr>

				<!-- secure -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/secure">secure</a></th>
					<td>Configure some basic settings for ssh security and enable/configure a firewall (using <a href="https://launchpad.net/ufw">ufw</a>).</td>
				</tr>

				<!-- vpn -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/vpn">vpn</a></th>
					<td>Install <a href="https://openvpn.net/">openvpn</a> and copy some custom vpn configuration files.  Also copy and configure a custom <a href="https://gitlab.com/clewsy/scripts/-/blob/master/vpn">vpn</a> initialisation script.</td>
				</tr>

				<!-- wireguard -->
				<tr>
					<th scope="row"><a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/wireguard">wireguard</a></th>
					<td>Install <a href="https://www.wireguard.com/">wireguard</a> and configure a host as a wireguard vpn "server" (endpoint) and/or "client".  Also create some client aliases for quickly bringing wireguard connections up/down from the command line.</td>
				</tr>

			</table>
			<p><a class="align-center" href="images/clewsy_ansible/clewsy_ansible_02.png"><img class="image" src="images/clewsy_ansible/clewsy_ansible_02.png" alt="I don't know what I'm doing." /></a></p>
		</div>
	</body>
</html>
