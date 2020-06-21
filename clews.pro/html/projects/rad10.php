<!DOCTYPE html>
<html>
	<head>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/head.html"); ?>
	</head>
	<body>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.html"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">rad10</h2>
			<a href="images/rad10_01.jpg"><img class="photo align-left" src="images/small_rad10_01.jpg" alt="The final assembled rad10." /></a>
			<h3>Summary</h3>
			<p>The rad10 project consists of a raspberry pi outputting audio to a speaker via a small amplifier.</p>
			<p>The pi takes minimal input - a rotary encoder with a push-button toggle.  Rotate to control the volume, push the button to toggle pause/play</p>
			<p>A daemon written in C (<a href="https://gitlab.com/clewsy/rad10d">rad10d</a>) runs on the pi and polls for changes in the encoder or a push of the toggle button.  The code is available on <a href="https://gitlab.com/clewsy/rad10d">gitlab</a>.</p>
			<p>The daemon is set up as a service to run at boot.  It intefaces with <a href="https://www.musicpd.org/">MPD</a> using the API thanks to the <a href="https://www.musicpd.org/libs/libmpdclient/">libmpdclient</a> C/C++ library.</p>
			<p>Audio is output from the raspberry pi 3.5mm audio jack to a single speaker via a small amplifier module.</p>
			<p>Initially I found (via dmesg) that the raspberry pi occassionally triggered an undervolt warning.  It never crashed, but with some experimenting I found the under-voltage would occassionaly be triggered at higher volumes when the amplifier drew higher currents.  I fixed this by switching to a 4A  power supply capable of handling the peak loads.</p>
			<p>I prototyped with a breadboard until I got the code working before making it permanent.</p>
			<p>I had been experimenting with some hobbyist-level <a href="/projects/wood.php">woodworking</a> so I decided to put it all in a wooden box, most of which is recycled pallet wood. Access to the ethernet and usb ports was retained for alternative connectivity and the ability to play MP3s from a usb drive, but I almost exclusivley use it for playing a few streams over wifi.</p>
			<p>Mostly I use this self-contained, wifi-connected setup to stream radio, though it is set to locally mount an nfs share containing my music collection.</p>
			<p>There are a few MPD client apps for android that allow finer control of MPD (I like <a href="https://f-droid.org/en/packages/org.gateshipone.malp/">M.A.L.P.</a>)  That said, in keeping with the minimalist hardware interface, I created a similarly minimal web interface with a small amount of php, html and css.  This WebUI provides the same contol (play/pause and volume +/-), but I also added a few "preset" buttons to launch my most-used streams.</p>
			<hr />
			<h3>Daemon Installation and Setup</h3>
			<p>Install the dependencies:</p>
			<p class="code">$ sudo apt update<br />
					$ sudo apt install pigpio mpd mpc libmpdclient-dev</p>
			<p>(Note, <a href="https://www.musicpd.org/clients/mpc/">mpc</a> is not strictly required for the daemon, but I reccomend it as a useful command-line client for control of mpd, and debugging for a project like this.)</p>
			<p>Clone the repo and compile the executable "rad10d":</p>
			<p class="code">$ git clone https://gitlab.com/clewsy/rad10d<br />
					$ cd rad10d<br />
					$ make all</p>
			<p>Copy files to the relevant system directories:</p>
			<p class="code">$ sudo cp rad10d /usr/local/sbin/rad10d<br />
					$ sudo cp rad10d.service /lib/systemd/system/rad10d.service</p>
			<p>Enable and start the service:</p>
			<p>(This service is created so that the daemon runs at boot).</p>
			<p class="code">$ sudo systemctl enable rad10d.service<br />
					$ sudo systemctl start rad10d.service</p>
			<hr />
			<h3>WebUI Installation and Setup</h3>
			<p>For the raspberry pi to serve content over a browser, you will need to install web server software.  The following example uses <a href="https://httpd.apache.org/">Apache</a>.</p>
			<p>To give the WebUI the ability to execute commands, I used php code.  Therefore <a href="https://www.php.net/">php</a> will also need to be installed on the pi.</p>
			<p>The hardware daemon is not actually require for the WebUI.  This interface could be used with any pi running mpd and mpc.</p>
			<p>Install the dependencies:</p>
			<p class="code">$ sudo apt update<br/>
					$ sudo apt install apache2 php mpd mpc</p>
			<p>By default, Apache will serve up the content located within the "<i>/var/www/html/</i>" directory.  The default files installed at this location should be deleted and replaced by the contents of the "<i>webui</i>" directory in the rad10d repository:</p>
			<p class="code">$ sudo rm --recursive /var/www/html/*<br />
					$ git clone https://gitlab.com/clewsy/rad10d<br />
					$ cd rad10d/webui<br />
					$ sudo cp --recursive * /var/www/html/.</p>
			<p>(Note, cloning the gitlab repo can be skipped if already done to install the daemon.)</p>
			<p>The WebUI should now be accessible over your local network.</p>
			<hr />
			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="images/rad10_02.jpg"><img class="photo" src="images/small_rad10_02.jpg" alt="Rear view." /></a></td>
					<td class="align-right"><a href="images/rad10_03.jpg"><img class="photo" src="images/small_rad10_03.jpg" alt="Prototyping." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/rad10_04.png"><img class="photo" src="images/rad10_04.png" alt="WebUI on an android smartphone." /></a></td>
					<td class="align-right"><a href="images/rad10_05.png"><img class="photo" src="images/rad10_05.png" alt="WebUI on an android smartphone." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
