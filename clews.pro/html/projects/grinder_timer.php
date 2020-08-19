<!DOCTYPE html>
<html>
	<head>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/head.html"); ?>
	</head>
	<body>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.html"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">grinder_timer</h2>
			<a href="images/grinder_timer_01.jpg"><img class="photo align-left" src="images/small_grinder_timer_01.jpg" alt="The final timer."></a>
			<p>This is a programmable timer tethered to a <a href="https://www.ranciliogroup.com/rancilio/rocky/rocky/">Rancilio Rocky</a> coffee grinder.</p>
			<p>The Rocky is a "dumb" grinder and electrically very simple. Basically it's an ac motor with an on/off switch and a momentary push-button to grind.</p>
			<p>This project adds an electronic timer so that consistent, repeatable grind quantities can be produced without having to stand over the grinder.</p>
			<p>Features include:<p>
			<ul>
				<li>Four programmable presets (A, B, C or D) stored in EEPROM to survive powercycle.</li>
				<li>Left/Right buttons to select preset.</li>
				<li>Up/Down buttons to adjust grind duration for selected preset (0.25s increments up to 60s).</li>
				<li>Grind button to initiate grind and begin countdown timer.</li>
				<li>Oled display (128x64) to show preset menu and countdown timer.</li>
				<li>Aluminium enclosure.</li>
				<li>Single cable (3-core) tether to grinder for power and control.</li>
			</ul>
			<p>Code, schematic and PCB layout are all in the <a href="https://gitlab.com/clewsy/grinder_timer">gitlab repo</a>).</p>
			<hr />
			<h3>Tether</h3>
			<p>A three-core cable is required to tether the grinder_timer to the coffee grinder.  The cores are required for power (active, neutral) and to actually switch on the grinder (motor).  The tether cable is connected at both ends via spade connectors.</p>
			<p>Within the grinder, the spade connectors splice into existing spade connections with no modifications required.  The cable is run through the same grommet as the grinder's AC supply cable.  There is no permanent modification to the grinder required.</p>
			<a href="images/grinder_timer_02.jpg"><img class="photo align-right" src="images/small_grinder_timer_02.jpg" alt="Prototyping." /></a>
			<hr />
			<h3>Power</h3>
			<p>The grinder_timer takes power from the coffee grinder.  Since the grinder is a simple AC circuit, the grinder_timer had to include power transformation/rectification/regulation to provide 5V for the other components.  The power sub-circuit uses basic components to provide 5V to the AVR and other components:</p>
			<ul>
				<li>Transformer 240VAC/6VAC x2 @ 0.25A</li>
				<li>Bridge Rectifier</li>
				<li>Filter Capacitors - 470uF, 10uF, 2x 0.1uF</li>
				<li>Voltage regulator LM7805</li>
				<li>Relay 5A/250VAC.</li>
			</ul>
			<hr />
			<h3>Motor Control</h3>
			<p>The grinder motor is switched on/off by grinder_timer via a relay.  Closing the relay simply completes the neutral side of the grinder motor circuit.</p>
			<hr />
			<h3>AVR Circuit</h3>
			<p>The main circuit is centred around an <a href="https://www.microchip.com/wwwproducts/en/ATMEGA328P">ATmega328p</a> AVR micro.</p>
			<p>The circuit includes pin headers for connecting the buttons and a USB/Serial adapter.  Another pin header is for SPI control of the OLED.</p>
			<p>There's a six-pin ISP header for programming.</p>
			<p>I wanted the countdown timer to be reasonably accurate so there is a 32.768kHz crystal connected so as to implement an RTC (real-time clock) with the AVR.</p>
			<hr />
			<h3>OLED Module</h3>
			<p>The display is a 128x64 pixel mon OLED driven by an SSD1306 controlled by the AVR's I2C (TWI) peripheral.</p>
			<p>The module is physically connected via a pin header and ribbon cable to the main circuit board.</p>
			<a href="images/grinder_timer_03.jpg"><img class="photo align-left" src="images/small_grinder_timer_03.jpg" alt="PCB Etched." /></a>
			<hr />
			<h3>Code</h3>
			<p>Early development stages of the code was written exclusively with <a href="https://www.vim.org/">Vim</a> from the terminal (<a href="https://github.com/gnome-terminator/terminator">terminator</a>).  However I had read about <a href="https://atom.io/">Atom</a> and decided to try it out so at some point in development I switched over.</p>
			<p>The code is all interrupt driven.  Pushing any button runs the pin-change interrupt that checks which button and performs the appropriate action.</p>
			<p>The grind button enables the timer/counter 2 peripheral which is configured to use the external 32.768kHz crystal.  This is the timer that actually counts down the desired duration.  This could have been done with an internal oscillator, but I wanted to learn about using the AVR as an RTC for more accurate and consistent timing.</p>
			<p>The AVR's internal eeprom is used so that the stored presets survive a powercycle.</p>
			<p>One trick I missed with the OLED module is the requirement to toggle the reset line as part of a start-up sequence at boot (datasheet included on gitlab repo).  I simply tied the reset line to the AVR's reset line.</p>
			<p>I eventually found this was causing issues at power-up because the oled reset is supposed to be toggled a minimum duration after the oled power stabilises.  Ideally, this would be done with code using one of the AVR's GPIO pins tied to the OLED's reset pin.</p>
			<p>The workaround I figured out was a capacitor across the OLED's reset pin with enough capacitance so that on power-up there is effectively a delay setting the reset line high while the capacitor charges up.  This is a bit of a bodge but seems to work and has the benefit of not requiring an additional GPIO pin.</p>
			<p>However, if I need to iterate, the next circuit design would probably include AVR control of the OLED's reset line.</p>
			<p>I designed a seven-segment-style font for the timer display.  This design was done using a spreadsheet which is included in the reference material on the repo.</p>
			<p>Each digit is 24x48 pixels.</p>
			<a href="images/grinder_timer_06.jpg"><img class="photo align-right" src="images/small_grinder_timer_06.jpg" alt="Re-programming." /></a>
			<hr />
			<h3>Circuit Design</h3>
			<p>The schematic and PCB layout were designed with <a href="https://kicad-pcb.org/">KiCad</a>.  Prior to this project my only circuit CAD experience was with eagle.  I used this project to familiarise myself with the open source alternative.</p>
			<p>All the KiCad project files are included in the gitlab repo.</p>
			<p>The PCB layout outer-dimensions was driven by the size of an aluminium enclosure I wanted to use.  This enclosure was selected based on the most cumbersome component - the PCB mounted transformer.</p>
			<hr />
			<h3>PCB Fabrication</h3>
			<p>I designed the PCB to be fabricated using the toner-transfer method a single-sided copper-clad board.</p>
			<p>After etching, I cut the board to size, drilled the holes and started populating.</p>
			<hr />
			<h3>Enclosure</h3>
			<p>The PCB was mounted within an aluminium enclosure.  The lid was cut to mount the OLED and the five buttons, all of which connected to the PCB via headers.</p>
			<p>The tether cable connects to the PCB via spade connectors and runs through a hole (with grommet) through the enclosure.  The other end of the tether cable runs through the existing power-cord grommet on the grinder and ties into the three connection points via 3-way spade terminal splices.</p>
			<hr />
			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="images/grinder_timer_04.jpg"><img class="photo" src="images/small_grinder_timer_04.jpg" alt="Populating PCB." /></a></td>
					<td class="align-right"><a href="images/grinder_timer_05.jpg"><img class="photo" src="images/small_grinder_timer_05.jpg" alt="PCB Assembled." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/grinder_timer_07.jpg"><img class="photo" src="images/small_grinder_timer_07.jpg" alt="Assembly Started." /></a></td>
					<td class="align-right"><a href="images/grinder_timer_08.jpg"><img class="photo" src="images/small_grinder_timer_08.jpg" alt="Mostly Assembled." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/grinder_timer_09.jpg"><img class="photo" src="images/small_grinder_timer_09.jpg" alt="Connecting Tether." /></a></td>
					<td class="align-right"><a href="images/grinder_timer_10.jpg"><img class="photo" src="images/small_grinder_timer_10.jpg" alt="Complete and Functional." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/grinder_timer_11.png"><img class="photo" src="images/grinder_timer_11.png" alt="The Complete Schematic." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
