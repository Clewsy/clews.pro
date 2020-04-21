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
			<a href="photos/p0wer_1.jpg"><img class="photo align-left" src="photos/p0wer_1.jpg" alt="The final assembly in a simple enclosure." /></a>
			<h3>Summary</h3>
			<p>Off-the-shelf wifi-connected mains switches are pretty common now, but from what I understand, they typically require some kind of cloud service subscription or account (at least at the time I developed this project).</p>
			<p>I am loath to sign up for such an account and even more so, I want to retain control within my local network, with external control only via specific protocols &amp; ports under my control.</p>
			<p>By combining a cheap (&lt;$20AUD) remote mains adapter kit with an RF remote control and a Raspberry Pi Zero W, I deeloped a custom solution.</p>
			<hr />
			<h3>Hardware</h3>
			<p>I started off with a mains outlet remote control kit I found at Bunnings. It's an Arlec branded kit and works by transmitting on the 433.92MHz band. The remote can control up to four channels (A, B, C &amp; D).</p>
			<p>To interface the remote control I had to reverse engineer it. I assumed it would be a matter of tracing the button pads and finding a point to which I could connect a GPIO pin on the Raspberry Pi and simply pull up or down to trigger.</p>
			<p>This wasn't the case - I found that the button pads were matrixed, so triggering a channel required connecting two specific points with each other, depending on the channel and the desired action ("on" or "off").</p>
			<a href="photos/p0wer_2.jpg"><img class="photo align-right" src="photos/p0wer_2.jpg" alt="Hacked remote control." /></a>
			<p>As such, instead of direcly connecting the remote to the GPIO, I used the GPIO to trigger bilateral switches within a couple of 4066 CMOS quad bilateral switch packages.  These switches then short the two contacts to emulate a button press on the remote.</p>
			<p>I broke out the contacts on the remote via a pin-header and assembled the intermediate interface circuit on some proto-board.</p>
			<p>The final assembled interface circuit included headers for connecting the raspbrry pi and the hacked remote.</p>
			<p>I added a barrel jack for power and put the assembly inside a dust-resistant plastic case.</p>
			<hr />
			<h3>Code</h3>
			<p>In C I wrote a program that takes the desired channel (A, B, C or D) and desired action ("on" or "off") and then pulses the remote control to emulate pressing the desired button.</p>
			<p>The code and KiCad files are on gitlab: <a href="https://gitlab.com/clewsy/p0wer">https://gitlab.com/clewsy/p0wer</a></p>
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
			<p>Compile the executable:</p>
			<p class="code">$ make all</p>
			<p>The binary is now ready to use.  For frequent calls it can be copied to the /usr/local/sbin directory:</p>
			<p class="code">$ sudo cp p0wer /usr/local/sbin/p0wer</p>
			<hr />
			<h3>Usage</h3>
			<p>In the future, I intend to facillitate switching of these mains outlet units via a web-server.  However until I finish that project, manipulating the outlets is done by running the compiled program.</p>
			<p>(Alternatively, I also have a second, non-hacked remote that similarly facillitates control of the outlets.)</p>
			<p>I currently use a Termux shortcut on my android smartphone to run a script that calls the program on the pi.  By pressing a button on my homescreen, I can, for example, switch on a lamp in the lounge room.</p>
			<p>The script will connect to the raspberry pi (using ssh) and run the program with the desired inputs.</p>
			<p>The following example two-line script will connect to the raspi via the home server and run the program with the options to turn on the channel A outlet:</p>
			<p class="code">#!/bin/bash<br/>
					ssh home.server 'ssh raspberry.pi "sudo p0wer a on"'</p>
			<p>The full termux script I wrote is a bit more robust (and documented on gitlab: <a href="https://gitlab.com/clewsy/scripts/blob/master/p0wer_switch.sh">p0wer_switch.sh</a>).</p>
			<hr />
			<h3>Revision 2.0</h3>
			<p>In August 2019, support ceased for the wiringPi library.  As such, I revised the code to instead utilise the <a href="http://abyz.me.uk/rpi/pigpio/index.html">pigpio</a> library.</p>
			<p>While I was at it, I updated the KiCad schematic to work with the latest KiCad revision.</p>
			<hr />
			<h3>WebUI</h3>
			<p>In December 2019, I decided to create a simple web interface for controlling all 4 channels from a browser.  I wrote a simple php script and combined it with some basic html and css.  Combined with Apache and ph installed on the raspberry pi, I am now able to control power points from and browser with access to the local network.  To achieve this I learned about setting the SUID bit on an executable so that when called by the web user (www-data) it is still executed as root.  WebUI setup instructions can be found in the <a href="https://gitlab.com/clewsy/p0wer">README</a> at gitlab.</p>
			<p>As a bonus, the webui allows me to scrip control of the remote units using a cURL command as an alternative to ssh.  Using cURL to control the outlets enables simple integration into automation platforms such as <a href="https://www.openhab.org/">openHAB</a> or <a href="https://www.home-assistant.io/">Home Assistant</a>.  The following commands procuce an equivalent result (turning on channel a).</p>
			<ul>
				<li>Using ssh (user "pi" on host "raspberrypi"):</li>
			</ul>
				<p class="code">$ ssh pi@raspberrypi "sudo p0wer a on"</p>
			<ul>
				<li>Using cURL (host "raspberrypi"):</li>
			</ul>
				<p class="code">$ curl --silent http://raspberrypi/index.php?a=ON &gt;&gt; /dev/null</p>
			<hr />
			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="photos/p0wer_3.jpg"><img class="photo" src="photos/p0wer_3.jpg" alt="Off-the-shelf 433.92MHz mains remote control kit." /></a></td>
					<td class="align-right"><a href="photos/p0wer_4.jpg"><img class="photo" src="photos/p0wer_4.jpg" alt="Intermediate interface board with the 4066 chips." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="photos/p0wer_5.jpg"><img class="photo" src="photos/p0wer_5.jpg" alt="Assembled circuit." /></a></td>
					<td class="align-right"><a href="photos/p0wer_6.png"><img class="photo" src="photos/p0wer_6.png" alt="Schematic." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="photos/p0wer_7.png"><img class="photo" src="photos/p0wer_7.png" alt="Rev_2.0 Schematic." /></a></td>
					<td class="align-right"><a href="photos/p0wer_8.png"><img class="photo" src="photos/p0wer_8.png" alt="WebUI on an Android device" /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
