<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.php"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">temp0</h2>
			<a href="images/wiggl3r/wiggl3r.jpg"><img class="photo align-left" src="images/wiggl3r/small_wiggl3r.jpg" alt="The beetle dev-board used for wiggl3r." /></a>
			<h3>Summary</h3>
			<p>I've worked for companies and departments that severely lock down their IT infrastructure, even for those of us in technical roles.  A lot of the limitations forced onto the company-issued PCs make sense for the majority, but there are plenty of exceptions and unfortunately bureaucracy prevents flexibilty.  You generally get used to the delays and difficulties this causes, or alternatively you find workarounds.</p>
			<p>This project is a workaround for the frustration of windows PCs automatically locking after a non-configurable duration.</p>
			<p>A small USB device remains connected to an otherwise un-used port.  It identifies as a mouse and every sixty seconds it will move the cursor a single pixel (alternating up/down).  This is unobtrusive and goes un-noticed by the user, but causes PC to "believe" there is a user present and thus prevents auto-locking.</p>
			<p>Further details including the open firmware are available on the <a href="https://github.com/Clewsy/wiggl3r">gitlab repository</a>.</p>
			<br />
			<hr />

			<h3>hardware</h3>
			<a href="images/wiggl3r/wiggl3r.gif"><img class="photo align-right" src="images/wiggl3r/wiggl3r.gif" alt="wiggl3r running.." /></a>
			<p>This firmware has been tested on two <a href="https://www.microchip.com/en-us/product/ATmega32U4">ATmega32U4</a>-based development boards:</p>
			<ul>
				<li>Beetle - a dev-board that uses the <a href="https://docs.arduino.cc/hardware/leonardo">Arduino Leonardo</a> bootloader.</li>
				<li><a href="https://www.pololu.com/product/3101">A-Star 32U4 Micro</a> - a dev board made by <a href="https://www.pololu.com/">Pololu</a></li>
			</ul>
			<p>The beetle is a cheap ATmega32U4 dev-board with card-edge contacts for directly plugging into a USB type-A port.  Because it is firmware-compatible with the Arduino Leonardo, it is safe to assume that this firmware will work with the leonardo itself, as well as other leonardo-compatible boards.</p>
			<p>The Pololu A-Star 32U4 Micro uses a different bootloader, but no changes are required to the code.  Even the on-board LED is connected to the same pin.  The only change needed is to the <a href="https://gitlab.com/clewsy/wiggl3r/-/blob/master/platformio.ini">platformio.ini</a> file if you're using <a href="https://platformio.org/">PlatformIO</a> to program the board.  Un-changed the file is configured for leonardo-compatible boards.  Commenting out the leonardo section and un-commenting the a-star section is all that is required to program the a-star.</p>
			<p>In either case, there is an on-board LED that provides a pulsing heart-beat, and briefly switches to full-brightness when it moves the cursor.</p>
			<hr />

			<h3>firmware</h3>
			<p>Thanks to the <a href="https://www.arduino.cc/">Arduino</a> framework, the firmware was slapped together very quickly.  However, the Arduino IDE was not used.  Instead the firmware was developed in <a href="https://code.visualstudio.com/">VSCode</a> using the <a href="https://platformio.org/">PlatformIO</a> extension.</p>
			<p>A few Arduino functions were used, as well as an Arduino library:</p>
			<ol>
				<li>Arduino digital I/O funcions - <a href="https://www.arduino.cc/reference/en/language/functions/digital-io/pinmode/">pinMode()</a>, <a href="https://www.arduino.cc/reference/en/language/functions/digital-io/digitalwrite/">digitalWrite()</a>.  Used for setting the LED as an output and swithcing it on/off.</li>
				<li>Arduino analog I/O funcion - <a href="https://www.arduino.cc/reference/en/language/functions/analog-io/analogwrite/">analogWrite()</a>.  Used to control a PWM signal for varying the LED brightness.</li>
				<li>Arduino <a href="https://www.arduino.cc/reference/en/language/functions/usb/mouse/">Mouse library</a> - Mouse.begin() and Mouse.move() functions.  Used to emulate a USB mouse.</li>
			</ol>
			<p>Arduino doesn't seem to maintain any timer/counter interrupt libraries/functions.  Third-party options are available, but instead the timers used were configured by setting the corresponding registers directly and writing specific functions and interrupt sub-routines.</p>
				<ol>
				<li>Timer/Counter 1 - configured to trigger an interrupt every second.  This interrupt was used to track seconds elapsed since last moving the mouse cursor.</li>
				<li>Timer/Counter 3 - configured to update the LED brightness to create the pulsing effect.</li>
			</ol>
			<hr />

			<p><a class="align-center" href="images/wiggl3r/wiggl3r.png"><img class="icon" src="images/wiggl3r/small_wiggl3r.png" alt="wiggl3r logo." /></a></p>
		</div>
	</body>
</html>
