<!DOCTYPE html>
<html>
	<head>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/head.html"); ?>
	</head>
	<body>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.html"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">temp0</h2>
			<a href="photos/temp0_03.jpg"><img class="photo align-left" src="photos/small_temp0_03.jpg" alt="The final assembled temp0." /></a>
			<h3>Summary</h3>
			<p>This project combined a handful of small project ideas:</p>
			<ul>
				<li>Make a device that monitored and reported the inside temperature at home.</li>
				<li>Learn how to use an ESP8266 chip.</li>
				<li>Put to use (and potentially showcase) a <a href="https://hackaday.com/2014/10/10/10th-anniversary-trinket-pro-now-in-the-hackaday-store/">Hackaday 10-year anniversary special-edition Pro-Trinket module</a> that has sat un-used for about 6 years.</li>
				<li>Try out the arduino platform instead of natively programming a micro-controller.</li>
				<li>Use C++ for a microcontroller project instead of C.</li>
			</ul>
			<p>The final system is comprised of the following main components:</p>
			<ul>
				<li>ESP8266 (ESP-01 module) - Acts as a web-server to provide temperature/humidity over WiFi.</li>
				<li>HDC1080 module - Temperature/Humidity sensor that communicates over I2C.</li>
				<li>SSD1306 OLED module - also communicates over I2C - used as a local display for temperature/humidity readings.</li>
				<li>Pro Trinket 5V (Hackaday 10-Year Anniversary Special-Edition) - Controls the SSD1306 and the HDC1080.  Sends temperature/humidity readings over serial to the ESP8266 module.</li>
			</ul>
			<p>There is also a few additional minor components for regulating 5V from the trinket down to 3.3V for the ESP8266, OLED and HDC1080.</p>
			<p>I believe it would be possible to create a similar device without a Pro Trinket, utilising more of the ESP8266 capability, but I wanted an excuse to use one of these Hackaday special edition modules.</p>
			<p>The ESP8266 servers a pretty HTML page at the index (http://temp0/) which shows the current temperature and humidity readings.</p>
			<a href="photos/temp0_01.jpg"><img class="photo align-right" src="photos/temp0_01.jpg" alt="Promotional photo of special edition Pro Trinket." /></a>
			<p>Certain sub-directories of the web-server will provide plain-text values of the temperature or humidity.  This is useful for home-automation stuff.</p>
			<p>The working http addresses are:</p>
			<ul>
				<li>For html "pretty" temperature and humidity readings:
					<ul>
						<li>http://temp0</li>
					</ul>
				</li>
				<li>For plain-text temperature value (&deg;C):
					<ul>
						<li>http://temp0/temperature</li>
						<li>http://temp0/temp</li>
						<li>http://temp0/t</li>
					</ul>
				</li>
				<li>For plain-text humidity value (%):
					<ul>
						<li>http://temp0/humidity</li>
						<li>http://temp0/humi</li>
						<li>http://temp0/h</li>
					</ul>
				</li>
			</ul>
			<p>From a command line, a simple use of "curl" will provide plain-text temperature and humidity values for easy integration into other systems.</p>
			<p class="code">	$ curl http://temp0/temperature<br />
						15.68<br />
						$ curl http://temp0/humidity<br />
						70.69</p>
			<hr />
			<h3>Thoughts on <a href="https://www.arduino.cc/en/Main/Software">Arduino IDE</a> and programming firmware in C++</h3>
			<p>Meh, the Arduino IDE is pretty clunky and seems dated so I started looking into alternatives.  I first tried the <a href="https://github.com/Microsoft/vscode-arduino">VSCode Arduino</a> extension which took some configuring but eventually worked.  Though I moved on from that when I found a better solution - the <a href=https://platformio.org/">PlatformIO IDE</a> extension for VSCode.  This was easy to set up and start using.  It adds a few buttons to the VSCode interface for compiling and uploading to a connected device.  The only down-side in my opinion is the directory structure it forces and the cruft it generates within.</p>
			<p>The standard arduino libraries are handy though.  In this project I used Serial (comms between Trinket and ESP8266) and Wire (I2C comms for Trinket/SD1306 and Trinket/HDC1080).  These libraries made it super-fast to get going with the low-level comms.  For both the SSD1306 OLED and HDC1080 Sensor though, I opted to write my own drivers rather than use existing libraries.  Partly because it keeps the drivers more minimal and project-specific, and also partly because it was a fun learning experience to create C++ classes for them.</p>
			<hr />
			<h3>Thoughts on the ESP8266</h3>
			<p>While programming the ESP8266 I drew from existing example libraries.  At first I implemented some basic web-server functionality using AT commands sent from the Trinket over serial to the default ESP8266 firmware, but ultimately I switched to the more robust existing <a href="https://arduino-esp8266.readthedocs.io/en/latest/index.html">ESP8266 Arduino Core</a> libraries.  I was super impressed with the capability of the ESP-01 module combined with these libraries.</p>
			<hr />
			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="photos/temp0_02.jpg"><img class="photo" src="photos/small_temp0_02.jpg" alt="Early prototyping - pre-OLED." /></a></td>
					<td class="align-right"><a href="photos/temp0_03.jpg"><img class="photo" src="photos/small_temp0_03.jpg" alt="Prototyping - added OLED.." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="photos/temp0_04.jpg"><img class="photo" src="photos/small_temp0_04.jpg" alt="Prototyping - OLED close-up." /></a></td>
					<td class="align-right"><a href="photos/temp0_05.png"><img class="photo" src="photos/temp0_05.png" alt="Web Server as seen on an android smartphone." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="photos/temp0_06.png"><img class="photo" src="photos/temp0_06.png" alt="Revision 1 PCB design render - top." /></a></td>
					<td class="align-right"><a href="photos/temp0_07.png"><img class="photo" src="photos/temp0_07.png" alt="Revision 1 PCB design render - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="photos/temp0_08.jpg"><img class="photo" src="photos/small_temp0_08.jpg" alt="Revision 1 PCB fabricated - top." /></a></td>
					<td class="align-right"><a href="photos/temp0_09.jpg"><img class="photo" src="photos/small_temp0_09.jpg" alt="Revision 1 PCB fabricated - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="photos/temp0_10.jpg"><img class="photo" src="photos/small_temp0_10.jpg" alt="Revision 1 PCB partially populated." /></a></td>
					<td class="align-right"><a href="photos/temp0_11.jpg"><img class="photo" src="photos/small_temp0_11.jpg" alt="Revision 1 PCB assembled and testing." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="photos/temp0_12.png"><img class="photo" src="photos/temp0_12.png" alt="Revision 2 PCB design render - top." /></a></td>
					<td class="align-right"><a href="photos/temp0_13.png"><img class="photo" src="photos/temp0_13.png" alt="Revision 2 PCB design render - bottom." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
