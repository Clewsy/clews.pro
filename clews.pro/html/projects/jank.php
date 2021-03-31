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
			<a href="images/jank/jank_14.jpg"><img class="photo align-left" src="images/jank/small_jank_14.jpg" alt="Jank without the enclosure." /></a>
			<p>jank is <b>j</b>ust <b>an</b>other <b>k</b>eypad.  Specifically it's a 21-key usb numeric keypad.  I wanted one for use with my laptop.  Sure it would have cost a lot less to just buy one, but... (<i>insert justification here when you think of one</i>).  jank is open-source with all the code and CAD files available at <a href="https://gitlab.com/clewsy/jank/">GitLab</a>.</p>
			<p>The main features of this keypad include:</p>
			<ul>
				<li><a href="https://en.wikipedia.org/wiki/Human_interface_device">HID</a> compliant USB peripheral using an <a href="https://www.microchip.com/wwwproducts/en/ATmega32U4">ATmega32U4</a> microcontroller with connectivity via a USB type-c connector configured as a USB 2 device.  Power is also derived from the USB port.</li>
				<li>21 mechanical keys (gateron blues which are pin-compatible clones of <a href="https://www.cherrymx.de/en">Cherry MX</a> blues) with variable brightness white LED backlight on each key.</li>
				<li>In addition to the 17 standard keys of a numerical keypad, there is also a row of four keys across the top of the device which are programmable macros.  (Well, all keys can be programmable macros, but this is how I have configured jank.)</li>
			</ul>
			<p>I previously completed a simpler macro pad project (<a href="/projects/macr0.php">macr0</a>) which served as an experiment to prepare for this project.  Effectively macr0 was a trial so that I could get my head around a few concepts (<a href="https://en.wikipedia.org/wiki/Keyboard_matrix_circuit">key matrixing</a>, LED boost controllers, configurable macros with the HID protocol).  As such, development for jank went a lot faster since a lot of the <a href="https://gitlab.com/clewsy/macr0/-/tree/master/firmware">code from macr0</a> worked with minimal changes.</p>
			<hr />

			<h2><a href="https://gitlab.com/clewsy/jank/-/tree/master/hardware">Hardware</a></h2>
			<a href="images/jank/jank_09.jpg"><img class="photo align-right" src="images/jank/small_jank_09.jpg" alt="Hardware assembly underway." /></a>
			<p>The <a href="images/jank/jank_01.jpg">schematic</a> and PCB layout were designed in KiCAD.  The schematic can be divided into five main areas/components:</p>
			<ol>
				<li><b>The key matrix</b> - 21 gateron mechanical keyswitches connected in a matrix of 4 columns and 6 rows.  The key switches each include a 3mm LED.</li>
				<li><b><a href="https://www.microchip.com/wwwproducts/en/ATmega32U4">ATmega32u4</a> AVR microcontroller</b> - Selected because it has enough GPIO and hardware USB.  I'm also familiar with the device from previous projects and have a few on-hand.  Includes an external 16MHz crystal.</li>
				<li><b><a href="https://www.monolithicpower.com/en/mp3202.html">MP3202</a> LED driver</b> - I've not (successfully) used a boost LED driver before, so this was a neat learning experience.  It drives all 21 keyswitch LEDs and is enabled by a PWM signal from the AVR which allows variable LED brightness.</li>
				<li><b>USB type-C Receptacle</b> - Configured to be detected by a host as a USB 2.0 device.  I went with a simple 16-pin through-hole connector that is (barely) hand-solderable.</li>
				<li><b>6-Pin AVR ISP connector</b> - A standard In-System Programming port.</li>
			</ol>
			<p>I ordered board fabrication from <a href="https://jlcpcb.com/">JLCPCB</a> and had boards in-hand within a week.  Sooner than some of the SMD parts which were ordered from a domestic supplier.</p>
			<p>The keyswitches are the "plate-mount" type.  Some years ago I ordered some 108-key keyboard plates laser cut from stainless steel.  I took an angle grinder to one of these and cut off just the end keypad section to use with jank.</p> 
			<p>Two issues during assembly of the PCB:</p>
			<ol>
				<li>My fist step is usually solder in the minimum components to test the programming circuit.  I.e. the AVR, ISP connector and a few passives.  Turns out I had two pins on the AVR shorted and they just so happened to be VCC and GND.  The programmer I was using didn't survive but fortunately I had a spare.  Once the bridge was fixed I used <a href="https://www.nongnu.org/avrdude/">AVRDUDE</a> to test the AVR which was unharmed.</li>
				<li>The single SMD LED mounted on the side opposite the keyswitches (used to indicate num lock status) failed to work.  In my schematic I initially had it backwards.  Fortunately this was a super-easy fix (reverse the LED) so I didn't need to have the board re-fabricated.</li>
			</ol>
			<p>The "enclosure" is a simple wood (spotted gum) frame and a clear acrylic base plate.  There is a small hole in the base to provide access to the tact switch that cycles the LED backlighting through various brightness levels and pulse effects.</p>
			<hr />

			<h2><a href="https://gitlab.com/clewsy/jank/-/tree/master/firmware">Firmware</a></h2>
			<p>For the most part, the firmware did not take long as it is heavily based on a previous project - <a href="/projects/macr0.php">macr0</a>.  The firmware can be separated into three parts:</p>
			<ol>
				<li><b>USB HID Implementation</b> - Achieved by using <a href="http://dean.camera/">Dean Camera's</a> <a href="http://fourwalledcubicle.com/LUFA.php">LUFA</a> <a href="https://github.com/abcminiuser/lufa">Library</a>.</li>
				<li><b>LED Control</b> - Uses a timer configured as a PWM signal output on a pin connected to the LED controller enable pin.  A tact-switch push-button on a pin-change interrupt is configured to cycle through various LED modes.  The modes include various levels of brightness and a few pulsing effects.  A second internal timer is used to vary the PWM duty cycle to provide the pulse effects.</li>
				<li><b>Key Scanning</b> - By sequentially enabling each row of the key matrix, then reading the state of each column, key scan functions determine which keys are pressed.  The table below details the keyswitch layout and the corresponding row and column as connected to the microcontroller.</li>
			</ol>
			<table class="simple-table">
				<tr>
					<td>ROW0<br />COL0</td><td>ROW0<br />COL1</td><td>ROW0<br />COL2</td><td>ROW0<br />COL3</td>
				</tr>
				<tr>
					<td colspan="4"><br /></td>
				</tr>
				<tr>
					<td>ROW1<br />COL0</td><td>ROW1<br />COL1</td><td>ROW1<br />COL2</td><td>ROW1<br />COL3</td>
				</tr>
				<tr>
					<td>ROW2<br />COL0</td><td>ROW2<br />COL1</td><td>ROW2<br />COL2</td><td valign="top" rowspan="2">ROW2<br />COL3</td>
				</tr>
				<tr>
					<td>ROW3<br />COL0</td><td>ROW3<br />COL1</td><td>ROW3<br />COL2</td>
				</tr>
				<tr>
					<td>ROW4<br />COL0</td><td>ROW4<br />COL1</td><td>ROW4<br />COL2</td><td valign="top" rowspan="2">ROW4<br />COL3</td>
				</tr>
				<tr>
					<td colspan="2"><div style="text-align:left">ROW5<br />COL0</td><td>ROW5<br />COL2</div></td>
				</tr>
			</table>
			<p>Porting the firmware from <a href="/projects/macr0.php">macr0</a> went relatively smoothy except for one issue that took longer to solve than I will admit.  GPIO pins PF4 and PF5 are configured as inputs for reading in key matrix columns 2 and 3.  Alternate functions for PF4 and PF5 include JTAG TCK (test clock) and JTAG TMS (test mode select) respectively.  I did not intend to use <a href="https://en.wikipedia.org/wiki/JTAG">JTAG</a> so this was irrelevant!  Of course I now know that JTAG is enabled be default (as it can serve as an interface for programming the AVR) and GPIO is therefore disabled on PF4 and PF5.  Disabling JTAG by clearing the applicable fuse bit solved all my problems.</p>
			<hr />

			<h2>Configuration</h2>
