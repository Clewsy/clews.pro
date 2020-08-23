<!DOCTYPE html>
<html>
	<head>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/head.html"); ?>
	</head>
	<body>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.html"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">Projects</h2>
			<table class="text-table">
				<tr>
					<th scope="col">Project</th>
					<th scope="col">Thumbnail</th>
					<th scope="col">Summary</th>
					<th class="date" scope="col">Updated</th>
					<th class="links" scope="col">Links</th>
					<th scope="col">Tags</th>
				</tr>
				<tr>
					<th scope="row"><a href="/projects/clews.php">clews.pro</a></th>
					<td><a href="/projects/clews.php"><img class="thumbnail" src="/projects/images/clews_01.png" /></a></td>
					<td>Meta.</td>
					<td class="date">2020-06-25</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/clews.pro">gitlab</a><br />
						<a href="/projects.php">Recursion...</a>
					</td>
					<td>HTML, CSS, PHP, Self-Host, Apache, Nginx, Debian, Ubuntu, Docker, Docker-Compose, Let's Encrypt, Certbot, BitWarden, NextCloud, AirSonic, Calibre, MariaDB, Inkscape, <s>Javascript</s>, Systemd, Ansible</td>
				<tr>
					<th scope="row"><a href="/projects/gps_clock.php">gps_clock</a></th>
					<td><a href="/projects/gps_clock.php"><img class="thumbnail" src="/projects/images/small_gps_clock_01.jpg" /></a></td>
					<td>GPS-synchronised clock that displays time in UNIX Epoch or ISO-8601 format.</td>
					<td class="date">2020-08-18</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/gps_clock">gitlab</a><br />
						<a href="https://hackaday.com/2018/09/18/epic-clock-clocks-the-unix-epoch/">hackaday</a><br />
						<a href="https://hackaday.io/project/161257-gpsclock">hackaday.io</a><br />
						<a href="https://core-electronics.com.au/projects/gps-clock">core-electronics</a>
					</td>
					<td>Clock, GPS, ISO-8601, epoch, 7-seg, led, MAX-7219, AVR, Atmel, ATmega328p, ds3234, C, Ki-CAD, Wood</td>
				</tr>
				<tr>
					<th scope="row"><a href="/projects/grinder_timer.php">grinder_timer</a></th>
					<td><a href="/projects/grinder_timer.php"><img class="thumbnail" src="/projects/images/small_grinder_timer_01.jpg" /></a></td>
					<td>Programmable timer to control a dumb coffee grinder.</td>
					<td class="date">2020-04-30</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/grinder_timer">gitlab</a><br />
						<a href="https://hackaday.com/2017/12/14/dumb-coffee-grinder-gets-smarter-with-time/">hackaday</a><br />
						<a href="https://hackaday.io/project/28450-grindertimer">hackaday.io</a><br />
						<a href="https://core-electronics.com.au/projects/grindertimer">core-electronics</a>
					</td>
					<td>Coffee, Timer, OLED, SSD1306, AVR, Atmel, ATmega328p, Microcontroller, C, KiCAD, PCB Etching</td>
				</tr>
					<th scope="row"><a href="/projects/grinder_timer_rev2.php">grinder_timer_rev2</a></th>
					<td><a href="/projects/grinder_timer_rev2.php"><img class="thumbnail" src="/projects/images/small_grinder_timer_rev2_12.jpg" /></a></td>
					<td>An upgrade to the original grinder_timer.</td>
					<td class="date">2020-08-21</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/grinder_timer_rev2">gitlab</a>
						<a href="https://hackaday.io/project/28450-grindertimer">hackaday.io</a><br />
					</td>
					<td>Coffee, Timer, OLED, SH1106, AVR, ATmega328pb, Microcontroller, Mains Switch Relay, C++, KiCAD, PCB Fabrication, JLCPCB, Rancillio Rocky, PWM, 32.738kHz, PlatformIO</td>
				</tr>
				<tr>
					<th scope="row"><a href="/projects/led_matrix.php">led_matrix</a></th>
					<td><a href="/projects/led_matrix.php"><img class="thumbnail" src="/projects/images/small_led_matrix_04.jpg" /></a></td>
					<td>LED matrix that has a clock mode and a text mode.  My first microcontroller project.</td>
					<td class="date">2020-04-30</td>
					<td class="links">

					</td>
					<td>AVR, ATMEGA8535, Microcontroller, LED, Matrix, Multiplexing, 74HC138</td>
				</tr>
