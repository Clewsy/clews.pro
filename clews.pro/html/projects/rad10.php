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
			<a href="images/rad10/rad10_01.jpg"><img class="photo align-left" src="images/rad10/small_rad10_01.jpg" alt="The final assembled rad10." /></a>
			<h3>Summary</h3>
			<p>The rad10 project consists of a <a href="https://www.raspberrypi.org/">raspberry pi</a>, a speaker and a small amplifier.</p>
			<p>The pi takes minimal input - a rotary encoder with a push-button toggle.  Rotate to control the volume, push the button to toggle pause/play</p>
			<p>A daemon written in C (<a href="https://gitlab.com/clewsy/rad10d">rad10d</a>) runs on the pi and polls for changes in the encoder or a push of the toggle button.  The code is available on <a href="https://gitlab.com/clewsy/rad10d">gitlab</a>.</p>
			<p>The daemon is configured as a service to run at boot.  It intefaces with <a href="https://www.musicpd.org/">MPD</a> using the API thanks to the <a href="https://www.musicpd.org/libs/libmpdclient/">libmpdclient</a> C/C++ library.</p>
			<p>Audio is output from the raspberry pi 3.5mm audio jack to a single speaker via a small amplifier module.</p>
			<p>Initially I found (via dmesg) that the raspberry pi occassionally triggered an undervolt warning.  It never crashed, but with some experimenting I found the under-voltage would occassionaly be triggered at higher volumes when the amplifier drew higher currents.  I fixed this by switching to a 4amp  power supply, combined with a big capacitor to help supply peak loads.</p>
			<p>I prototyped with a breadboard until I got the code working before making it permanent.</p>
			<p>I had been experimenting with some hobbyist-level <a href="/projects/wood.php">woodworking</a> so I decided to put it all in a wooden box, most of which is recycled pallet wood. Access to the ethernet and usb ports was retained for alternative connectivity and the ability to play MP3s from a usb drive, though I almost exclusivley use it for playing a few streams over wifi.</p>
			<p>Mostly I use this self-contained, wifi-connected setup to <a href="http://dir.xiph.org/genres/Electronic">stream</a> "radio", though it is set to locally mount an <a href="https://en.wikipedia.org/wiki/Network_File_System_(protocol)">nfs</a> share containing my music collection.</p>
			<p>There are a few MPD client apps for android that allow finer control of MPD (I like <a href="https://f-droid.org/en/packages/org.gateshipone.malp/">M.A.L.P.</a>)  That said, in keeping with the minimalist hardware interface, I created a similarly minimal web interface with a small amount of php, html and css.  This WebUI provides the same contol (play/pause and volume +/-), but I also added a few "preset" buttons to launch my most-used streams.</p>
			<hr />

			<h3>The Daemon</h3>
			<p>Written in C, the daemon code will compile to an executable called "rad10d".  The code draws from two libraries:</p>
			<ul>
				<li><b><a href="http://abyz.me.uk/rpi/pigpio/cif.html">pigpio</a></b> - A C library written to allow control of the GPIO pins on a Raspberry Pi.</li>
				<li><b><a href="https://musicpd.org/libs/libmpdclient/">libmpdclient</a></b> - a C library written to allow interfacing with <a href="https://musicpd.org/">mpd</a> (Music Player Daemon).</li>
			</ul>
			<p>Using the pigpio library, three of the raspberry pi gpio pins are configured as inputs.  Although there are multiple pins that could be used for interfacing with an encoder, following is the configuration I implemented:</p>
			<ul>
				<li>Pin 14 - Connected to channel A of the optical encoder.</li>
				<li>Pin 15 - Connected to channel B of the optical encoder.</li>
				<li>Pin 18 - Connected to the encoder momentary push-button.</li>
			</ul>
			<p>All three pins are configured to trigger one of two interrupt sub-routines (ISR):</p>
			<ol>
				<li><b>volume_ISR</b> - A state change of either of the optical encoder channels will trigger this ISR.  Using 2-bit <a href="https://en.wikipedia.org/wiki/Gray_code">Gray-code</a>, the ISR will determine which direction the encoder has turned.  A clockwise rotation will set a variable that will trigger an increase in volume.  Conversely, a counter-clockwise rotation will set the variable so that a volume decrease is triggered.</li>
				<li><b>button_ISR</b> - A state change of the push-button will trigger this ISR.  A software de-bounce is implemented by comparing "tick" (effectively timestamp) variables.  Similarly, ticks are recorded and compared when the button is pressed and when it is released so that the daemon can tell if a short- (&lt;2 seconds) or long-press (&gt;2 seconds) has occurred.  A variable will be set to trigger either toggle (play/pause) for a short-press, or stop for a long-press.</li>
			</ol>
			<p>The main routine of the daemon includes an infinite loop that will poll flags set by the ISRs.  Said flags will trigger functions that use the libmpdclient library to control mpd with volume-up, volume-down, play, pause or stop signals.
			<hr />


			<h3>Daemon Installation and Setup</h3>
			<p>Install the dependencies:</p>
			<div class="code"><p class="terminal">
				$ sudo apt update<br />
				$ sudo apt install pigpio mpd mpc libmpdclient-dev
			</p></div>
			<p>(Note, <a href="https://www.musicpd.org/clients/mpc/">mpc</a> is not strictly required for the daemon, but I recommend it as a useful command-line client for control of mpd, and debugging for a project like this.)</p>
			<p>Clone the repo and compile the executable "rad10d":</p>
			<div class="code"><p class="terminal">
				$ git clone https://gitlab.com/clewsy/rad10d<br />
				$ cd rad10d<br />
				$ sudo make install
			</p></div>
			<p>The install target in the makefile will automatically compile/install the daemon and also enable/start the systemd service so that the daemon will run at boot.  running <b>make install</b> is equivalent to running the following commands:</p>
			<div class="code"><p class="terminal">
				$ make<br />
				$ sudo cp rad10d /usr/local/sbin/rad10d<br />
				$ sudo cp rad10d.service /lib/systemd/system/rad10d.service<br />
				$ sudo systemctl enable rad10d.service<br />
				$ sudo systemctl start rad10d.service
			</p></div>
			<p>The installation can be reversed with the uninstall target:</p>
			<div class="code"><p class="terminal">
				$ sudo make uninstall
			</p></div>
			<hr />

			<h3>WebUI Installation and Setup</h3>
			<p>For the raspberry pi to serve content over a browser, you will need to install web server software.  The following example uses <a href="https://httpd.apache.org/">Apache</a>.</p>
			<p>To give the WebUI the ability to execute commands, I used php code.  Therefore <a href="https://www.php.net/">php</a> will also need to be installed on the pi.</p>
			<p>The hardware daemon is not actually require for the WebUI.  This interface could be used with any pi or other computer running mpd and mpc.</p>
			<p>Install the dependencies:</p>
			<div class="code"><p class="terminal">
				$ sudo apt update<br/>
				$ sudo apt install apache2 php mpd mpc
			</p></div>
			<p>By default, Apache will serve up the content located within the <i>/var/www/html/</i> directory.  The default files installed at this location should be deleted and replaced by the contents of the "<i>webui</i>" directory in the rad10d repository:</p>
			<div class="code"><p class="terminal">
				$ sudo rm --recursive /var/www/html/*<br />
				$ git clone https://gitlab.com/clewsy/rad10d<br />
				$ cd rad10d/webui<br />
				$ sudo cp --recursive * /var/www/html/.
			</p></div>
			<p>(Note, cloning the gitlab repo can be skipped if this was already done to install the daemon.)</p>
			<p>The WebUI should now be accessible over your local network.</p>
			<hr />

			<h3>Ansible Deployment</h3>
			<p>As part of another project (<a href="/projects/clewsy_ansible.php">clewsy_ansible</a>) I have automated installation of the daemon and the webui.  Starting with a fresh <a href="https://www.raspberrypi.org/downloads/">Raspberry Pi OS</a> or <a href="https://ubuntu.com/download/raspberry-pi">Ubuntu Server</a> installation on a raspberry pi, I can run a single <a href="https://gitlab.com/clewsy/clewsy_ansible/-/blob/master/rad10.yml">playbook</a> that will install the dependencies, clone and install the daemon and configure the webui.  See the <a href="https://gitlab.com/clewsy/clewsy_ansible">clewsy_ansible</a> gitlab repository and specifically the <a href="https://gitlab.com/clewsy/clewsy_ansible/-/blob/master/roles/rad10/tasks/main.yml">main rad10 role</a> for more information.</p>
			<hr />

			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="images/rad10/rad10_02.jpg"><img class="photo" src="images/rad10/small_rad10_02.jpg" alt="Rear view." /></a></td>
					<td class="align-right"><a href="images/rad10/rad10_03.jpg"><img class="photo" src="images/rad10/small_rad10_03.jpg" alt="Prototyping." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/rad10/rad10_04.png"><img class="photo" src="images/rad10/rad10_04.png" alt="WebUI on an android smartphone." /></a></td>
					<td class="align-right"><a href="images/rad10/rad10_05.png"><img class="photo" src="images/rad10/rad10_05.png" alt="WebUI on an android smartphone." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/rad10/rad10_06.jpg"><img class="photo" src="images/rad10/small_rad10_06.jpg" alt="Opened to add a capacitor." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