<p>Any key can be configured as a any regular keystroke (including media control keys) or a macro (series of sequential keystrokes).  The code as listed on GitLab will have the top row configured as four macro keys while the remaining 17 keys are configured as a traditional numeric keypad.</p>
<p>Only the <i>keymap.c</i> file needs to be modified in order to configure the action for each key.</p>

<div class="code"><p>
<span class="compiler">#include "keymap.h"</span><br />
<br />
<span class="comment">// Define the physical row and column pins on the microcontroller to be scanned for key presses.</span><br />
<span class="type">const uint8_t</span> key_row_array[] <span class="operator">=</span> {ROW1, ROW2, ROW3, ROW4, ROW5};<br />
<span class="type">const uint8_t</span> key_col_array[] <span class="operator">=</span> {COL0, COL1, COL2, COL3};<br />
<span class="type">const uint8_t</span> macro_row_array[] <span class="operator">=</span> {ROW0};<br />
<span class="type">const uint8_t</span> macro_col_array[] <span class="operator">=</span> {COL0, COL1, COL2, COL3};<br />
<br />
<span class="comment">// Number pad key definitions.</span><br />
<span class="comment">// KEY_XY where X:Row Number, Y:Column Number.</span><br />
<span class="compiler">#define KEY_10 HID_KEYBOARD_SC_NUM_LOCK</span><br />
<span class="compiler">#define KEY_11 HID_KEYBOARD_SC_KEYPAD_SLASH</span><br />
<span class="compiler">#define KEY_12 HID_KEYBOARD_SC_KEYPAD_ASTERISK</span><br />
<span class="compiler">#define KEY_13 HID_KEYBOARD_SC_KEYPAD_MINUS</span><br />
<span class="compiler">#define KEY_20 HID_KEYBOARD_SC_KEYPAD_7_AND_HOME</span><br />
<span class="compiler">#define KEY_21 HID_KEYBOARD_SC_KEYPAD_8_AND_UP_ARROW</span><br />
<span class="compiler">#define KEY_22 HID_KEYBOARD_SC_KEYPAD_9_AND_PAGE_UP</span><br />
<span class="compiler">#define KEY_23 HID_KEYBOARD_SC_KEYPAD_PLUS</span><br />
<span class="compiler">#define KEY_30 HID_KEYBOARD_SC_KEYPAD_4_AND_LEFT_ARROW</span><br />
<span class="compiler">#define KEY_31 HID_KEYBOARD_SC_KEYPAD_5</span><br />
<span class="compiler">#define KEY_32 HID_KEYBOARD_SC_KEYPAD_6_AND_RIGHT_ARROW</span><br />
<span class="compiler">#define KEY_33 0x00</span>&emsp;&emsp;&emsp; <span class="comment">// No key here.</span><br />
<span class="compiler">#define KEY_40 HID_KEYBOARD_SC_KEYPAD_1_AND_END</span><br />
<span class="compiler">#define KEY_41 HID_KEYBOARD_SC_KEYPAD_2_AND_DOWN_ARROW</span><br />
<span class="compiler">#define KEY_42 HID_KEYBOARD_SC_KEYPAD_3_AND_PAGE_DOWN</span><br />
<span class="compiler">#define KEY_43 HID_KEYBOARD_SC_KEYPAD_ENTER</span><br />
<span class="compiler">#define KEY_50 HID_KEYBOARD_SC_KEYPAD_0_AND_INSERT</span><br />
<span class="compiler">#define KEY_51 0x00</span>&emsp;&emsp;&emsp; <span class="comment">// No key here.</span><br />
<span class="compiler">#define KEY_52 HID_KEYBOARD_SC_KEYPAD_DOT_AND_DELETE</span><br />
<span class="compiler">#define KEY_53 0x00</span>&emsp;&emsp;&emsp; <span class="comment">// No key here.</span><br />


