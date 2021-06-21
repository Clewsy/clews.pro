<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.php"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">grinder_timer_rev2</h2>
			<a href="images/grinder_timer_rev2/grinder_timer_rev2_11.jpg"><img class="photo align-left" src="images/grinder_timer_rev2/small_grinder_timer_rev2_11.jpg" alt="The final timer."></a>
			<p>An upgrade to the original <a href="/projects/grinder_timer.php">grinder_timer</a> - a programmable timer tethered to a Rancilio Rocky coffee grinder.</p>
			<p>Honestly, I use the original every day and it has been working flawlessly for a few years, but the one thing that always bugged me about it was the mushy keypad buttons.  I was looking for a new project to start, so I decided to re-design and build from scratch a version with some nicer tactile buttons and a few other improvements.</p>
			<p>The goals for revision 2 included:</p>
			<ul>
				<li>Hardware improvements:</li>
				<ul>
					<li>Change the keypad buttons from cheap, mushy panel-mount buttons to something with nicer tactile feedback.</li>
					<li>Drive the relay with a transistor instead of directly from an IO pin (original relay required coil current outside of the microcontroller spec).</li>
					<li>Add fly-back diode protection across the relay coil (to prevent voltage spike across the coil when it is de-energised).</li>
					<li>Decrease overall physical size.</li>
					<ul>
						<li>Use a smaller transformer.</li>
						<li>Use a smaller relay.</li>
						<li>Switch to smd components where possible.</li>
						<li>Use a double-sided PCB (fabricated instead of home-made copper-etched).</li>
					</ul>
					<li>Use properly balanced capacitors across the 32.768kHz crystal oscillator (per the datasheet).</li>
					<li>Put the grind button LED on a PWM output (instead of just directly powered).</li>
					<li>Use a different OLED module - SH1106 with I2C control instead of SSD1306 with SPI control.</li>
				</ul>
				<li>Firmware improvements:</li>
				<ul>
					<li>Switch from C to C++.</li>
					<li>New driver for the SH1106 OLED controller.</li>
					<li>Use a timer in PWM mode to create a pulse effect for the grind LED.</li>
					<li>Add the ability to cancel a grind once started by pressing any button.</li>
					<li>Retain (using eeprom storage) the currently selected preset after a power-cycle.</li>
				</ul>
			</ul>
			<p>Apart from the changes listed above, the features for rev2 will be otherwise identical to the original:</p>
			<ul>
				<li>Four programmable presets (A, B, C or D) stored in EEPROM to survive powercycle.</li>
				<li>Left/Right buttons to select preset.</li>
				<li>Up/Down buttons to adjust grind duration for selected preset (0.25s increments up to 60s).</li>
				<li>Grind button to initiate grind and begin countdown timer.</li>
				<li>Oled display (128x64) to show preset menu and countdown timer.</li>
				<li>Aluminium enclosure.</li>
				<li>Single cable (3-core) tether to grinder for power and control.</li>
			</ul>
			<p>Code, schematic and PCB layout are all in the <a href="https://gitlab.com/clewsy/grinder_timer">gitlab repo</a>.  This is the same repo used for the original version.</p>
			<hr />
			<h3>Operation</h3>
			<a href="images/grinder_timer_rev2/grinder_timer_rev2_13.gif"><img class="photo align-right" src="images/grinder_timer_rev2/small_grinder_timer_rev2_13.gif" alt="The final timer in action."></a>
			<p>The user has 4 available timer presets - A, B, C and D.  A preset is selected by scrolling left or right with the d-pad.  To configure a preset, scrolling up or down increases or decreases the value of the timer in increments of 0.25 seconds.  The maximum configurable timer is 60 seconds and the minimum is one second.  A preset value is saved to eeprom whenever it is used or a different preset is selected.</p>
			<p>Once a desired timer is set, pressing the grind button will turn on the grind motor and begin counting down to zero.  Once zero is reached, the grinder is turned off and the timer resets to the value of the preset.  Pressing any button whilst the grinder is running cancels the grind (turns the motor off) and resets the timer.</p>
			<p>After 120 seconds of inactivity, the timer enters a "sleep mode" whereby the OLED is deactivated.  Pressing any button will take the timer out of sleep mode.</p>
			<p>The grind button is illuminated when it is ready to use and off while a grind is underway.  The LED pulses while the timer is in sleep mode.</p>
			<hr />
			<h3>Hardware</h3>
			<p>The schematic and PCB were designed using <a href="https://kicad-pcb.org/">KiCad</a>.  The previous PCB version I fabricated myself using single-sided copper clad-board and copper etchant (the toner-transfer method).  This time I uploaded the gerber files and had the board fabricated by <a href="https://jlcpcb.com/">JLCPCB</a>.</p>
			<p>I found some surface-mount tactile buttons with keycaps for the keypad.  The four direction buttons are identical, the grind button is similar but with a built-in white LED.  This LED was connected to a pin with PWM output capability to enable variable brightness.</p>
			<p>A suitable aluminium enclosure was selected and its internal dimensions dictated the dimensions for the PCB design.</p>
			<hr />
			<h3>Firmware</h3>
			<p>In developing a recent project (<a href="/projects/temp0.php">temp0</a>) I tried out the Arduino platform and programming.  I didn't care much for the Arduino IDE, but I learned how C++ brings some advantages to firmware programming.  So for grinder_timer_rev2 I re-wrote the firmware from scratch and made use of classes.  I opted to directly program the microcontroller as I saw no advantages in using the Arduino bootloader.</p>
			<p>This is my second project with which I have used the <a href="https://platformio.org/">PlatformIO</a> IDE.  It's still great, though it took a bit of work and configuration before I was able to directly program an ATmega328PB with a TinyISP programmer (i.e. with no Arduino or other dev board).</p>
			<p>I like the modularity that using classes seems to facilitate.  Following are the classes I defined for the grinder_timer firmware, and the names I used when declaring them.</p>
			<table class="text-table">
				<tr>
					<td scope="col"><b>Class</b></td>
					<td scope="col"><b>Name</b></td>
					<td scope="col"><b>Description</b></td>
				</tr>
				<tr>
					<td><b>clock</b></td>
					<td>rtc</td>
					<td>Uses a timer/counter and the 32.768kHz crystal oscillator to create a real-time clock for acurate timing.  Configures to trigger an interrupt every 16<sup>th</sup> of a second when running.</td>
				</tr>
				<tr>
					<td><b>i2c</b></td>
					<td>twi</td>
					<td>I<sup>2</sup>C / I2C / IIC / TWI interface.  Used within the sh1106 class for comms from the microcontroller to the OLED controller.</td>
				</tr>
				<tr>
					<td><b>keypad</b></td>
					<td>buttons</td>
					<td>5-button keypad.  4-button d-pad (up, down, left, right) and a "grind" button.</td>
				</tr>
				<tr>
					<td><b>presets</b></td>
					<td>preset</td>
					<td>Variables and eeprom addresses for saving, restoring and referncing the values of four presets, plus the currently selected preset.  Being saved in eeprom means these values are retained through a power-cycle.</td>
				</tr>
				<tr>
					<td><b>pulser</b></td>
					<td>led</td>
					<td>Uses a timer/counter pulsing, and another timer/counter for pwm to set an LED on, off or pulsing.</td>
				</tr>
				<tr>
					<td><b>relay</b></td>
					<td>grinder</td>
					<td>Just an output pin connected to a relay.  In this case, the relay will control the grinder motor.</td>
				</tr>
				<tr>
					<td><b>sh1106</b></td>
					<td>oled</td>
					<td>Drive a 128x64 pixel oled with a sh1106 controller.  Includes functions for (among other things), printing text, displaying bitmaps, vertical scrolling and drawing boxes.</td>
				</tr>
				<tr>
					<td><b>sleeper</b></td>
					<td>sleep_timer</td>
					<td>Uses a timer/counter to trigger an interrupt after a set duration to enter a "sleep" mode.</td>
				</tr>
				<tr>
					<td><b>usart</b></td>
					<td>serial</td>
					<td>Serial interface - really only used for debugging, disabled in the final code.</td>
				</tr>
			</table><br />
			<hr />
			<h3>Issues</h3>
			<p>The biggest problem I encountered was with stability of the OLED.  It would appear to operate as expected, but after random intervals it would hang.  I located the stall point in the I2C function that waits for completion of an I2C transmission.  After experimenting with different clock speeds and power sources, eventually I figured out that the values of the pull-up resistors I had on the SDA and SCL lines were too high.  After replacing these 10k resistors with 3.3k resistors, the OLED became stable and predictable.</p>
			<hr />
			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="images/grinder_timer_rev2/grinder_timer_rev2_01.png"><img class="photo" src="images/grinder_timer_rev2/grinder_timer_rev2_01.png" alt="PCB render top." /></a></td>
					<td class="align-right"><a href="images/grinder_timer_rev2/grinder_timer_rev2_02.png"><img class="photo" src="images/grinder_timer_rev2/grinder_timer_rev2_02.png" alt="PCB render bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/grinder_timer_rev2/grinder_timer_rev2_03.jpg"><img class="photo" src="images/grinder_timer_rev2/small_grinder_timer_rev2_03.jpg" alt="PCB fabricated top." /></a></td>
					<td class="align-right"><a href="images/grinder_timer_rev2/grinder_timer_rev2_04.jpg"><img class="photo" src="images/grinder_timer_rev2/small_grinder_timer_rev2_04.jpg" alt="PCB fabricated bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/grinder_timer_rev2/grinder_timer_rev2_05.jpg"><img class="photo" src="images/grinder_timer_rev2/small_grinder_timer_rev2_05.jpg" alt="PCB assembled top." /></a></td>
					<td class="align-right"><a href="images/grinder_timer_rev2/grinder_timer_rev2_06.jpg"><img class="photo" src="images/grinder_timer_rev2/small_grinder_timer_rev2_06.jpg" alt="PCB assembled bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/grinder_timer_rev2/grinder_timer_rev2_07.jpg"><img class="photo" src="images/grinder_timer_rev2/small_grinder_timer_rev2_07.jpg" alt="PCB assembled top, another angle." /></a></td>
					<td class="align-right"><a href="images/grinder_timer_rev2/grinder_timer_rev2_08.jpg"><img class="photo" src="images/grinder_timer_rev2/small_grinder_timer_rev2_08.jpg" alt="Close shot of the OLED." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/grinder_timer_rev2/grinder_timer_rev2_09.jpg"><img class="photo" src="images/grinder_timer_rev2/small_grinder_timer_rev2_09.jpg" alt="Template for enclosure cut-out." /></a></td>
					<td class="align-right"><a href="images/grinder_timer_rev2/grinder_timer_rev2_10.jpg"><img class="photo" src="images/grinder_timer_rev2/small_grinder_timer_rev2_10.jpg" alt="Enclosure prepared." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/grinder_timer_rev2/grinder_timer_rev2_12.jpg"><img class="photo" src="images/grinder_timer_rev2/small_grinder_timer_rev2_12.jpg" alt="Installed into the enclosure and powered on." /></a></td>
					<td class="align-right"><a href="images/grinder_timer_rev2/grinder_timer_rev2_14.png"><img class="photo" src="images/grinder_timer_rev2/grinder_timer_rev2_14.png" alt="The complete schematic." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
