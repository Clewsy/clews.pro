<!DOCTYPE html>
<html>
	<head>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/head.html"); ?>
	</head>
	<body>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.html"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">p0wer</h2>
			<a href="images/p0wer_01.jpg"><img class="photo align-left" src="images/p0wer_01.jpg" alt="The final assembly in a simple enclosure." /></a>
			<h3>Summary</h3>
			<p>Off-the-shelf wifi-connected mains switches are pretty common now, but from what I understand, they typically require some kind of cloud service subscription or account (at least at the time I developed this project).</p>
			<p>I am loath to sign up for such an account and even more so, I want to retain control within my local network, with external control only via specific protocols &amp; ports under my control.</p>
			<p>By combining a cheap (&lt;$.0AUD) remote mains adapter kit with an RF remote control and a <a href="https://www.raspberrypi.org/products/raspberry-pi-zero-w/">Raspberry Pi Zero W</a>, I developed a custom solution.</p>
			<hr />
			<h3>Hardware</h3>
			<p>I started off with a mains outlet remote control kit I found at <a href="https://www.bunnings.com.au/arlec-remote-controlled-power-outlet-twin-pack_p0095172">Bunnings</a>. It's an Arlec branded kit and works by transmitting on the 433.92MHz band. The remote can control up to four channels (A, B, C &amp; D).</p>
			<p>To interface the remote control I had to reverse engineer it. I assumed it would be a matter of tracing the button pads and finding a point to which I could connect a GPIO pin on the Raspberry Pi and simply pull up or down to trigger.</p>
			<p>This wasn't the case - I found that the button pads were matrixed, so triggering a channel required connecting two specific points with each other, depending on the channel and the desired action ("on" or "off").</p>
			<a href="images/p0wer_02.jpg"><img class="photo align-right" src="images/p0wer_02.jpg" alt="Hacked remote control." /></a>
			<p>As such, instead of direcly connecting the remote to the GPIO, I used the GPIO to trigger bilateral switches within a couple of 4066 CMOS quad bilateral switch packages.  These switches then short the two contacts to emulate a button press on the remote.</p>
			<p>I broke out the contacts on the remote via a pin-header and assembled the intermediate interface circuit on some proto-board.</p>
			<p>The final assembled interface circuit included headers for connecting the raspbrry pi and the hacked remote.</p>
			<p>I added a barrel jack for power and put the assembly inside a dust-resistant plastic case.</p>
			<hr />
			<h3>Code</h3>
			<p>In C I wrote a program that takes the desired channel (A, B, C or D) and desired action ("on" or "off") and then pulses the remote control to emulate pressing the desired button.</p>
			<p>The code and <a href="https://kicad-pcb.org/">KiCad</a> files are on the <a href="https://gitlab.com/clewsy/p0wer">gitlab repo</a>.</p>
			<p>The program interfaces with the gpio via the <s>wiringpi</s> <a href="http://abyz.me.uk/rpi/pigpio/index.html">pigpio</a> library.</p>
			<p>Program usage follows:</p>
			<p class="code">$ sudo p0wer &lt;channel(a,b,c,d)&gt; &lt;on/off&gt;</p>
			<p>Super user access is required for manipulation of the gpio pins.</p>
			<hr />
			<h3>Installation</h3>
			<p>On the raspberry pi install the pigpio library:</p>
			<p class="code">$ sudo apt update<br/>
					$ sudo apt install pigpio</p>
			<p>Clone this repository and enter the cloned project directory:</p>
			<p class="code">$ git clone https://gitlab.com/clewsy/p0wer<br/>
					$ cd p0wer</p>
			<p>Compile and install the executable:</p>
			<p class="code">$ sudo make install</p>
			<p>The binary is now ready to use.  This can be tested by running the command with no arguments.  It should print the usage to screen.</p>
			<p class="code">$ p0wer<br/>
					Usage: p0wer <channel(a,b,c,d)> <on/off></p>
			<p><b>NOTE</b> using the <b>sudo make install</b> command as per the instructions above will automatically set the SUID bit (i.e. set the setuid flag) for the executable file.  This means it is executed with owner (root) privileges.  As such, it can be run (and the GPIO pins can be manipulated) with out prepending the command with sudo.  If you want to install the file without this permission, use the following commands instead of running <b>sudo make install</b>:</p>
			<p class="code">$ make<br/>
					$ sudo cp p0wer /usr/local/sbin/p0wer</p>


			<hr />
			<h3>Usage</h3>
			<p>In the future, I intend to facillitate switching of these mains outlet units via a web-server.  However until I finish that project, manipulating the outlets is done by running the compiled program.</p>
			<p>(Alternatively, I also have a second, non-hacked remote that similarly facillitates control of the outlets.)</p>
			<p>I currently use a <a href="https://termux.com/">Termux</a> shortcut on my android smartphone to run a script that calls the program on the pi.  By pressing a button on my homescreen, I can, for example, switch on a lamp in the lounge room.</p>
			<p>The script will connect to the raspberry pi (using ssh) and run the program with the desired inputs.</p>
			<p>The following example two-line script will connect to the pi and run the program with the options to turn on the channel A outlet:</p>
			<p class="code">#!/bin/bash<br/>
					ssh home.server 'ssh raspberry.pi "sudo p0wer a on"'</p>
			<p>The full termux script I wrote is a bit more robust (and documented on <a href="https://gitlab.com/clewsy/scripts/blob/master/p0wer_switch.sh">gitlab</a>).</p>
			<hr />
			<h3>Revision 2.0</h3>
			<p>In August 2019, support <a href="http://wiringpi.com/wiringpi-deprecated/">ceased</a> for the wiringPi library.  As such, I revised the code to instead utilise the <a href="http://abyz.me.uk/rpi/pigpio/index.html">pigpio</a> library.</p>
			<p>While I was at it, I updated the KiCad schematic to work with the latest KiCad revision.</p>
			<hr />
			<h3>WebUI</h3>
			<p>In December 2019, I decided to create a simple web interface for controlling all 4 channels from a browser.  I wrote a simple php script and combined it with some basic html and css.  Combined with <a href="http://www.apache.org/">Apache</a> and <a href="https://www.php.net/">php</a> installed on the raspberry pi, I am now able to control power points from and browser with access to the local network.  To achieve this I learned about setting the SUID bit on an executable so that when called by the web user (www-data) it is still executed as root.  WebUI setup instructions can be found in the <a href="https://gitlab.com/clewsy/p0wer">README</a> at gitlab.</p>
			<p>As a bonus, the webui allows me to script control of the remote units using a <a href="https://curl.haxx.se/">curl</a> command as an alternative to ssh.  Using curl to control the outlets enables simple integration into automation platforms such as <a href="https://www.openhab.org/">openHAB</a> or <a href="https://www.home-assistant.io/">Home Assistant</a>.  The following example commands produce an equivalent result (turning on channel a).</p>
			<p><b>Using ssh</b> (user <b>pi</b> on host <b>raspberrypi</b>):</p>
			<p class="code">$ ssh pi@raspberrypi "sudo p0wer a on"</p>
			<p><b>Using curl</b> (hostname <b>raspberrypi</b> or host IP <b>192.168.1.123</b>):</p>
			<p class="code">$ curl --silent http://raspberrypi/index.php?a=ON &gt;&gt; /dev/null</p>
			<p>or</p>
			<p class="code">$ curl --silent http://192.168.1.123/index.php?a=ON &gt;&gt; /dev/null</p>
			<hr />
			<h3>Ansible Deployment</h3>
			<p>As part of another project (<a href="/projects/clewsy_ansible.php">clewsy_ansible</a>) I have automated installation of the p0wer command and the webui.  Starting with a fresh <a href="https://www.raspberrypi.org/downloads/">Raspberry Pi OS</a> installation on a raspberry pi, I can run a single <a href="https://gitlab.com/clewsy/clewsy_ansible/-/blob/master/p0wer.yml">playbook</a> that will install the dependencies, clone and install the executable and configure the webui.  See the <a href="https://gitlab.com/clewsy/clewsy_ansible">clewsy_ansible</a> gitlab repository and specifically the <a href="https://gitlab.com/clewsy/clewsy_ansible/-/blob/master/roles/p0wer/tasks/main.yml">main p0wer role</a> for more information.</p>
			<hr />
			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="images/p0wer_03.jpg"><img class="photo" src="images/p0wer_03.jpg" alt="Off-the-shelf 433.92MHz mains remote control kit." /></a></td>
					<td class="align-right"><a href="images/p0wer_04.jpg"><img class="photo" src="images/p0wer_04.jpg" alt="Intermediate interface board with the 4066 chips." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/p0wer_05.jpg"><img class="photo" src="images/p0wer_05.jpg" alt="Assembled circuit." /></a></td>
					<td class="align-right"><a href="images/p0wer_06.png"><img class="photo" src="images/p0wer_06.png" alt="Schematic." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/p0wer_07.png"><img class="photo" src="images/p0wer_07.png" alt="Rev_2.0 Schematic." /></a></td>
					<td class="align-right"><a href="images/p0wer_08.png"><img class="photo" src="images/p0wer_08.png" alt="WebUI on an Android device" /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