<br />

<span class="comment">// The key map array - for regular key strokes including media control keys.</span><br />
<span class="type">const char</span> KEYMAP[NUM_KEY_ROWS][NUM_KEY_COLS] PROGMEM <span class="operator">=</span> {<br />
&emsp;&emsp;&emsp;	<span class="comment">//Col 0 &emsp;&emsp;&emsp;	Col 1 &emsp; &emsp;&emsp;	Col 2 &emsp; &emsp;&emsp;	Col 3</span><br />
&emsp;&emsp;&emsp;	{KEY_10,&emsp;&emsp;&emsp;	KEY_11,&emsp;&emsp;&emsp;	KEY_12,&emsp;&emsp;&emsp;	KEY_13},&emsp;&emsp;&emsp;	<span class="comment">// Row 1</span><br />
&emsp;&emsp;&emsp;	{KEY_20,&emsp;&emsp;&emsp;	KEY_21,&emsp;&emsp;&emsp;	KEY_22,&emsp;&emsp;&emsp;	KEY_23},&emsp;&emsp;&emsp;	<span class="comment">// Row 2</span><br />
&emsp;&emsp;&emsp;	{KEY_30,&emsp;&emsp;&emsp;	KEY_31,&emsp;&emsp;&emsp;	KEY_32,&emsp;&emsp;&emsp;	KEY_33},&emsp;&emsp;&emsp;	<span class="comment">// Row 3</span><br />
&emsp;&emsp;&emsp;	{KEY_40,&emsp;&emsp;&emsp;	KEY_41,&emsp;&emsp;&emsp;	KEY_42,&emsp;&emsp;&emsp;	KEY_43},&emsp;&emsp;&emsp;	<span class="comment">// Row 4</span><br />
&emsp;&emsp;&emsp;	{KEY_50,&emsp;&emsp;&emsp;	KEY_51,&emsp;&emsp;&emsp;	KEY_52,&emsp;&emsp;&emsp;	KEY_53}	&emsp;&emsp;&emsp;	<span class="comment">// Row 5</span><br />
};<br />
<br />
<span class="comment">// Macro definitions.  Currently just simple text strings can be used as macros.</span><br />
<span class="compiler">#define MACRO_0 "TEST_0\n"</span><br />
<span class="compiler">#define MACRO_1 "The quick brown fox "</span><br />
<span class="compiler">#define MACRO_2 "jumped over the lazy dog.\n"</span><br />
<span class="compiler">#define MACRO_3 "`1234567890-=~!@#$%^&*()_+qwertyuiop[]\\QWERTYUIOP{}|asdfghjkl;'ASDFGHJKL:\"zxcvbnm,./ZXCVBNM<>?\n"</span><br />
<br />
<span class="comment">// The macro map array - for key strokes that are mapped as macros.</span><br />
<span class="type">const char</span> MACROMAP[NUM_MACRO_ROWS][NUM_MACRO_COLS][MAX_MACRO_CHARS] PROGMEM <span class="operator">=</span> {<br />
&emsp;&emsp;&emsp;	<span class="comment">//Col 0 &emsp; &emsp;&emsp;	Col 1 &emsp; &emsp; &emsp;	Col 2 &emsp; &emsp; &emsp;	Col 3</span><br />
&emsp;&emsp;&emsp;	{MACRO_0,&emsp;&emsp;&emsp;	MACRO_1,&emsp;&emsp;&emsp;	MACRO_2,&emsp;&emsp;&emsp;	MACRO_3}&emsp;&emsp;&emsp;	<span class="comment">// Row 0</span><br />
};<br />
</p></div>





			<hr />

			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="images/jank/jank_01.png"><img class="photo" src="images/jank/jank_01.png" alt="Schematic." /></a></td>
					<td class="align-right"><a href="images/jank/jank_02.png"><img class="photo" src="images/jank/jank_02.png" alt="PCB layout." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_03.png"><img class="photo" src="images/jank/jank_03.png" alt="PCB layout with infill - top." /></a></td>
					<td class="align-right"><a href="images/jank/jank_04.png"><img class="photo" src="images/jank/jank_04.png" alt="PCB layout with infill - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_05.png"><img class="photo" src="images/jank/jank_05.png" alt="PCB 3D view - top." /></a></td>
					<td class="align-right"><a href="images/jank/jank_06.png"><img class="photo" src="images/jank/jank_06.png" alt="PCB 3D view - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_07.jpg"><img class="photo" src="images/jank/small_jank_07.jpg" alt="PCB fabricated - top." /></a></td>
					<td class="align-right"><a href="images/jank/jank_08.jpg"><img class="photo" src="images/jank/small_jank_08.jpg" alt="PCB fabricated - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_09.jpg"><img class="photo" src="images/jank/small_jank_09.jpg" alt="PCB with stainless steel plate and keyswitches." /></a></td>
					<td class="align-right"><a href="images/jank/jank_10.jpg"><img class="photo" src="images/jank/small_jank_10.jpg" alt="PCB and keyswitches fit to stainless steel plate." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_11.jpg"><img class="photo" src="images/jank/small_jank_11.jpg" alt="PCB assembled with ISP connected." /></a></td>
					<td class="align-right"><a href="images/jank/jank_12.jpg"><img class="photo" src="images/jank/small_jank_12.jpg" alt="PCB assembled and USB connected." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_13.jpg"><img class="photo" src="images/jank/small_jank_13.jpg" alt="jank running - top." /></a></td>
					<td class="align-right"><a href="images/jank/jank_14.jpg"><img class="photo" src="images/jank/small_jank_14.jpg" alt="jank running - angled." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_15.jpg"><img class="photo" src="images/jank/small_jank_15.jpg" alt="XXX." /></a></td>
					<td class="align-right"><a href="images/jank/jank_16.png"><img class="photo" src="images/jank/jank_16.png" alt="XXX." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_17.png"><img class="photo" src="images/jank/jank_17.png" alt="XXX." /></a></td>
					<td class="align-right"><a href="images/jank/jank_18.png"><img class="photo" src="images/jank/jank_18.png" alt="XXX." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
