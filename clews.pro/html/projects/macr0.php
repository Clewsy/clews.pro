<!DOCTYPE html>
<html>
	<head>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/head.html"); ?>
	</head>
	<body>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.html"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">macr0</h2>
			<a href="images/macr0/macr0_15.jpg"><img class="photo align-left" src="images/macr0/small_macr0_15.jpg" alt="The current, final assembled volcon." /></a>
			<p>Macr0 is a 4-button macro pad which identifies as a USB keyboard.</p>
			<p>This project is effectively a handful of proofs of concepts.  I wanted to test a few things I haven't done before with the intention to scale-up for a future project.</p>
			<p>The goals I had in mind for this project included:</p>
			<ol>
				<li><a href="https://en.wikipedia.org/wiki/Human_interface_device">HID</a> compliant USB peripheral using an <a href="https://www.microchip.com/wwwproducts/en/ATmega32U4">ATmega32U4</a> microcontroller.</li>
				<li>Keys will be matrixed (even though the mcu has plenty of spare IO for only 4 buttons).</li>
				<li>Keys will be mechanical Gateron switches - these are pin-compatible <a href="https://www.cherrymx.de/en">Cherry MX</a> clones.</li>
				<li>Keys will all be LED back-lit using a <a href="https://www.onsemi.com/products/power-management/led-drivers/linear-led-drivers/cat4104">CAT4104</a> constant-current LED driver (even though there are only 4 LEDs and they could be easily driven directly by the mcu).</li>
				<li>Back-light illumination will be adjustable.</li>
				<li>Connectivity (and power) will be via a <a href="https://en.wikipedia.org/wiki/USB-C">USC-C</a> connector, configured for USB 2.0.</li>
			</ol>
			<p><a href="https://kicad-pcb.org/">KiCad</a> for PCB design and <a href="https://jlcpcb.com/">JLCPCB</a> for fabrication.  <a href="https://code.visualstudio.com/">VSCode</a> with the <a href="https://platformio.org/">PlatformIO IDE</a> extension for developng the firmware.  <a href="https://gitlab.com/clewsy/macr0/-/tree/master/hardware">Hardware</a> (schematic and PCB design) and <a href="https://gitlab.com/clewsy/macr0/-/tree/master/firmware">firmware</a> are all open and published in a <a href="https://gitlab.com/clewsy/macr0/">Gitlab repository</a>.</p>
			<hr />
			<h2>Revision 1</h2>
			<p>For the most part, everything worked out.  The only goal I didn't quite hit was in regards to the LED backlighting.  I used a CAT4101 LED but I didn't size the LEDs correctly.  Using 4 LEDs total, I used two channels of the CAT4104 with two LEDs per channel.  With VCC at 5V and the CAT4104 requiring 0.4V headroom, that leaves 4.6V per channel or 2.3V per LED.  The LEDs I used are rated at 3.5V.  As a result, I still have backlighting but at a lower brightness and with some instability (flickering).</p>
			<p>I have been using the device as a media controller with the keys configured as play/pause, stop, previous and next.</p>
			<p>The wood enclosure is made from spotted gum and was intended to match another project - <a href="/projects/volcon.php">volcon</a>.  A <a href="images/macr0/macr0_13.jpg">photo</a> in the gallery below shows both devices together.</p> 
			<h2>Revision 2</h2>
			<p>Having learned a few lessons and prooved concepts for a larger-scale project, I decided to revise macr0 since I've found it quite useful.  Changes to be incorporated::</p>
			<ul>
				<li>The smd crystal foorprint was from the included KiCad libray and has huge pads to ease hand-soldering.  They take up too much space and could easily be much smaller and still hand-solderable.</li>
				<li>With only four LEDs I would just drive them directly from the microcontroller instead of with the LED driver.  To have adjustable brightness I would still use a PWM pin and probably some transistors to sink the LED current.  The point of the LED driver was of course just to try it out and determine if it would be suitable for a future project.</li>
				<li>Similarly I would just use a gpio pin configured as an input to directly read each key.  For this 4-key input it would take exactly the same number of gpio pins.  Of course, then I wouldn't have learned how best to read a key matrix - also required for a future project.</li>
				<li>I put a pull-up resistor on the dimmer/brightness button for some reason.  This can be ommitted in favour of an internal pull-up.</li>
			</ul>
			<p> Since this revision won't require the keyscan functionality, I'll record the code here for future reference (i.e. the mentioned larger-scale project) since it will no longer be reflected in the main gitlab branch.</p>
			<div class="code"><p>
				<span class="comment">// Initialise the gpio for scanning rows and columns.</span><br />
				<span class="type">void</span> <b>keyscan_init</b>(<span class="type">void</span>)<br />
				{<br />
				&emsp;&emsp;&emsp;&emsp;<span class="comment">// Set rows as outputs and initialise all as high (disabled).</span><br />
				&emsp;&emsp;&emsp;&emsp;KEYS_DDR |= ((1 &lt;&lt; ROW_1) | (1 &lt;&lt; ROW_2));<br />
				&emsp;&emsp;&emsp;&emsp;KEYS_PORT |= ((1 &lt;&lt; ROW_1) | (1 &lt;&lt; ROW_2));<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;<span class="comment">// Set columns as inputs and enable pull-ups.</span><br />
				&emsp;&emsp;&emsp;&emsp;KEYS_DDR &amp;= ~((1 &lt;&lt; COL_1) | (1 &lt;&lt; COL_2));<br />
				&emsp;&emsp;&emsp;&emsp;KEYS_PORT |= ((1 &lt;&lt; COL_1) | (1 &lt;&lt; COL_2));<br />
				}<br />
			</p></div>

			<div class="code"><p>
				<span class="comment">// Parse the detected key and update the appropriate part of the report struct.</span><br />
				<span class="type">void</span> <b>handle_key</b>(<span class="type">char</span> key, <span class="type">keyscan_report_t</span> *keyscan_report)<br />
				{<br />
				&emsp;&emsp;&emsp;&emsp;<span class="comment">// Media key scan values start at 0xF0, after the last keyboard modifier key scan.</span><br />
				&emsp;&emsp;&emsp;&emsp;<b>if</b>(key > HID_KEYBOARD_SC_RIGHT_GUI)<br />
				&emsp;&emsp;&emsp;&emsp;{<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Convert the media key to a value from 0 to 10.</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;key -= HID_MEDIACONTROLLER_SC_PLAY;<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Shift a bit to the corresponding bit within the media_keys integer.</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;keyscan_report->media_keys |= (1 &lt;&lt; key);<br />
				&emsp;&emsp;&emsp;&emsp;}<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;<span class="comment">// Modifier keys scan values start at 0xE0, after the last keyboard modifier key scan.</span><br />
				&emsp;&emsp;&emsp;&emsp;<b>else if</b>(key > HID_KEYBOARD_SC_APPLICATION)<br />
				&emsp;&emsp;&emsp;&emsp;{<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Convert the media key to a value from 0 to 7.</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;key -= HID_KEYBOARD_SC_LEFT_CONTROL;<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Shift a bit to the corresponding bit within the modifier integer.</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;keyscan_report->modifier |= (1 &lt;&lt; key);<br />
				&emsp;&emsp;&emsp;&emsp;}<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;<span class="comment">// Regular keys scan values range from 0x00 to 0x65.</span><br />
				&emsp;&emsp;&emsp;&emsp;<b>else  if</b>(key > HID_KEYBOARD_SC_RESERVED)<br />
				&emsp;&emsp;&emsp;&emsp;{<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Skip array elements that already have a keyscan value written.</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="type">uint8_t</span> i = 0;<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>while</b>((keyscan_report->keys[i]) && (i &lt; MAX_KEYS)) i++;<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Only register the key if the maximum number of simultaneous keys is not reached.</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>if</b>(i &lt; MAX_KEYS) keyscan_report->keys[i] = key;<br />
				&emsp;&emsp;&emsp;&emsp;}<br />
				}<br />
			</p></div>
			<div class="code"><p>
				<span class="comment">// Row-by-row scan through each column and determine which keys are currently pressed.</span><br />
				<span class="type">void</span> <b>create_keyscan_report</b>(<span class="type">keyscan_report_t</span> *keyscan_report)<br />
				{<br />
				&emsp;&emsp;&emsp;&emsp;<span class="comment">// Start with a blank keyscan report.</span><br />
				&emsp;&emsp;&emsp;&emsp;<b>memset</b>(keyscan_report, 0, <b>sizeof</b>(keyscan_report_t));<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;<span class="comment">// Define the pins to scan through.</span><br />
				&emsp;&emsp;&emsp;&emsp;<span class="type">uint8_t</span> row_array[2] = {ROW_1, ROW_2};<br />
				&emsp;&emsp;&emsp;&emsp;<span class="type">uint8_t</span> col_array[2] = {COL_1, COL_2};<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;<span class="comment">// Loop through for each row.</span><br />
				&emsp;&emsp;&emsp;&emsp;<b>for</b>(<span class="type">uint8_t</span> r = 0; r &lt; <b>sizeof</b>(row_array); r++)<br />
				&emsp;&emsp;&emsp;&emsp;{<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Set low current row (enable check).</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;KEYS_PORT &amp;= ~(1 &lt;&lt; row_array[r]);<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Wait until row is set low before continuing, otherwise column checks can be missed.</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>while</b>(!(~KEYS_PINS & (1 &lt;&lt; row_array[r]))) {}<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Loop through for each column in the current row.</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>for</b>(<span class="type">uint8_t</span> c = 0; c &lt; <b>sizeof</b>(col_array); c++)<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// If the button in the current row and column is pressed, handle it.</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>if</b>(~KEYS_PINS & (1 &lt;&lt; col_array[c]))<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>handle_key</b>(<b>pgm_read_byte</b>(&amp;KEYMAP[r][c]), keyscan_report);<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;}<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;}<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Set high current row (disable check).</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;KEYS_PORT |= (1 &lt;&lt; row_array[r]);<br />
				&emsp;&emsp;&emsp;&emsp;}<br />
				}<br />
			</p></div>

			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="images/macr0/macr0_01.png"><img class="photo" src="images/macr0/macr0_01.png" alt="PCB design - top." /></a></td>
					<td class="align-right"><a href="images/macr0/macr0_02.png"><img class="photo" src="images/macr0/macr0_02.png" alt="PCB design - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0/macr0_03.jpg"><img class="photo" src="images/macr0/small_macr0_03.jpg" alt="PCB fabricated - top." /></a></td>
					<td class="align-right"><a href="images/macr0/macr0_04.jpg"><img class="photo" src="images/macr0/small_macr0_04.jpg" alt="PCB fabricated - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0/macr0_05.jpg"><img class="photo" src="images/macr0/small_macr0_05.jpg" alt="PCB assembled - bottom." /></a></td>
					<td class="align-right"><a href="images/macr0/macr0_06.jpg"><img class="photo" src="images/macr0/small_macr0_06.jpg" alt="PCB assembled - top." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0/macr0_07.jpg"><img class="photo" src="images/macr0/small_macr0_07.jpg" alt="PCB assembled - top with keycaps." /></a></td>
					<td class="align-right"><a href="images/macr0/macr0_08.jpg"><img class="photo" src="images/macr0/small_macr0_08.jpg" alt="Beginning fabrication of frame." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0/macr0_09.jpg"><img class="photo" src="images/macr0/small_macr0_09.jpg" alt="Frame and base fabrication 1." /></a></td>
					<td class="align-right"><a href="images/macr0/macr0_10.jpg"><img class="photo" src="images/macr0/small_macr0_10.jpg" alt="Frame and base fabrication 2." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0/macr0_11.jpg"><img class="photo" src="images/macr0/small_macr0_11.jpg" alt="Frame assembled." /></a></td>
					<td class="align-right"><a href="images/macr0/macr0_12.jpg"><img class="photo" src="images/macr0/small_macr0_12.jpg" alt="Enclosed - bottom view.." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0/macr0_13.jpg"><img class="photo" src="images/macr0/small_macr0_13.jpg" alt="Next to volcon." /></a></td>
					<td class="align-right"><a href="images/macr0/macr0_14.jpg"><img class="photo" src="images/macr0/small_macr0_14.jpg" alt="Assembled, pen for scale." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0/macr0_15.jpg"><img class="photo" src="images/macr0/small_macr0_15.jpg" alt="Assembled, closer view." /></a></td>
					<td class="align-right"><a href="images/macr0/macr0_16.png"><img class="photo" src="images/macr0/macr0_16.png" alt="Schematic for revision 1." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0/macr0_17.png"><img class="photo" src="images/macr0/macr0_17.png" alt="PCB design - top - revision 2." /></a></td>
					<td class="align-right"><a href="images/macr0/macr0_18.png"><img class="photo" src="images/macr0/macr0_18.png" alt="PCB design - bottom - revision 2." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0/macr0_99.png"><img class="photo" src="images/macr0/macr0_99.png" alt="Schematic for revision 2." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
