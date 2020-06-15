<!DOCTYPE html>
<html>
	<head>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/head.html"); ?>
	</head>
	<body>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.html"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">clewsy_ansible</h2>
			<a href="https://docs.ansible.com/"><img class="image align-left" src="images/clewsy_ansible_01.png" alt="Just the ansible logo." /></a>
			<p><a href="https://docs.ansible.com/">Ansible</a> is software for secure, push-style, agentless, system configuration management.  I guess it's more than that, but I'm new.  It had a moderate learning curve and then required a reasonable amount of configuration, but now I have some basic playbooks and roles written that will save me a lot of time in the future.  This project is purely about using ansible to configure machines on my personal home network.</p>
			<p>My biggest problem has been completely forgetting why or how I configured a system shortly after initially getting it running the way I want.  Ansible playbooks are self-documenting, so even if I want to do something manually in the future, instructions are all there, built-in to my ansible playbooks stored in my <a href="https://gitlab.com/clewsy/clewsy_ansible">gitlab repo</a>.</p>
			<p>For each managed host machine/device in my home network, I have a playbook and variables file.  When run, the host-specific playbook will configure the host with the associated roles, in accordance with certain variables listed in the host-specific variables file.</p>
			<p>Some minimal configuration is required on a host to prepare it for being automatically configured by the playbook:</p>
			<ol>
				<li>Install the operating system.</li>
				<li>Create the user - must match the username defined in the host variables file (<i>host_vars/hostname.yml</i>).</li>
				<li>Give the user sudo access.  Sudo password must be as defined by the host-specific setup-password variabe (also in <i>host_vars/hostname.yml</i>).</li>
				<li>Ensure a static IP has been assigned to the MAC address of the machine's network interface.  I use a hosts file on my dhcp server, so all machines are identified by hostname, not ip address.</li>
			</ol>
			<p>The flexo.yml playbook is a special case.  Flexo is my smartphone, so to configure it ansible (using the <i>droid</i> role) the pre-requisites differ:</p>
			<ol>
				<li><a href="https://termux.com/">Termux</a> must be installed.</li>
				<li>Within termux, a couple of packages need to be manually installed:</li>
				<ul>
					<li>python</li>
					<li>openssh</li>
				</ul>
				<li>Termux ssh sessions don't really have a "user" in the traditional sense, but a password must be configured (i.e. run <i>passwd</i>).</li>
				<li>The ssh daemon (<i>sshd</i>)  must be running.  By default, the ssh daemon will serve on port 8022.</li>
			</ol>
			<p>The following tables detail the machines I have on my network and the roles I created for them.</p>
			<hr />
			<h2 class="align-center">Hosts</h2>
			<table class="text-table">
				<tr>
					<th scope="col">Hostname</th>
					<th scope="col">Base OS</th>
					<th scope="col">Description</th>
					<th scope="col">Roles</th>
				</tr>
				<tr>
					<th scope="row">b4t-cam</th>
					<td><a href="https://www.raspbian.org/">Raspbian</a></td>
					<td>An old raspberry pi 2 with a wifi dongle and an old usb webcam.Configured as an ip cam.</td>
					<td>
						<ul>
							<li>common</li>
							<li>motion</li>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row">b4t.site</th>
					<td><a href="https://ubuntu.com/">Ubuntu</a></td>
					<td>Off-site box (VPS) used as a wireguard endpoint and backup storage.</td>
					<td>
						<ul>
							<li>common</li>
							<li>docker</li>
							<li>secure</li>
							<li>wireguard_server</li>
							<li>vpn</li>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row">calculon</th>
					<td><a href="https://ubuntu.com/">Ubuntu</a></td>
					<td>Home automation stuff.  A raspberry pi 4 with containerised <a href="https://www.home-assistant.io/">home assistant</a> (supervised) on top of an ubuntu base.</td>
					<td>
						<ul>
							<li>common</li>
							<li>homeassistant</li>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row">farnsworth</th>
					<td><a href="https://ubuntu.com/">Ubuntu</a></td>
					<td>My main desktop machine.</td>
					<td>
						<ul>
							<li>clews.pro</li>
							<li>common</li>
							<li>desktop</li>
							<li>docker</li>
							<li>mpd</li>
							<li>node</li>
							<li>secure</li>
							<li>vpn</li>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row">flexo</th>
					<td><a href="https://lineageos.org/">LineageOS</a></td>
					<td>My main desktop machine.</td>
					<td>
						<ul>
							<li>droid</li>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row">hypnotoad</th>
					<td><a href="https://osmc.tv/">OSMC</a></td>
					<td>Media server installed on a raspberry pi 3 connected to a tv.  Serves media stored on zapp using nfs shares.  Refer to the <a href="/projects/media_center.php">media_center</a> project page.</td>
					<td>
						<ul>
							<li>common</li>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row">nibbler</th>
					<td><a href="https://pop.system76.com/">Pop!_OS</a></td>
					<td>My laptop.</td>
					<td>
						<ul>
							<li>common</li>
							<li>desktop</li>
							<li>mpd</li>
							<li>node</li>
							<li>secure</li>
							<li>vpn</li>
							<li>wireguard</li>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row">p0wer</th>
					<td><a href="https://www.raspbian.org/">Raspbian</a></td>
					<td>A raspberry pi zero W with additional hardware connected to the gpio.  Refer to the <a href="/projects/p0wer.php">p0wer</a> project page or <a href="https://gitlab.com/clewsy/p0wer">gitlab repo</a>.</td>
					<td>
						<ul>
							<li>common</li>
							<li>p0wer</li>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row">pazuzu</th>
					<td><a href="https://www.raspbian.org/">Raspbian</a></td>
					<td>Raspberry pi zero W connected to a raspberry pi cam.  Configured as an ip cam.</td>
					<td>
						<ul>
							<li>common</li>
							<li>motion</li>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row">rad10</th>
					<td><a href="https://www.raspbian.org/">Raspbian</a></td>
					<td>A raspberry pi 3 with additional hardware connected to the gpio.  Refer to the <a href="/projects/rad10.php">rad10</a> project page or <a href="https://gitlab.com/clewsy/rad10d">gitlab repo</a>.</td>
					<td>
						<ul>
							<li>common</li>
							<li>mpd</li>
							<li>rad10</li>
						</ul>
					</td>
				</tr>

				<tr>
					<th scope="row">seymour</th>
					<td><a href="https://www.debian.org/">Debian</a></td>
					<td><a href="https://beagleboard.org/black/">Beaglebone Black</a> single-board-computer connected to the LAN via ethernet.  Always-on box that serves as a network admin node and runs some custom cron job scripts.</td>
					<td>
						<ul>
							<li>common</li>
							<li>docker</li>
							<li>node</li>
							<li>polly</li>
							<li>secure</li>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row">zapp</th>
					<td><a href="https://www.openmediavault.org/">openmediavault</a></td>
					<td>File-server and backup storage.  Shares bulk media over nfs and acts as my on-site backup storage.  Also runs a torrent client.</td>
					<td>
						<ul>
							<li>common</li>
							<li>docker</li>
							<li>qbittorrent</li>
							<li>vpn</li>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row">zoidberg</th>
					<td><a href="https://ubuntu.com/">Ubuntu</a></td>
					<td>Web server machine.  Serves various web sites and web apps.  Refer to the <a href="/projects/clews.php">clews.pro</a> project page or <a href="https://gitlab.com/clewsy/clews.pro">gitlab repo</a>.</td>
					<td>
						<ul>
							<li>clews.pro</li>
							<li>common</li>
							<li>docker</li>
							<li>polly</li>
							<li>secure</li>
						</ul>
					</td>
				</tr>
			</table>
			<hr />
			<h2 class="align-center">Roles</h2>
			<table class="text-table">
				<tr>
					<th scope="col">Role</th>
					<th scope="col">Description</th>
				</tr>
				<tr>
					<th scope="row">clews.pro</th>
					<td>Will configure a box as a containerised web server, clone the clews.pro repo, and spin up the containers defined in the docker-compose.yml file.</td>
				</tr>
				<tr>
					<th scope="row">common</th>
					<td>Configurations common to all hosts - hostname, timezone, ssh keys/configs, apt upgrades, common packages, vim, git, host-specific packages, motd, .bashrc, aliases, cron jobs, mounts/fstab, common scripts (bu, stuff, wami).</td>
				</tr>
				<tr>
					<th scope="row">desktop</th>
					<td>Configurations for systems with a desktop - fonts, conky, terbling, terminator, guake, gnome settings.</td>
				</tr>
				<tr>
					<th scope="row">docker</th>
					<td>Install docker and docker-compose.  Start the docker service and create a standard docker-compose staging directory.  Also create alias dc='docker-compose'.</td>
				</tr>
				<tr>
					<th scope="row">droid</th>
					<td>A special role created to configure an android smartphone running Termux.  This role has tasks similar to common that had to be implemented dfferently (configure ssh, install packages, install scripts).  It also installs some termux "shortcuts" which are basically scripts that can be run from a widget.</td>
				</tr>
				<tr>
					<th scope="row">homeassistant</th>
					<td>First configure docker role as a pre-requisite.  Then install/remove certain packages as required by the home assistant supervised installer script.  Finally download and run the installer script that will install home assistant supervised.</td>
				</tr>
				<tr>
					<th scope="row">motion</th>
					<td>Turn a raspberry pi into a web-cam.  Install configure and enable motion for streaming over the lan.</td>
				</tr>
				<tr>
					<th scope="row">mpd</th>
					<td>Use on boxes that will be used for streaming audio or playing mp3s.  Install the required and useful packages (mpd, mpc, ncmpc) then configure and run the mpd daemon.</td>
				</tr>
				<tr>
					<th scope="row">node</th>
					<td>Set up some common packages and scripts on key boxes that are used for maintaining other boxes.  Install networking packages (netdiscover, nmap), install ansible, clone this repository and install some custom scripts (apt_all, ball, pong, whodis).</td>
				</tr>
				<tr>
					<th scope="row">p0wer</th>
					<td>Configure a raspberry pi with gpio connected to an rf remote control used to switch on or off mains-connected devices from scripts or a webui.  Clone p0wer repo, compile executable, install webserver packages and copy htmp/php files.</td>
				</tr>
				<tr>
					<th scope="row">polly</th>
					<td>Configue a box to control a thingm blink1 device, then install polly script which polls clews.pro, logs the result and uses the blink1 to indicate the site status.</td>
				</tr>
				<tr>
					<th scope="row">qbittorrent</th>
					<td>Install and configure qbittorrent client.  This is installed as a docker container so forst the docker role is run, then a docker-compose.yml file is copied and used to pull and run the qbittorrent container.</td>
				</tr>
				<tr>
					<th scope="row">rad10</th>
					<td>Configure a raspberry pi as an internet radio/music streamer with hardware control and a webui.  First run the mpd role, then clone rad10d repo, compile the daemon and configure a unit-file for auto-starting.  Will also install web server packages and copy the html/php files for the rad10 webui.</td>
				</tr>
				<tr>
					<th scope="row">secure</th>
					<td>Configure some basic settings for ssh security and enable/configure a firewall (using ufw).</td>
				</tr>
				<tr>
					<th scope="row">vpn</th>
					<td>Install openvpn and copy some custom vpn configuration files.  Also copy and configure a custom vpn initialisation script.</td>
				</tr>
				<tr>
					<th scope="row">wireguard</th>
					<td>Install wireguard and create custom "client" connection configurations.  Also create some aliases for quickly bringing wireguard up/down from the command line.</td>
				</tr>
				<tr>
					<th scope="row">wireguard_server</th>
					<td>Configure a box as a wireguard "server" endpoint.</td>
				</tr>
			</table>


			<p><a class="align-center" href="images/clews_02.png"><img class="photo" src="images/clews_02.png" alt="I don't know what I'm doing." /></a></p>
		</div>
	</body>
</html>
