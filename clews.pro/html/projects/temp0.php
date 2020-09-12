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
			<a href="images/temp0/temp0_22.jpg"><img class="photo align-left" src="images/temp0/small_temp0_22.jpg" alt="The final assembled temp0." /></a>
			<h3>Summary</h3>
			<p>This project combined a handful of smaller project ideas:</p>
			<ul>
				<li>Make a device that monitors and reports the inside temperature at home.</li>
				<li>Learn how to use an <a href="http://esp8266.net/">ESP8266</a> chip.</li>
				<li>Put to use (and potentially showcase) a <a href="https://hackaday.com/2014/10/10/10th-anniversary-trinket-pro-now-in-the-hackaday-store/">Hackaday 10-year anniversary special-edition Pro-Trinket module</a> that has sat un-used for about 6 years.</li>
				<li>Try out the <a href="https://www.arduino.cc/">arduino</a> platform (IDE and bootloader) instead of directly programming a microcontroller.</li>
				<li>Use C++ for a microcontroller project instead of C.</li>
			</ul>
			<p>The final system is comprised of the following main components:</p>
			<ul>
				<li>ESP8266 (ESP-01 module) - Acts as a web-server to provide temperature and humidity readings over http/WiFi.</li>
				<li><a href="https://www.ti.com/product/HDC1080">HDC1080</a> module - Temperature/Humidity sensor that communicates over I2C.</li>
				<li>SSD1306 OLED module - also communicates over I2C - used as a local display for temperature/humidity readings.</li>
				<li>Pro Trinket 5V (Hackaday 10-Year Anniversary Special-Edition) - Controls the SSD1306 and the HDC1080.  Sends temperature/humidity readings over serial to the ESP8266 module.</li>
			</ul>
			<p>There are a few additional minor components for level-shifting serial comms and regulating 5V from USB down to 3.3V for the ESP8266 and HDC1080.</p>
			<p>It would be possible to create a similar device without a Pro Trinket, utilising more of the ESP8266 capability, but I wanted an excuse to use one of these Hackaday special edition modules.</p>
			<p>The ESP8266 serves a pretty HTML page at the index (http://temp0/) which shows the current temperature and humidity readings.</p>
			<p>Certain sub-directories of the web-server will provide plain-text values of the temperature or humidity.  This is useful for home-automation implementatins (e.g. <a href="https://www.home-assistant.io/">Home Assistant</a>).</p>
			<a href="images/temp0/temp0_01.jpg"><img class="photo align-right" src="images/temp0/temp0_01.jpg" alt="Promotional photo of special edition Pro Trinket." /></a>
			<p>The ESP8266 hostname is set to "temp0", making the useful http addresses as follows:</p>
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
			<p>From a command line, a simple use of "curl" will provide plain-text temperature and humidity values for simple integration into other systems.</p>
			<div class="code">
				<p class="terminal">	$ curl http://temp0/temperature<br />
							15.68<br />
							$ curl http://temp0/humidity<br />
							70.69</p>
			</div>
			<p>Code (for the Pro-Trinket and the ESP8266) and KiCAD schematic/layout can all be found at the <a href="https://gitlab.com/clewsy/temp0">GitLab repo</a>.</p>
			<hr />

			<h3>Thoughts on <a href="https://www.arduino.cc/en/Main/Software">Arduino IDE</a> and programming firmware in C++</h3>
			<p>Meh, the Arduino IDE wasn't much fun and I thought it felt a little dated, so I started looking into alternatives.  I first tried the <a href="https://github.com/Microsoft/vscode-arduino">VSCode Arduino</a> extension which took some configuring but eventually worked.  Though I moved on from that when I discovered a better solution - the <a href="https://platformio.org/">PlatformIO IDE</a> extension for VSCode.  This was easy to set up and start using.  It adds a few buttons to the VSCode interface for compiling and uploading to a connected device.  Being a VSCode extension means I also have an integrated terminal console and integrated git management.  After a few weeks back-and-forth with PlatformIO I came to really like it and plan to use it for future embedded projects, even if I don't continue with the arduino bootloader.</p>
			<p>The standard arduino libraries are handy though.  In this project I used <a href="https://www.arduino.cc/reference/en/language/functions/communication/serial/">Serial</a> (comms between Trinket and ESP8266) and <a href="https://www.arduino.cc/en/Reference/Wire">Wire</a> (I2C comms for Trinket/SD1306 and Trinket/HDC1080).  These libraries made it super-fast to get going with the low-level comms.</p>
			<p>For both the SSD1306 OLED and HDC1080 Sensor however, I opted to write my own drivers rather than use existing libraries.  Partly because it keeps the drivers more minimal and project-specific, and also partly because it was a fun learning experience to create C++ classes.</p>
			<hr />

			<a href="images/temp0/temp0_25.png"><img class="photo align-left" src="images/temp0/temp0_25.png" alt="Web Server as seen on an android smartphone." /></a>
			<h3>Thoughts on the ESP8266</h3>
			<p>While programming the ESP8266 I drew from existing example libraries.  At first I implemented some basic web-server functionality using AT commands sent from the Trinket over serial to the default ESP8266 firmware, but ultimately I switched to the more robust <a href="https://arduino-esp8266.readthedocs.io/en/latest/index.html">ESP8266 Arduino Core</a> libraries.  I was super impressed with the capability of the ESP-01 module combined with these libraries.</p>
			<hr />

			<h3>SSD1306</h3>
			<p>I had some prior familiarity with the SSD1306 OLED driver on a <a href="https://clews.pro/projects/grinder_timer.php">previous project</a>.  There are a few differences this time in the way I implemented the driver:</p>
			<ul>
				<li>The module I used was configued for I2C comms instead of SPI.</li>
				<li>C++ instead of C.  This meant creating a class and declaring private and public functions.</li>
				<li>Character and string functions were made more efficient and (somewhat) more robust.</li>
			</ul>
			<p>To display text on the oled, I can now just specify a font array plus coordinates, and the char/string functions will output to the SSD1306/OLED regardless of font characteristics (character widths and font height).  To create the char/string functions I started with a <a href="http://oleddisplay.squix.ch/#/home">font file generator</a> created by <a href="https://blog.squix.org/about-me">Daniel Eichhorn</a> to generate a <a href="https://gitlab.com/clewsy/temp0/-/blob/master/temp0_pro_trinket/include/ssd1306_fonts.h">couple of fonts</a> with dimensions I thought would suit the project.  After getting my head around the font and character metadata embedded in the array, I was able to create the <a href="https://gitlab.com/clewsy/temp0/-/blob/master/temp0_pro_trinket/src/ssd1306.cpp">print_char and print_string</a> functions.  The code has a lot of comments around these functions that I added as I went - this is part of my learning process, plus I'm sure I'll have to re-learn this one day when I return to the project for whatever reason.</p>
			<hr />

			<h3>HDC1080</h3>
			<p>The HDC1080 is a temperature and humidity sensor that interfaces over I2C.  Similar to the OLED/SSD1306, I wrote a project-specific driver for it.</p>
			<p>When testing the prototype system on a breadboard, I had the sensor attached with jumper leads which gave it 100mm or so clearance from the rest of the components.  This worked fine and temperature readings matched another thermometer I used for comparison.  My first assembled PCB however reported temperatures 3-4 degrees higher.  I had located the sensor on the PCB too close to the 3.3V regulator on the opposite side, so the waste heat from the regulator was affecting the temperature readings.  For the subsequent iteration of the PCB, these two components were located at opposite corners and sides of the PCB to give the sensor additional copper into which it could dissipate heat.  This improved the accuracy of the sensor readings, but it was still showing higher than my callibration thermometer.  Fortunately the delta was a consistent value regardless of temperature so ultimately I added a bodge-factor in code to compensate.</p>
			<hr />

			<h3>PCB</h3>
			<p>The schematic and PCB layouts were created with <a href="https://kicad-pcb.org/">KiCad</a>.  Early iterations included a header for an FTDI serial adapter intended to facillitate programming of the ESP-01.  This was removed from the final PCB iteration for simplicity.</p>
			<p>A few component symbols and footprints were custom made:</p>
			<ul>
				<li>OLED module - these are pretty cheap but non-standard.  I made the footprint to match the actual model I intended to install (dimensions vary from module-to-module depending on the manufacturer).  Also, some versions of this module have the GND and VCC pins in the opposite order.</li>
				<li>HDC1080 module - I just couldn't find this footprint online anywhere.</li>
				<li>Pro Trinket - Since I intended to install this module backwards (up-side-down?) to show off the special-edition silk-screen, I had to create a new, reversed footprint.</li>
				<li>ESP8266/ESP-01 - After making the three footprints above, I was pretty comfortable with the process so I made a custom symbol and footprint for the ESP-01 as well.  I'm sure this is probably easily found elsewhere.</li>
			</ul>

			<hr />
			<h3>Final Assembly</h3>
			<p>Since the idea was to show off the Pro Trinket, I designed the PCB to suit an enclosure with a transparent lid that I had on hand.  A panel mount micro-usb port on the side supplies power and also passes through data to allow re-programming without opening the case (for the Pro-Trinket at least - programming the ESP-01 requires removal of the module from the rest of the unit).</p>
			<p>A push-button on top cycles through the different display modes.  I included an LED on one of the analogue outputs which really doesn't serve much purpose except to add some extra bling.  It is just set to pulse continuously.  I located it so that it shines through the mounting hole on the Pro Trinket right under the Jolly-Wrencher symbol.</p>
			<hr />

			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="images/temp0/temp0_23.gif"><img class="photo" src="images/temp0/small_temp0_23.gif" alt="Demo - start-up." /></a></td>
					<td class="align-right"><a href="images/temp0/temp0_24.gif"><img class="photo" src="images/temp0/temp0_24.gif" alt="Demo - modes." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/temp0/temp0_02.jpg"><img class="photo" src="images/temp0/small_temp0_02.jpg" alt="Early prototyping - pre-OLED." /></a></td>
					<td class="align-right"><a href="images/temp0/temp0_03.jpg"><img class="photo" src="images/temp0/small_temp0_03.jpg" alt="Prototyping - added OLED." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/temp0/temp0_04.jpg"><img class="photo" src="images/temp0/small_temp0_04.jpg" alt="Prototyping - OLED close-up." /></a></td>
					<td class="align-right"><a href="images/temp0/temp0_05.png"><img class="photo" src="images/temp0/temp0_05.png" alt="Web Server as seen on an android smartphone." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/temp0/temp0_06.png"><img class="photo" src="images/temp0/temp0_06.png" alt="Revision 1 PCB design render - top." /></a></td>
					<td class="align-right"><a href="images/temp0/temp0_07.png"><img class="photo" src="images/temp0/temp0_07.png" alt="Revision 1 PCB design render - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/temp0/temp0_08.jpg"><img class="photo" src="images/temp0/small_temp0_08.jpg" alt="Revision 1 PCB fabricated - top." /></a></td>
					<td class="align-right"><a href="images/temp0/temp0_09.jpg"><img class="photo" src="images/temp0/small_temp0_09.jpg" alt="Revision 1 PCB fabricated - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/temp0/temp0_10.jpg"><img class="photo" src="images/temp0/small_temp0_10.jpg" alt="Revision 1 PCB partially populated." /></a></td>
					<td class="align-right"><a href="images/temp0/temp0_11.jpg"><img class="photo" src="images/temp0/small_temp0_11.jpg" alt="Revision 1 PCB assembled and testing." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/temp0/temp0_12.png"><img class="photo" src="images/temp0/temp0_12.png" alt="Revision 2 PCB design render - top." /></a></td>
					<td class="align-right"><a href="images/temp0/temp0_13.png"><img class="photo" src="images/temp0/temp0_13.png" alt="Revision 2 PCB design render - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/temp0/temp0_14.jpg"><img class="photo" src="images/temp0/small_temp0_14.jpg" alt="Revision 2 PCB fabricated - top." /></a></td>
					<td class="align-right"><a href="images/temp0/temp0_15.jpg"><img class="photo" src="images/temp0/small_temp0_15.jpg" alt="Revision 2 PCB fabricated - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/temp0/temp0_16.jpg"><img class="photo" src="images/temp0/small_temp0_16.jpg" alt="Revision 2 PCB assembled - bottom." /></a></td>
					<td class="align-right"><a href="images/temp0/temp0_17.jpg"><img class="photo" src="images/temp0/small_temp0_17.jpg" alt="Revision 2 PCB assembled and testing - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/temp0/temp0_18.jpg"><img class="photo" src="images/temp0/small_temp0_18.jpg" alt="Revision 2 PCB assembled - top." /></a></td>
					<td class="align-right"><a href="images/temp0/temp0_19.jpg"><img class="photo" src="images/temp0/small_temp0_19.jpg" alt="Revision 2 PCB assembled and testing - top." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/temp0/temp0_20.jpg"><img class="photo" src="images/temp0/small_temp0_20.jpg" alt="Mounting hardware to enclosure.." /></a></td>
					<td class="align-right"><a href="images/temp0/temp0_21.jpg"><img class="photo" src="images/temp0/small_temp0_21.jpg" alt="Installing PCB into enclosue." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/temp0/temp0_22.jpg"><img class="photo" src="images/temp0/small_temp0_22.jpg" alt="Fully assembled." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
