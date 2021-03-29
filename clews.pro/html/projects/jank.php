<!DOCTYPE html>
<html>
	<head>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/head.html"); ?>
	</head>
	<body>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.html"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">jank</h2>
			<a href="images/jank/jank_01.jpg"><img class="photo align-left" src="images/jank/small_jank_01.jpg" alt="A description of the image." /></a>
			<p>jank is Just ANother Keypad.  Specifically it's a 21-key usb numeric keypad.  I wanted one for use with my laptop.  Sure it would have cost a lot less to just buy one, but... (insert justification here when you think of one).</p>
			<p>The main features of this keypad include:</p>
			<ul>
				<li><a href="https://en.wikipedia.org/wiki/Human_interface_device">HID</a> compliant USB peripheral using an <a href="https://www.microchip.com/wwwproducts/en/ATmega32U4">ATmega32U4</a> microcontroller with connectivity via a USB type-c connector configured as a USB 2.1 device.</li>
				<li>21 mechanical keys (gateron blues which are pin-compatible clones of <a href="https://www.cherrymx.de/en">Cherry MX</a> blues) with variable brightness white LED backlight on each key.</li>
				<li>In addition to the 17 standard keys of a numerical keypad, there is also a row of four keys across the top of the device which are programmable macros.  (Well, all keys can be programmable macros, but this is how I have configured jank.)</li>
			</ul>
			<hr />

			<h2>Hardware</h2>
			<p>The <a href="images/jank/jank_01.jpg">schematic</a> and PCB layout were designed in KiCAD.  The schematic can be divided into five main areas/components:</p>
			<ol>
				<li><b>The key matrix</b> - 21 gateron mechanical keyswitches connected in a matrix of 4 columns and 6 rows.  The key switches each include a 3mm LED.</li>
				<li><b><a href="https://www.microchip.com/wwwproducts/en/ATmega32U4">ATmega32u4</a> AVR microcontroller</b> - Selected because it has enough GPIO and hardware USB.  I'm also familiar with the device from previous projects and have a few on-hand.  Includes an external 16MHz crystal.</li>
				<li><b><a href="https://www.monolithicpower.com/en/mp3202.html">MP3202</a> LED driver</b> - I've not (successfully) used a boost LED driver before so this was a neat learning experience.  It drives all 21 keyswitch LEDs and is enabled by a PWM signal from the AVR which allows variable LED brightness.</li>
				<li><b>USB type-C Receptacle</b> - Configured to be detected by a host as a USB 2.0 device.  I went with a simple 16-pin through-hole connector that is (barely) hand-solderable.</li>
				<li><b>6-Pin AVR ISP connector</b> - A standard In-System Programming port.</li>
			</ol>
			<p>I ordered board fabrication from <a href="https://jlcpcb.com/">JLCPCB</a> and had boards in-hand within a week.  Sooner than some of the SMD parts which were ordered from a domestic supplier.</p>
			<p>The keyswitches are the "plate-mount" type.  Some years ago I ordered some 108-key keyboard plates laser cut from stainless steel.  I took an angle grinder to one of these and cut off just the end keypad section to use with jank.</p> 
			<p>Two issues during assembly of the PCB:</p>
			<ol>
				<li>My fist step is usually solder in the minimum components to test the programming circuit.  I.e. the AVR, ISP connector and a few passives.  Turns out I had two pins on the AVR shorted and they just so happened to be VCC and GND.  The programmer I was using didn't survive but fortunately I had a spare.  Once the bridge was fixed I used <a href="https://www.nongnu.org/avrdude/">AVRDUDE</a> to test the AVR which was unharmed.</li>
				<li>The single SMD LED mounted on the side opposite the keyswitches (used to indicate numlock status) failed to work.  In my schematic I initially had it backwards.  Fortunately I super-easy fix to reverse so I didn't need to have the boards re-fabricated.</li>
			</ol>
			<p>The "enclosure" is a simple wood (spotted gum) frame and a clear acrylic base plate.</p>
			<hr />

			<h2>Firmware</h2>
			<a href="images/jank/jank_02.jpg"><img class="photo align-right" src="images/jank/small_jank_02.jpg" alt="A description of the second image." /></a>
			<p>For the most part, the firmware did not take long as it is heavily based on a previous project - <a href="/projects/macr0.php">macr0</a>.  The firmware can be separated into three parts:</p>
			<ol>
				<li><b>USB HID Implementation</b> - Achieved by using <a href="http://dean.camera/">Dean Camera's</a> <a href="http://fourwalledcubicle.com/LUFA.php">LUFA</a> <a href="https://github.com/abcminiuser/lufa">Library</a>.</li>
				<li><b>LED Control</b> - Uses a timer configured as a PWM signal output to a pin conncted to the LED controller enable pin.  A tact-switch push-button on a pin-change interrupt is configured to cycle through various LED modes.  The modes are various levels of brightness and a few pulsing effects.  A second internal timer is used to vary the PWM duty cycle to provide the pulse effects.</li>
				<li><b>Key Scanning</b> - By sequentially enebling each row of the key matrix, then reading the state of each column, key scan functions determine which keys are pressed.</li>
			</ol>
			<p>Porting the firmware from <a href="/projects/macr0.php">macr0</a> went relatively smoothy except for one issue that took longer to solve than I will admit.  GPIO pins PF4 and PF5 are configured as inputs for reading in key matrix columns 2 and 3.  Alternate functions for these pins include JTAG TCK (test clock) and JTAG TMS (test mode select) respectively.  I did not intend to use <a href="https://en.wikipedia.org/wiki/JTAG">JTAG</a> so this was irrelevant!  Of course I now know that JTAG is enabled be default (as it can serve as a means of programming the AVR) and GPIO is therefore disabled on PF4 and PF5.  Disabling JTAG by clearing the applicable fuse bit solved all my problems.</p>
			<hr />

			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="images/jank/jank_01.png"><img class="photo" src="images/jank/jank_01.png" alt="PCB design - top." /></a></td>
					<td class="align-right"><a href="images/jank/jank_02.png"><img class="photo" src="images/jank/jank_02.png" alt="PCB design - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_03.jpg"><img class="photo" src="images/jank/small_jank_03.jpg" alt="PCB fabricated - top." /></a></td>
					<td class="align-right"><a href="images/jank/jank_04.jpg"><img class="photo" src="images/jank/small_jank_04.jpg" alt="PCB fabricated - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_05.jpg"><img class="photo" src="images/jank/small_jank_05.jpg" alt="PCB assembled - bottom." /></a></td>
					<td class="align-right"><a href="images/jank/jank_06.jpg"><img class="photo" src="images/jank/small_jank_06.jpg" alt="PCB assembled - top." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_07.jpg"><img class="photo" src="images/jank/small_jank_07.jpg" alt="PCB assembled - top with keycaps." /></a></td>
					<td class="align-right"><a href="images/jank/jank_08.jpg"><img class="photo" src="images/jank/small_jank_08.jpg" alt="Beginning fabrication of frame." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_09.jpg"><img class="photo" src="images/jank/small_jank_09.jpg" alt="Frame and base fabrication 1." /></a></td>
					<td class="align-right"><a href="images/jank/jank_10.jpg"><img class="photo" src="images/jank/small_jank_10.jpg" alt="Frame and base fabrication 2." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_11.jpg"><img class="photo" src="images/jank/small_jank_11.jpg" alt="Frame assembled." /></a></td>
					<td class="align-right"><a href="images/jank/jank_12.jpg"><img class="photo" src="images/jank/small_jank_12.jpg" alt="Enclosed - bottom view.." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_13.jpg"><img class="photo" src="images/jank/small_jank_13.jpg" alt="Next to volcon." /></a></td>
					<td class="align-right"><a href="images/jank/jank_14.jpg"><img class="photo" src="images/jank/small_jank_14.jpg" alt="Assembled, pen for scale." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_15.jpg"><img class="photo" src="images/jank/small_jank_15.jpg" alt="Assembled, closer view." /></a></td>
					<td class="align-right"><a href="images/jank/jank_16.png"><img class="photo" src="images/jank/jank_16.png" alt="Schematic for revision 1." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_17.png"><img class="photo" src="images/jank/jank_17.png" alt="PCB design - top - revision 2." /></a></td>
					<td class="align-right"><a href="images/jank/jank_18.png"><img class="photo" src="images/jank/jank_18.png" alt="PCB design - bottom - revision 2." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
