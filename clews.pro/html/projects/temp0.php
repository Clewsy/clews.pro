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
			<p>This project combined a handful of smaller project ideas:</p>
			<ul>
				<li>Make a device that monitors and reports the inside temperature at home.</li>
				<li>Learn how to use an ESP8266 chip.</li>
				<li>Put to use (and potentially showcase) a <a href="https://hackaday.com/2014/10/10/10th-anniversary-trinket-pro-now-in-the-hackaday-store/">Hackaday 10-year anniversary special-edition Pro-Trinket module</a> that has sat un-used for about 6 years.</li>
				<li>Try out the arduino platform (IDE and bootloader) instead of directly programming a microcontroller.</li>
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
			<p>It would be possible to create a similar device without a Pro Trinket, utilising more of the ESP8266 capability, but I wanted an excuse to use one of these Hackaday special edition modules.</p>
			<p>The ESP8266 serves a pretty HTML page at the index (http://temp0/) which shows the current temperature and humidity readings.</p>
			<a href="photos/temp0_01.jpg"><img class="photo align-right" src="photos/temp0_01.jpg" alt="Promotional photo of special edition Pro Trinket." /></a>
			<p>Certain sub-directories of the web-server will provide plain-text values of the temperature or humidity.  This is useful for home-automation implementatios (<a href="https://www.home-assistant.io/">Home Assistant</a> for example).</p>
			<p>Setting the ESP8266 hostname to "temp0", the useful http addresses are:</p>
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
			<p>Meh, the Arduino IDE wasn't much fun and I thought it felt a little dated so I started looking into alternatives.  I first tried the <a href="https://github.com/Microsoft/vscode-arduino">VSCode Arduino</a> extension which took some configuring but eventually worked.  Though I moved on from that when I found a better solution - the <a href=https://platformio.org/">PlatformIO IDE</a> extension for VSCode.  This was easy to set up and start using.  It adds a few buttons to the VSCode interface for compiling and uploading to a connected device.  The VSCode extensions also set me up with an integrated terminal console and integrated git management.  After a few weeks back-and-forth with PlatformIO I came to really like it and plan to use it for future embedded projects, even if I don't continue with the arduino bootloader.</p>
			<p>The standard arduino libraries are handy though.  In this project I used Serial (comms between Trinket and ESP8266) and Wire (I2C comms for Trinket/SD1306 and Trinket/HDC1080).  These libraries made it super-fast to get going with the low-level comms.  However, for both the SSD1306 OLED and HDC1080 Sensor, I opted to write my own drivers rather than use existing libraries.  Partly because it keeps the drivers more minimal and project-specific, and also partly because it was a fun learning experience to create C++ classes.</p>
			<hr />
			<h3>Thoughts on the ESP8266</h3>
			<p>While programming the ESP8266 I drew from existing example libraries.  At first I implemented some basic web-server functionality using AT commands sent from the Trinket over serial to the default ESP8266 firmware, but ultimately I switched to the more robust <a href="https://arduino-esp8266.readthedocs.io/en/latest/index.html">ESP8266 Arduino Core</a> libraries.  I was super impressed with the capability of the ESP-01 module combined with these libraries.</p>
			<hr />
			<h3>SSD1306</h3>
			<p>I had some prior familiarity with the SSD1306 OLED driver on a <a href="https://clews.pro/projects/grinder_timer.php">previous project</a>.  There are a couple of differences this time in how I implemented the driver:</p>
			<ul>
				<li>I used C++ instead of C.  This meant creating a class and declaring private and public functions.</li>
				<li>I made the character and string functions more efficient and (somewhat) more robust.</li>
			</ul>
			<p>  I can now just specify a font array and the char and string functions can print to the OLED regardless of font characteristics (character widths and height).  To do this I started with a <a href="http://oleddisplay.squix.ch/#/home">font file generator</a> created by <a href="https://blog.squix.org/about-me">Daniel Eichhorn</a> to generate a <a href="https://gitlab.com/clewsy/temp0/-/blob/master/temp0_pro_trinket/include/ssd1306_fonts.h">couple of fonts</a> with dimensions I thought would suit the project.  I then inspected the files generated to get my head around the font and character metadata so that I could create the <a href="https://gitlab.com/clewsy/temp0/-/blob/master/temp0_pro_trinket/src/ssd1306.cpp">print_char and print_string</a> functions.  The code has a lot of comments in these functions that I addeed as I went - this is part of my learning process.</p>
			</ul>
			<hr />
			<h3>HDC1080</h3>
			<p>The HDC1080 is a temperature and humidity sensor.  Similar to the OLED/SSD1306, I created a project-specific driver for it.  When testing the prototype system on a breadboard, I had the sensor attached with jumper leads which kept it 100mm or so from the rest of the components.  This worked fine and temperature readings matched another thermometer I used for comparison.  My first assembled PCB however reported temperatures 3-4 degrees higher.  I had placed the sensor on the PCB top side, immediadely opposite the 3.3V regulator on the bottom-side.  The waste heat from the regulator was therefore affecting the temperature readings.  For the subsequent iteration of the PCB, these two components were located more-or-less opposite corners (and opposite sides) of the PCB to give the sensor plento of trace to diisipate heat before affecting the HDC1080..</p>
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