<!--new project in development	<tr>
					<th scope="row"><a href="/projects/macr0.php">macr0</a></th>
					<td><a href="/projects/macr0.php"><img class="thumbnail" src="/projects/images/small_macr0_01.jpg" /></a></td>
					<td>4-button USB input device.</td>
					<td class="date">2020-08-17</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/macr0">gitlab</a>
					</td>
					<td>AVR, ATmega32U4, Microcontroller, USB, HID, Gateron, CAT4104</td>
				</tr> -->
				<tr>
					<th scope="row"><a href="/projects/media_center.php">media_center</a></th>
					<td><a href="/projects/media_center.php"><img class="thumbnail" src="/projects/images/small_media_center_01.jpg" /></a></td>
					<td>Home media center running OSMC on a Raspberry Pi in a wood and aluminium enclosure.</td>
					<td class="date">2020-02-04</td>
					<td class="links">
						<a href="https://core-electronics.com.au/projects/raspberry-pi-media-center">core-electronics</a>
					</td>
					<td>Raspberry Pi 3, Raspbian, OSMC, kodi, Wood</td>
				</tr>
				<tr>
					<th scope="row"><a href="/projects/ncbu.php">ncbu</a></th>
					<td><a href="/projects/ncbu.php"><img class="thumbnail" src="/projects/images/ncbu_01.png" /></a></td>
					<td>Docker container image to simplify and automate backup of a self-hosted nextcloud service.</td>
					<td class="date">2020-07-14</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/ncbu">gitlab</a><br />
						<a href="https://hub.docker.com/r/clewsy/ncbu">Docker Hub</a>
					</td>
					<td>Docker, Docker-Compose, DockerHub, Nextcloud, Self-Host, Container, rsync, bash, shell script, MariaDB, MySQL</td>
				</tr>
				<tr>
					<th scope="row"><a href="/projects/p0wer.php">p0wer</a></th>
					<td><a href="/projects/p0wer.php"><img class="thumbnail" src="/projects/images/p0wer_01.jpg" /></a></td>
					<td>Simple rf mains remote switches hacked to add wifi control.</td>
					<td class="date">2020-04-30</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/p0wer">gitlab</a><br />
						<a href="https://core-electronics.com.au/projects/p0wer-control-mains-outlets-over-wifi">core-electronics</a>
					</td>
					<td>Raspberry Pi Zero W, Raspbian, WiFi, 4066 CMOS Quad Bilateral Switch, 70HC4066, wiringpi, pigpio, Termux, C, PHP, cURL, Automation, KiCAD</td>
				</tr>
				<tr>
					<th scope="row"><a href="/projects/rad10.php">rad10</a></th>
					<td><a href="/projects/rad10.php"><img class="thumbnail" src="/projects/images/small_rad10_01.jpg" /></a></td>
					<td>An internet radio on a raspberry pi with a simple hardware control daemon (and WebUI).</td>
					<td class="date">2020-06-29</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/rad10d">gitlab</a><br />
						<a href="https://core-electronics.com.au/projects/rad10">core-electronics</a>
					</td>
					<td>Rotary Encoder, Raspberry Pi, Raspbian, mpd, mpc, libmpdclient, wiringpi, pigpio, C, Daemon, systemd, Apache, PHP, HTML, CSS, Wood</td>
				</tr>
				<tr>
					<th scope="row"><a href="/projects/scripts.php">scripts</a></th>
					<td><a href="/projects/scripts.php"><img class="thumbnail" src="/projects/images/scripts_01.png" /></a></td>
					<td>Various bash shell scripts.</td>
					<td class="date">2020-07-22</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/scripts">gitlab</a>
					</td>
					<td>Bash, Shell, Script, Linux, Debian, Ubuntu, Raspbian, Termux, echo, rsync, curl, apt-get, ssh, openvpn, ping, grep, lscpu, lspci, lsblk, df, uname, lsb_release, route, netstat, nmcli, ifconfig, ip, iw, iwgetid, command</td>
				</tr>
				<tr>
					<th scope="row"><a href="/projects/temp0.php">temp0</a></th>
					<td><a href="/projects/temp0.php"><img class="thumbnail" src="/projects/images/small_temp0_22.jpg" /></a></td>
					<td>Temperature and humidity monitor with WiFi and local readout.</td>
					<td class="date">2020-07-14</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/temp0">gitlab</a><br />
						<a href="https://hackaday.io/project/171367-temp0">hackaday.io</a><br />
					</td>
					<td>Arduino, Pro-Trinket, HackADay, ESP8266, ESP-01, HDC1080, SSD1306, OLED, PlatformIO, C++, HTML, cURL, Serial, I2C</td>
				</tr>
				<tr>
					<th scope="row"><a href="/projects/volcon.php">VolCon</a></th>
					<td><a href="/projects/volcon.php"><img class="thumbnail" src="/projects/images/small_volcon_09.jpg" /></a></td>
					<td>HID compliant USB volume controller.</td>
					<td class="date">2020-07-14</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/volcon">gitlab</a><br />
						<a href="https://core-electronics.com.au/projects/volcon">core-electronics</a>
					</td>
					<td>AVR, Atmel, AT90usb162, C, Eagle, USB, HID, LUFA, Rotary Encoder, Gray Code, VCR, Wood</td>
				</tr>
				<tr>
					<th scope="row"><a href="/projects/wishabi.php">WiSHABI</a></th>
					<td><a href="/projects/wishabi.php"><img class="thumbnail" src="/projects/images/small_wishabi_01.jpg" /></a></td>
					<td>WIreless Single-Handed Accelerometer-Based Interface. (Under-Grad thesis project).</td>
					<td class="date">2019-10-07</td>
					<td class="links">
						<a href="http://vusb.wikidot.com/project:wishabi">V-USB</a><br />
					</td>
					<td>AVR, Atmel, ATmega8, 433.92MHz, Wireless, USB, HID, C, Keyboard, Mouse, Accelerometer, ADXL330</td>
				</tr>
				<tr>
					<th scope="row"><a href="/projects/wood.php">Wood</a></th>
					<td><a href="/projects/wood.php"><img class="thumbnail" src="/projects/wood/photos/wine_box/small_wine_box_30.jpg" /></a></td>
					<td>Stuff made from wood.</td>
					<td class="date">2019-09-28</td>
					<td class="links">

					</td>
					<td>Wood, Timber, Lumber, Cellulose, Former Tree, Hard Paper, Pre-Cardboard</td>
				</tr>
				<tr>
					<th scope="row"><a href="/projects/clewsy_ansible.php">clewsy_ansible</a></th>
					<td><a href="/projects/clewsy_ansible.php"><img class="thumbnail" src="/projects/images/clewsy_ansible_01.png" /></a></td>
					<td>Deplolyment/configuration/maintenance automation of the machines/devices on my home network with ansible.</td>
					<td class="date">2020-08-19</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/clewsy_ansible">gitlab</a><br />
					</td>
					<td>Ansible, Linux, Debian, Ubuntu, Raspbian, OpenMediaVault, OSMC, Pop_OS!, Termux, Raspberry Pi, Beaglebone Black, git, GitLab, Home Assistant, Wireguard, OpenVPN, qbittorrent, Vim, Conky, Terminator, Guake, Gnome, Docker, docker-compose, yaml, motion, mpd, mpc, ncmpc, bash scripts, Apache, php, apt, snap, ssh, mount, fstab, lm-sensors, VSCode, midnight commander, alias, python, motd, htop, iftop, ncdu, tmux, curl, netdiscover, nmap, chmod. chown, cron, pigpio, ufw, LineageOS, VPS, android, nfs, sudo</td>
				</tr>
			</table>
		</div>
	</body>
</html>
