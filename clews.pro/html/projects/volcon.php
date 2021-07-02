<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.php"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">VolCon</h2>
			<a href="images/volcon/volcon_09.jpg"><img class="photo align-left" src="images/volcon/small_volcon_09.jpg" alt="Assembled volcon Rev 1 after re-working the wooden enclosure." /></a>
			<p>This project began as an experiment when I inexplicably decided to learn how an optical rotary encoder worked (FYI, 2-bit <a href="https://en.wikipedia.org/wiki/Gray_code">Gray code</a>).</p>
			<p>It transformed into a learning experience around USB - specifically the <a href="https://en.wikipedia.org/wiki/USB_human_interface_device_class">HID protocol</a>. Ultimately I ended up with a simple gadget that now sits on my desk and allows me to control the PC volume.</p>
			<p>A salvaged optical encoder was used to detect rotation along with a reclaimed head drum from a VCR which was repurposed as a control knob.  I very much like the smooth bearings combined with the heavy mass that let the drum spin forever.</p>
			<p>Key concepts for the project were:</p>
			<ul>
				<li>The optical encoder parts (sensors and disk) were salvaged from an old track-ball.</li>
				<li>The "knob" was made from the <a href="https://en.wikipedia.org/wiki/File:Kopftrommel_2.jpg">head drum</a> of a <a href="https://en.wikipedia.org/wiki/VHS">VHS</a> <a href="https://en.wikipedia.org/wiki/Videocassette_recorder">VCR</a> (remember those?).  This is the part that spins and is used to adjust volume on my PC.</li>
				<li>The optical disk was fixed to the shaft and optical sensors mounted to some strip-board and attached to the stationary base of the drum.</li>
				<li>The assembly is mounted to a custom PCB with some nylon stand-offs. The PCB became the base of the whole unit.</li>
				<li>I cut some wooden rings to enclose the electronics and the base of the VCR drum.</li>
				<li>The custom PCB was designed in Eagle and etched at home into some single-sided copper-clad board. The circuit was designed around an AVR at90usb162.</li>
				<li>The code is written in C and implements the <a href="http://www.fourwalledcubicle.com/LUFA.php">LUFA</a> library <a href="https://github.com/abcminiuser/lufa/">developed</a> by <a href="http://www.fourwalledcubicle.com/AboutMe.php">Dean Camera</a>.</li>
				<li>The whole unit plugs into a PC via USB and is automatically identified as a HID - no drivers required (tested in Debian Linux and Windows).</li>
				<li>It's a very simple device - rotate clockwise to increase volume, counter-clockwise to decrease.</li>
        		<li>Code and PCB design are available on <a href="https://gitlab.com/clewsy/volcon">gitlab</a>. Here are some reference links:</li>
					<ul>
						<li><a href="https://gitlab.com/clewsy/volcon">VolCon gitlab repo</a> - for code and Eagle design (PCB).</li>
						<li><a href="http://www.fourwalledcubicle.com/LUFA.php">LUFA</a> (lightweight USB Framework for AVRs) main page.</li>
					</ul>
			</ul>
			<hr />
			<h2>Spotted Gum > Stained Pine</h2>
			<p>After some time (about six years!) of having this device in-use on my desk, I finally got sick of the simple (ugly) stained pine wood enclosure.  With some scrap spotted gum and a router (using a Roman ogee and roundover bits) I made a slightly nicer enclosure for volcon.
			<hr />
			<a href="images/volcon/volcon_22.gif"><img class="photo align-right" src="images/volcon/small_volcon_22.gif" alt="Rev 2 - Demo of gray code LED visualisation." /></a>
			<h2>Revision 2</h2>
			<p>After even more time, I decided to do an overhaul.  Revision 2 would use the same head drum, optical encoder sensors and wooden enclosure.  The upgrades from revision 1 include:</p>
			<ul>
				<li>Schematic and PCB layout completely redone but using <a href="https://www.kicad.org/">KiCad</a> instead of Eagle.</li>
				<li>Microcontroller changed from an AT90usb162 AVR to an ATmega32U4.</li>
				<li>Remove the serial Tx/Rx connector (was only used for debugging).</li>
				<li>Remove the reset tact-switch	.</li>
				<li>Use smd components instead of through-hole.</li>
				<li>Connect with a USB type C connector instead of a USB type B.</li>
				<li>Have the PCB fabricated (<a href="https://jlcpcb.com/">JLCPCB</a>) instead of the home-made copper-etch method.</li>
				<li>A couple of LEDs on the bottom of the PCB purely to visualise the Gray code (Rev 1 had LEDs but they only barely shone through etched sections of the PCB).</li>
				<li>Generally improved and cleaner code (still using the LUFA library).</li>
			</ul>
			<hr />
			<h2>Quadrature Encoder / Gray Code</h2>
			<p>The encoder consists of two optical sensor "beams" that are sequentially opened/interrupted by the holes within the encoder disk.  The state of both the sensors can be represented as two bits.</p>
			<p>Movement of the knob is simply determined by a change in the state of either of the two sensors.  I.e. if either of the bits change, the device has rotated.  The spacing of the sensors means only one of the bits will change at a time.  Therefore, the direction of rotation is determined by comparing the current state of the two bits to the previous state of the two bits.</p>
			<table class="simple-table">
				<tr>
					<th scope="col">Clockwise</th>
					<td scope="col">00 -&gt; 10 -&gt; 11 -&gt; 01 -&gt; 00</td>
				</tr>
				<tr>
					<th scope="col">Counter-Clockwise</th>
					<td scope="col">00 -&gt; 01 -&gt; 11 -&gt; 10 -&gt; 00</td>
				</tr>
			</table>
			<br />
			<table class="simple-table">
				<tr>
					<th scope="col">#</th>
					<th scope="col">Previous State</th>
					<th scope="col">Current State</th>
					<th scope="col">Rotation Direction</th>
					<th scope="col">Delta</th>
				</tr>
				<tr>
					<td scope="col">0x0</td>
					<td scope="col">00</td>
					<td scope="col">00</td>
					<td scope="col">No movement.</td>
					<td scope="col">0</td>
				</tr>
				<tr>
					<td scope="col">0x1</td>
					<td scope="col">00</td>
					<td scope="col">01</td>
					<td scope="col">Counter-clockwise.</td>
					<td scope="col">-1</td>
				</tr>
				<tr>
					<td scope="col">0x2</td>
					<td scope="col">00</td>
					<td scope="col">10</td>
					<td scope="col">Clockwise.</td>
					<td scope="col">1</td>
				</tr>
				<tr>
					<td scope="col">0x3</td>
					<td scope="col">00</td>
					<td scope="col">11</td>
					<td scope="col">Not possible (error).</td>
					<td scope="col">0</td>
				</tr>
				<tr>
					<td scope="col">0x4</td>
					<td scope="col">01</td>
					<td scope="col">00</td>
					<td scope="col">Clockwise.</td>
					<td scope="col">1</td>
				</tr>
				<tr>
					<td scope="col">0x5</td>
					<td scope="col">01</td>
					<td scope="col">01</td>
					<td scope="col">No movement.</td>
					<td scope="col">0</td>
				</tr>
				<tr>
					<td scope="col">0x6</td>
					<td scope="col">01</td>
					<td scope="col">10</td>
					<td scope="col">Not possible (error).</td>
					<td scope="col">0</td>
				</tr>
				<tr>
					<td scope="col">0x7</td>
					<td scope="col">01</td>
					<td scope="col">11</td>
					<td scope="col">Counter-clockwise.</td>
					<td scope="col">-1</td>
				</tr>
				<tr>
					<td scope="col">0x8</td>
					<td scope="col">10</td>
					<td scope="col">00</td>
					<td scope="col">Counter-clockwise.</td>
					<td scope="col">-1</td>
				</tr>
				<tr>
					<td scope="col">0x9</td>
					<td scope="col">10</td>
					<td scope="col">01</td>
					<td scope="col">Not possible (error).</td>
					<td scope="col">0</td>
				</tr>
				<tr>
					<td scope="col">0xA</td>
					<td scope="col">10</td>
					<td scope="col">10</td>
					<td scope="col">No movement.</td>
					<td scope="col">0</td>
				</tr>
				<tr>
					<td scope="col">0xB</td>
					<td scope="col">10</td>
					<td scope="col">11</td>
					<td scope="col">Clockwise.</td>
					<td scope="col">1</td>
				</tr>
				<tr>
					<td scope="col">0xC</td>
					<td scope="col">11</td>
					<td scope="col">00</td>
					<td scope="col">Not possible (error).</td>
					<td scope="col">0</td>
				</tr>
				<tr>
					<td scope="col">0xD</td>
					<td scope="col">11</td>
					<td scope="col">01</td>
					<td scope="col">Clockwise.</td>
					<td scope="col">1</td>
				</tr>
				<tr>
					<td scope="col">0xE</td>
					<td scope="col">11</td>
					<td scope="col">10</td>
					<td scope="col">Counter-clockwise.</td>
					<td scope="col">-1</td>
				</tr>
				<tr>
					<td scope="col">0xF</td>
					<td scope="col">11</td>
					<td scope="col">11</td>
					<td scope="col">No movement.</td>
					<td scope="col">0</td>
				</tr>
			</table>
			<p>Note in the table above, if the previous and current states are combined into a single 4-bit value in the order shown, this value is equal to #.  So a 4-bit value (#) can be used to determine the direction of rotation.</p>
			<p>In the code, any change in the state of either optical sensor triggers an interrupt function (see <i>handle_opto()</i> below) which updates the value of #, then uses a look-up table to determine the direction of movement (delta = -1, 0 or 1).</p>
			<p>The look-up table is a one-dimensional array stored in eeprom.  The element number corresponds to '#' and the element content corresponds to 'delta' in accordance with the table above.</p>
			<div class="code"><p>
				<span class="type">void</span> <span class="function">handle_opto</span>(<span class="type">void</span>)<br />
				{	<br />
				&emsp;&emsp;&emsp;	<span class="comment">// a_b is a 4-bit value that represents previous state (bits 3:2) and the current state (bits 1:0) of the encoder.</span><br />
				&emsp;&emsp;&emsp;	<span class="comment">// Static to retain every time this function is called.</span><br />
				&emsp;&emsp;&emsp;	<span class="type">static uint8_t</span> a_b <span class="operator">=</span> <span class="numerical">0b0011</span>;<br />
				<br />
				&emsp;&emsp;&emsp;	<span class="comment">// Encoder lookup table.  Three versions of the table for various levels of "sensitivity".</span><br />
				&emsp;&emsp;&emsp;	<span class="type">static const int8_t</span> enc_table [] PROGMEM <span class="operator">=</span> {<span class="numerical">0</span>,<span class="numerical">-1</span>,<span class="numerical">1</span>,<span class="numerical">0</span>,<span class="numerical">1</span>,<span class="numerical">0</span>,<span class="numerical">0</span>,<span class="numerical">-1</span>,<span class="numerical">-1</span>,<span class="numerical">0</span>,<span class="numerical">0</span>,<span class="numerical">1</span>,<span class="numerical">0</span>,<span class="numerical">1</span>,<span class="numerical">-1</span>,<span class="numerical">0</span>};<span class="comment"> // Use every pulse.</span><br />
				&emsp;&emsp;&emsp;	<span class="comment">//static const int8_t enc_table [] PROGMEM = {0,0,0,0,1,0,0,-1,-1,0,0,1,0,0,0,0}; // Use every second pulse.</span><br />
				&emsp;&emsp;&emsp;	<span class="comment">//static const int8_t enc_table [] PROGMEM = {0,0,0,0,1,0,0,-1,0,0,0,0,0,0,0,0}; &emsp;// Use every fourth pulse.</span><br />
				<br />
				&emsp;&emsp;&emsp;	<span class="comment">// "Remember" previous state of the channels.</span><br />
				&emsp;&emsp;&emsp;	a_b <span class="operator">&lt;&lt;=</span> <span class="numerical">2</span>;<br />
				<br />
				&emsp;&emsp;&emsp;	<span class="comment">// Read in the current state of the channels.</span><br />
				&emsp;&emsp;&emsp;	a_b <span class="operator">|=</span> (OPTO_PINS <span class="operator">&amp;</span> OPTO_PIN_MASK);<br />
				<br />
				&emsp;&emsp;&emsp;	<span class="comment">// Look-up the desired volume delta (-1, 0 or 1) and send to the send_volume(delta) function.</span><br />
				&emsp;&emsp;&emsp;	send_volume(pgm_read_byte(&amp;enc_table[a_b <span class="operator">&amp;</span> <span class="numerical">0x0f</span>]));<br />
				}<br />

			</p></div>
			<hr />
			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="images/volcon/volcon_01.jpg"><img class="photo" src="images/volcon/small_volcon_01.jpg" alt="The original assembly (with stained pine finish)." /></a></td>
					<td class="align-right"><a href="images/volcon/volcon_02.jpg"><img class="photo" src="images/volcon/small_volcon_02.jpg" alt="Partially assembled." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/volcon/volcon_03.jpg"><img class="photo" src="images/volcon/small_volcon_03.jpg" alt="PCB view." /></a></td>
					<td class="align-right"><a href="images/volcon/volcon_04.jpg"><img class="photo" src="images/volcon/small_volcon_04.jpg" alt="Disassembled and dusty." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/volcon/volcon_05.jpg"><img class="photo" src="images/volcon/small_volcon_05.jpg" alt="Planning - block diagram." /></a></td>
					<td class="align-right"><a href="images/volcon/volcon_06.jpg"><img class="photo" src="images/volcon/small_volcon_06.jpg" alt="Planning - sensors." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/volcon/volcon_07.jpg"><img class="photo" src="images/volcon/small_volcon_07.jpg" alt="Assembled without enclosure." /></a></td>
					<td class="align-right"><a href="images/volcon/volcon_08.jpg"><img class="photo" src="images/volcon/small_volcon_08.jpg" alt="The current assembly (with nicer spotted gum finish)." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/volcon/volcon_10.png"><img class="photo" src="images/volcon/small_volcon_10.png" alt="Rev 2 underway - schematic." /></a></td>
					<td class="align-right"><a href="images/volcon/volcon_11.png"><img class="photo" src="images/volcon/small_volcon_11.png" alt="Rev 2 - PCB Layout.." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/volcon/volcon_12.png"><img class="photo" src="images/volcon/small_volcon_12.png" alt="Rev 2 - PCB top render." /></a></td>
					<td class="align-right"><a href="images/volcon/volcon_13.png"><img class="photo" src="images/volcon/small_volcon_13.png" alt="Rev 2 - PCB bottom render." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/volcon/volcon_14.jpg"><img class="photo" src="images/volcon/small_volcon_14.jpg" alt="Rev 2 - PCB fabricated top." /></a></td>
					<td class="align-right"><a href="images/volcon/volcon_15.jpg"><img class="photo" src="images/volcon/small_volcon_15.jpg" alt="Rev 2 - PCB fabricated bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/volcon/volcon_16.jpg"><img class="photo" src="images/volcon/small_volcon_16.jpg" alt="Rev 2 - PCB assembly underway." /></a></td>
					<td class="align-right"><a href="images/volcon/volcon_17.jpg"><img class="photo" src="images/volcon/small_volcon_17.jpg" alt="Rev 2 - Temporary setup for coding/programming." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/volcon/volcon_18.jpg"><img class="photo" src="images/volcon/small_volcon_18.jpg" alt="Rev 2 - Ready to assemble." /></a></td>
					<td class="align-right"><a href="images/volcon/volcon_19.jpg"><img class="photo" src="images/volcon/small_volcon_19.jpg" alt="Rev 2 - Comaprison of PCBs Rev 1 vs Rev 2." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/volcon/volcon_20.jpg"><img class="photo" src="images/volcon/small_volcon_20.jpg" alt="Rev 2 - Rev 1 RIP." /></a></td>
					<td class="align-right"><a href="images/volcon/volcon_21.jpg"><img class="photo" src="images/volcon/small_volcon_21.jpg" alt="Rev 2 - Complete and alongside macr0." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
