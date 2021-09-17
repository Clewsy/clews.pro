<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.php"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">Projects</h2>
			<table class="text-table">
				<tr>
					<th scope="col">Project</th>
					<th scope="col">Thumbnail</th>
					<th scope="col">Summary</th>
					<th class="date" scope="col">Updated</th>
					<th class="links" scope="col" style="width: 127px">Links</th> <!--Define width to prevent wrapping of hyphenated links.-->
					<th scope="col">Tags</th>
				</tr>

				<!--clews.pro-->
				<tr>
					<th scope="row"><a href="/projects/clews.php">clews.pro</a></th>
					<td><a href="/projects/clews.php"><img class="thumbnail" src="/projects/images/clews/clews_01.png" /></a></td>
					<td>Meta.</td>
					<td class="date">2021-09-17</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/clews.pro">gitlab</a><br />
						<a href="/projects.php">Recursion...</a>
					</td>
					<td>HTML, CSS, PHP, Self-Host, Apache, Nginx, Debian, Ubuntu, Docker, Docker-Compose, Let's Encrypt, Certbot, BitWarden, Vaultwarden, NextCloud, Collabora, <s>AirSonic</s>, Navidrome, Calibre, MariaDB, Inkscape, <s>Javascript</s>, Systemd, Ansible, Watchtower</td>

				<!--gps_clock-->
				<tr>
					<th scope="row"><a href="/projects/gps_clock.php">gps_clock</a></th>
					<td><a href="/projects/gps_clock.php"><img class="thumbnail" src="/projects/images/gps_clock/small_gps_clock_01.jpg" /></a></td>
					<td>GPS-synchronised clock that displays time in UNIX Epoch or ISO-8601 format.</td>
					<td class="date">2021-06-17</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/gps_clock">gitlab</a><br />
						<a href="https://hackaday.com/2018/09/18/epic-clock-clocks-the-unix-epoch/">hackaday</a><br />
						<a href="https://hackaday.io/project/161257-gpsclock">hackaday.io</a><br />
						<a href="https://core-electronics.com.au/projects/gps-clock">core-electronics</a>
					</td>
					<td>Clock, GPS, NMEA, ISO-8601, epoch, UNIX Time, 7-seg, led, MAX-7219, AVR, Atmel, ATmega328p, ds3234, RTC, C, KiCAD, Wood, Year 2038 problem</td>
				</tr>

				<!--grinder_timer-->
				<tr>
					<th scope="row"><a href="/projects/grinder_timer.php">grinder_timer</a></th>
					<td><a href="/projects/grinder_timer.php"><img class="thumbnail" src="/projects/images/grinder_timer/small_grinder_timer_01.jpg" /></a></td>
					<td>Programmable timer to control a dumb coffee grinder.</td>
					<td class="date">2020-04-30</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/grinder_timer">gitlab</a><br />
						<a href="https://hackaday.com/2017/12/14/dumb-coffee-grinder-gets-smarter-with-time/">hackaday</a><br />
						<a href="https://hackaday.io/project/28450-grindertimer">hackaday.io</a><br />
						<a href="https://core-electronics.com.au/projects/grindertimer">core-electronics</a>
					</td>
					<td>Coffee, Timer, OLED, SSD1306, AVR, Atmel, ATmega328p, Microcontroller, C, KiCAD, PCB Etching, Rancilio Rocky</td>
				</tr>

				<!--grinder_timer_rev2-->
				<tr>
					<th scope="row"><a href="/projects/grinder_timer_rev2.php">grinder_timer_rev2</a></th>
					<td><a href="/projects/grinder_timer_rev2.php"><img class="thumbnail" src="/projects/images/grinder_timer_rev2/small_grinder_timer_rev2_12.jpg" /></a></td>
					<td>An upgrade to the original grinder_timer.</td>
					<td class="date">2021-03-02</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/grinder_timer">gitlab</a><br />
						<a href="https://hackaday.io/project/28450-grindertimer">hackaday.io</a><br />
					</td>
					<td>Coffee, Timer, OLED, SH1106, AVR, ATmega328pb, Microcontroller, Mains Switch Relay, C++, KiCAD, PCB Fabrication, JLCPCB, Rancilio Rocky, PWM, 32.738kHz, PlatformIO</td>
				</tr>

				<!--jank-->
				<tr>
					<th scope="row"><a href="/projects/jank.php">jank</a></th>
					<td><a href="/projects/jank.php"><img class="thumbnail" src="/projects/images/jank/small_jank_19.jpg" /></a></td>
					<td>A backlit usb numerical keypad to keep my laptop company.  Includes four macro keys.</td>
					<td class="date">2021-06-30</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/jank">gitlab</a><br />
						<a href="https://hackaday.com/2021/06/08/custom-num-pad-does-double-duty-as-macro-pad/">hackaday</a><br />
						<a href="https://hackaday.io/project/180104-jank">hackaday.io</a><br />
					</td>
					<td>AVR, ATmega32U4, Microcontroller, USB, HID, Keyboard, Macro, Key Matrix, Gateron, Cherry MX, mechanical, MP3202, LED Driver, PWM</td>
				</tr>

				<!--led_matrix-->
				<tr>
					<th scope="row"><a href="/projects/led_matrix.php">led_matrix</a></th>
					<td><a href="/projects/led_matrix.php"><img class="thumbnail" src="/projects/images/led_matrix/small_led_matrix_04.jpg" /></a></td>
					<td>LED matrix that has a clock mode and a text mode.  My first microcontroller project.</td>
					<td class="date">2021-02-28</td>
					<td class="links">

					</td>
					<td>AVR, ATmega8535, Microcontroller, LED, Matrix, Multiplexing, 74HC138</td>
				</tr>

				<!--macr0-->
				<tr>
					<th scope="row"><a href="/projects/macr0.php">macr0</a></th>
					<td><a href="/projects/macr0.php"><img class="thumbnail" src="/projects/images/macr0/small_macr0_30.jpg" /></a></td>
					<td>4-button USB input device.</td>
					<td class="date">2021-07-01</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/macr0">gitlab</a><br />
						<a href="https://hackaday.com/2020/11/19/micro-macro-keyboard-is-mega-based/">hackaday</a><br />
						<a href="https://hackaday.io/project/175874-macr0">hackaday.io</a>
					</td>
					<td>AVR, ATmega32U4, Microcontroller, USB, HID, Keyboard, Macro, Media Controller, Key Matrix, Gateron, Cherry MX, <s>CAT4104</s>, LED Driver, Transistor, PWM</td>
				</tr>

				<!--media_center-->
				<tr>
					<th scope="row"><a href="/projects/media_center.php">media_center</a></th>
					<td><a href="/projects/media_center.php"><img class="thumbnail" src="/projects/images/media_center/small_media_center_01.jpg" /></a></td>
					<td>Home media center running OSMC on a Raspberry Pi in a wood and aluminium enclosure.</td>
					<td class="date">2020-12-10</td>
					<td class="links">
						<a href="https://core-electronics.com.au/projects/raspberry-pi-media-center">core-electronics</a>
					</td>
					<td>Raspberry Pi 3, OSMC, kodi, Wood</td>
				</tr>

				<!--ncbu-->
				<tr>
					<th scope="row"><a href="/projects/ncbu.php">ncbu</a></th>
					<td><a href="/projects/ncbu.php"><img class="thumbnail" src="/projects/images/ncbu/ncbu_01.png" /></a></td>
					<td>Docker container image to simplify and automate backup of a self-hosted nextcloud service.</td>
					<td class="date">2021-06-20</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/ncbu">gitlab</a><br />
						<a href="https://hub.docker.com/r/clewsy/ncbu">Docker Hub</a>
					</td>
					<td>Docker, Docker-Compose, DockerHub, Dockerfile, Nextcloud, Self-Host, Container, rsync, bash, shell script, MariaDB, MySQL, Cron, logrotate, tee</td>
				</tr>

				<!--p0wer-->
				<tr>
					<th scope="row"><a href="/projects/p0wer.php">p0wer</a></th>
					<td><a href="/projects/p0wer.php"><img class="thumbnail" src="/projects/images/p0wer/p0wer_01.jpg" /></a></td>
					<td>Simple rf mains remote switches hacked to add wifi control.</td>
					<td class="date">2021-06-15</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/p0wer">gitlab</a><br />
						<a href="https://core-electronics.com.au/projects/p0wer-control-mains-outlets-over-wifi">core-electronics</a>
					</td>
					<td>Raspberry Pi Zero W, <s>Raspbian</s>, Raspberry Pi OS, WiFi, 4066 CMOS Quad Bilateral Switch, 70HC4066, <s>wiringpi</s>, pigpio, Termux, C, HTML, CSS, PHP, Apache, curl, Automation, KiCAD, Reverse Engineer, Ansible</td>
				</tr>

				<!--rad10-->
				<tr>
					<th scope="row"><a href="/projects/rad10.php">rad10</a></th>
					<td><a href="/projects/rad10.php"><img class="thumbnail" src="/projects/images/rad10/small_rad10_01.jpg" /></a></td>
					<td>An internet radio on a raspberry pi with a simple hardware control daemon (and WebUI).</td>
					<td class="date">2021-06-07</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/rad10d">gitlab</a><br />
						<a href="https://core-electronics.com.au/projects/rad10">core-electronics</a>
					</td>
					<td>Quadrature Encoder, Raspberry Pi, <s>Raspbian</s>, Ubuntu, mpd, mpc, libmpdclient, <s>wiringpi</s>, pigpio, C, Daemon, systemd, Apache, PHP, HTML, CSS, Ansible, Wood</td>
				</tr>

				<!--scripts-->
				<tr>
					<th scope="row"><a href="/projects/scripts.php">scripts</a></th>
					<td><a href="/projects/scripts.php"><img class="thumbnail" src="/projects/images/scripts/scripts_01.png" /></a></td>
					<td>Various bash shell scripts.</td>
					<td class="date">2021-06-15</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/scripts">gitlab</a>
					</td>
					<td>Bash, Shell, Script, Linux, Debian, Ubuntu, Raspbian, Termux, echo, rsync, curl, apt-get, ssh, openvpn, ping, grep, lscpu, lspci, lsblk, df, uname, lsb_release, route, netstat, nmcli, ifconfig, ip, iw, iwgetid, command, printf, <s>ipinfo.io</s>, ifconfig.co</td>
				</tr>

				<!--temp0-->
				<tr>
					<th scope="row"><a href="/projects/temp0.php">temp0</a></th>
					<td><a href="/projects/temp0.php"><img class="thumbnail" src="/projects/images/temp0/small_temp0_22.jpg" /></a></td>
					<td>Temperature and humidity monitor with WiFi and local readout.</td>
					<td class="date">2021-02-21</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/temp0">gitlab</a><br />
						<a href="https://hackaday.io/project/171367-temp0">hackaday.io</a>
					</td>
					<td>Arduino, Pro-Trinket, Adafruit, HackADay, ESP8266, ESP-01, HDC1080, SSD1306, OLED, PlatformIO, C++, HTML, cURL, Serial, I2C</td>
				</tr>

				<!--volcon-->
				<tr>
					<th scope="row"><a href="/projects/volcon.php">volcon</a></th>
					<td><a href="/projects/volcon.php"><img class="thumbnail" src="/projects/images/volcon/small_volcon_21.jpg" /></a></td>
					<td>HID compliant USB volume controller from a VCR head drum and an optical encoder.</td>
					<td class="date">2021-07-02</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/volcon">gitlab</a><br />
						<a href="https://hackaday.com/2021/02/15/a-volume-control-from-a-vcr-drum/">hackaday</a><br />
						<a href="https://hackaday.io/project/177645-volcon">hackaday.io</a><br />
						<a href="https://core-electronics.com.au/projects/volcon">core-electronics</a>
					</td>
					<td>AVR, Atmel, <s>AT90usb162</s>, ATmega32U4, C, Eagle, USB, <s>Type-B</s>, Type-C, HID, LUFA, Quadrature Encoder, Gray Code, VCR, VHS, Wood, KiCad</td>
				</tr>

				<!--WiSHABI-->
				<tr>
					<th scope="row"><a href="/projects/wishabi.php">WiSHABI</a></th>
					<td><a href="/projects/wishabi.php"><img class="thumbnail" src="/projects/images/wishabi/small_wishabi_01.jpg" /></a></td>
					<td>WIreless Single-Handed Accelerometer-Based Interface. (Under-Grad thesis project).</td>
					<td class="date">2021-02-14</td>
					<td class="links">
						<a href="http://vusb.wikidot.com/project:wishabi">V-USB</a><br />
					</td>
					<td>AVR, Atmel, ATmega8, 433.92MHz, Wireless, USB, HID, C, Keyboard, Mouse, Accelerometer, ADXL330, University, Engineering</td>
				</tr>

				<!--Wood-->
				<tr>
					<th scope="row"><a href="/projects/wood.php">Wood</a></th>
					<td><a href="/projects/wood.php"><img class="thumbnail" src="/projects/wood/photos/wine_box/small_wine_box_30.jpg" /></a></td>
					<td>Stuff made from wood.</td>
					<td class="date">2021-06-03</td>
					<td class="links">

					</td>
					<td>Wood, Timber, Lumber, Cellulose, Former Tree, Hard Paper, Pre-Cardboard</td>
				</tr>

				<!--clewsy_ansible-->
				<tr>
					<th scope="row"><a href="/projects/clewsy_ansible.php">clewsy_ansible</a></th>
					<td><a href="/projects/clewsy_ansible.php"><img class="thumbnail" src="/projects/images/clewsy_ansible/clewsy_ansible_01.png" /></a></td>
					<td>Using Ansible to automate deplolyment, configuration and maintenance of the machines/devices on my home network.</td>
					<td class="date">2021-06-28</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/clewsy_ansible">gitlab</a><br />
					</td>
					<td>alias, android, Ansible, Apache, apt, bash, Beaglebone Black, chmod, chown, cifs, Conky, cron, cups curl, Debian, Docker, docker-compose, fstab, git, GitLab, Gnome, Guake, Home Assistant, htop, iftop, iperf3, LineageOS, Linux, lm-sensors, logrotate, midnight commander, motd, motion, motioneye, mount, mpc, mpd, Nautilus, ncdu, ncmpc, netdiscover, nfs, nmap, <s>OMV</s>, <s>OpenMediaVault</s>, OpenVPN, OSMC,  php, pigpio, pip, Pop_OS!, python, qbittorrent, Raspbian, Raspberry Pi, rsync, scripts, snap, Sonata, ssh, sshd, sudo, systemd,  Terminator, Termux, tmux, Ubuntu, ufw, Vim, VLC, vpn, VPS, VSCode, Watchtower, Wireguard, so much yaml</td>
				</tr>

				<!--clews.dev-->
				<tr>
					<th scope="row"><a href="/projects/clews_dev.php">clews.dev</a></th>
					<td><a href="/projects/clews_dev.php"><img class="thumbnail" src="/projects/images/clews_dev/clews_dev_01.png" /></a></td>
					<td>A site for experimenting.</td>
					<td class="date">2021-06-24</td>
					<td class="links">
						<a href="https://gitlab.com/clewsy/clews.pro">gitlab</a><br />
						<a href="https://clews.dev/index.php">clews.dev</a>
					</td>
					<td>HTML, CSS, PHP, Self-Host, Docker, Nginx, Inkscape, SVG</td>

				<!--Contributions-->
				<tr>
					<th scope="row"><a href="/projects/contributions.php">Contributions</a></th>
					<td><a href="/projects/contributions.php"><img class="thumbnail" src="/projects/images/contributions/contributions_03.png" /></a></td>
					<td>Pull requests merged into other people's projects.  I &lt;3 open source.</td>
					<td class="date">2021-03-03</td>
					<td class="links">
						<a href="https://github.com/rcdailey/nextcloud-cronjob/pull/4">nextcloud-cronjob</a><br />
						<a href="https://github.com/hassio-addons/addon-motioneye/pull/75">addon-motioney</a><br />
					</td>
					<td>Docker, dockerfile, git, GitHub, Home Assistant, motion, motioneye, Pull Request</td>
				</tr>
			</table><br />
		</div>
	</body>
</html>
