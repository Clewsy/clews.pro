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
			<p>The keyswitches are the "plate-mount" type.  Some years ago I ordered some 108-key keyboard plates laser cut from stainless steel.  For my first test assembly I took an angle grinder to one of these and cut off just the end keypad section to use with jank.  The assembled unit worked well and I eventually made a simple wood enclosure for it which hid the rough-cut edge.  I assembled a second unit (minimum order quantity meant I ended up with five PCBs) but this time I ordered a laser-cut stainless steel plate for a nicer finish.  To generate the CAD file for the plate, I took the following steps:</p>
			<ol>
				<li>Start with a keyboard layout generated at <a href="http://www.keyboard-layout-editor.com/#/">keyboard-layout-editor.com</a>.</li>
				<li>Copy the text from the "Raw Data" tab.</li>
				<li>Paste the "Raw data" from the layout editor into the "Plate Layout" field at <a href="http://builder.swillkb.com/">builder.swillkb.com</a>.</li>
				<li>Select "MX {_t:3}" as the "Switch Type").</li>
				<li>Set the "Stabilizer Type".  I went with "Cherry + Costar {_s:1}".</li>
				<li>Turn on the "Edge Padding" option and set all edges to "1.9mm" (this will add padding so that the overall plate dimensions match the PCB dimensions).</li>
				<li>Click "Draw My CAD!!!", check the outline and dimensions, then download the *.dxf CAD file.</li>
				<li>Upload the CAD file to a laser cutting service to order the plate.  I used <a href="https://www.laserboost.com/keyboards-about">LaserBoost</a>.</li>
			</ol>
			<p>Following is the raw data for the layout I created.  The actual text on the keys isn't important for creating the plate CAD, but I included it anyway.</p>
			<div class="code"><p>
			[<span class="string">"M1"</span>,<span class="string">"M2"</span>,<span class="string">"M3"</span>,<span class="string">"M4"</span>],<br />
			[{y:<span class="numerical">0.5</span>},<span class="string">"Num Lock"</span>,<span class="string">"/"</span>,<span class="string">"*"</span>,<span class="string">"-"</span>],<br />
			[<span class="string">"7<span class="compiler">\n</span>Home"</span>,<span class="string">"8<span class="compiler">\n</span>↑"</span>,<span class="string">"9<span class="compiler">\n</span>PgUp"</span>,{h:<span class="numerical">2</span>},<span class="string">"+"</span>],<br />
			[<span class="string">"4<span class="compiler">\n</span>←"</span>,<span class="string">"5"</span>,<span class="string">"6<span class="compiler">\n</span>→"</span>],<br />
			[<span class="string">"1<span class="compiler">\n</span>End"</span>,<span class="string">"2<span class="compiler">\n</span>↓"</span>,<span class="string">"3<span class="compiler">\n</span>PgDn"</span>,{h:<span class="numerical">2</span>},<span class="string">"Enter"</span>],<br />
			[{w:<span class="numerical">2</span>},<span class="string">"0<span class="compiler">\n</span>Ins"</span>,<span class="string">".<span class="compiler">\n</span>Del"</span>]<br />
			</p></div>
			<p>If you want to skip steps 01-07 above (generating the *.dxf CAD file), I have uploaded the file I generated to the GitLab repo (<a href="XXXXXX">jank_plate_cad.dxf</a>).</p>
 
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

			<a href="images/jank/jank_20.jpg"><img class="photo align-right" src="images/jank/small_jank_20.jpg" alt="Testing." /></a>
			<h2>Configuration</h2>
			<p>Any key can be configured as a regular keystroke (including media control keys) or a macro (a series of sequential/combined keystrokes).  The code as listed on GitLab will cause the top row of keyswitches to be configured as four macro keys while the remaining 17 keys are configured as a traditional numeric keypad, including standard Num Lock operation.</p>
			<p>Only the <i>keymap.c</i> source file needs to be modified in order to configure the action for each key.  The <i>keymap.h</i> header file is a useful reference, particularly for finding all the defined keyboard scan-codes.</p>
			<p>So a keystroke configured as a macro actually triggers a series of one or more single "macros".  The series of macros are defined within a multi-dimensional array <i>MACROMAP[number_of_rows][number_of_columns][number_of_macro_t]</i>.  One such macro is a custom structure type named <i>macro_t</i>.  The type definition (typedef) for the structure is listed within the <i>keymap.h</i> header file, and is also duplicated below for reference:</p>
			<br />
			<div class="code"><p>
			<span class="type">typedef struct</span> {<br />
			&emsp;&emsp;&emsp;	<span class="type">uint8_t</span> m_action; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <span class="comment">// m_action defines the kind of macro action (string, keys or delay).</span><br />
			&emsp;&emsp;&emsp;	<span class="type">char</span> m_array[<span class="compiler">MAX_MACRO_CHARS</span>]; <span class="comment">// m_array is interpreted differently depending on the value of m_action.</span><br />
			} macro_t;<br />
			</p></div>
			<p>The array part of the macro_t structure (<i>m_array</i>) is interpreted in different ways by the <i>SendMacroReports()</i> function, depending on the value of the interger part of the structure (<i>m_action</i>).</p>
			<table class="simple-table">
				<tr>
					<th>m_action</th><th>m_array</th>
				</tr>
				<tr>
					<td>M_NULL</td><td style="text-align:left">No macro.  The m_array is ignored.</td>
				</tr>
				<tr>
					<td>M_STRING</td><td style="text-align:left">"Type" a string of characters.  The m_array is interpreted as a character array.  Each character is converted to the required keyboard scancode and sequentially sent as a series of keyboard reports.</td>
				</tr>
				<tr>
					<td>M_KEYS</td><td style="text-align:left">A combination of keystrokes (including modifiers).  Each element of m_array is interpreted as a keyboard scancode.  All scancodes are sent simultaneously in a single keyboard report.</td>
				</tr>
				<tr>
					<td>M_WAIT</td><td style="text-align:left">No keystrokes.  Each element of the m_array is interpreted as an integer.  The value of each integer represents the number of seconds to "wait".  Such a delay can be useful if a previous macro keystroke needs time for the corresponding command to execute.</td>
				</tr>
			</table>
			<br />
			<div class="code"><p>
			<span class="compiler">#include "keymap.h"</span><br />
			<br />
			<span class="comment">// Define the physical row and column pins on the microcontroller to be scanned for key presses.</span><br />
			<span class="type">const uint8_t</span> key_row_array[] <span class="operator">=</span> {<span class="compiler">ROW1</span>, <span class="compiler">ROW2</span>, <span class="compiler">ROW3</span>, <span class="compiler">ROW4</span>, <span class="compiler">ROW5</span>};<br />
			<span class="type">const uint8_t</span> key_col_array[] <span class="operator">=</span> {<span class="compiler">COL0</span>, <span class="compiler">COL1</span>, <span class="compiler">COL2</span>, <span class="compiler">COL3</span>};<br />
			<span class="type">const uint8_t</span> macro_row_array[] <span class="operator">=</span> {<span class="compiler">ROW0</span>};<br />
			<span class="type">const uint8_t</span> macro_col_array[] <span class="operator">=</span> {<span class="compiler">COL0</span>, <span class="compiler">COL1</span>, <span class="compiler">COL2</span>, <span class="compiler">COL3</span>};<br />
			<br />
			<span class="comment">// Number pad key definitions.</span><br />
			<span class="comment">// KEY_X_Y where X:Row Number, Y:Column Number.</span><br />
			<span class="compiler">#define KEY_1_0 HID_KEYBOARD_SC_NUM_LOCK</span><br />
			<span class="compiler">#define KEY_1_1 HID_KEYBOARD_SC_KEYPAD_SLASH</span><br />
			<span class="compiler">#define KEY_1_2 HID_KEYBOARD_SC_KEYPAD_ASTERISK</span><br />
			<span class="compiler">#define KEY_1_3 HID_KEYBOARD_SC_KEYPAD_MINUS</span><br />
			<span class="compiler">#define KEY_2_0 HID_KEYBOARD_SC_KEYPAD_7_AND_HOME</span><br />
			<span class="compiler">#define KEY_2_1 HID_KEYBOARD_SC_KEYPAD_8_AND_UP_ARROW</span><br />
			<span class="compiler">#define KEY_2_2 HID_KEYBOARD_SC_KEYPAD_9_AND_PAGE_UP</span><br />
			<span class="compiler">#define KEY_2_3 HID_KEYBOARD_SC_KEYPAD_PLUS</span><br />
			<span class="compiler">#define KEY_3_0 HID_KEYBOARD_SC_KEYPAD_4_AND_LEFT_ARROW</span><br />
			<span class="compiler">#define KEY_3_1 HID_KEYBOARD_SC_KEYPAD_5</span><br />
			<span class="compiler">#define KEY_3_2 HID_KEYBOARD_SC_KEYPAD_6_AND_RIGHT_ARROW</span><br />
			<span class="compiler">#define KEY_3_3</span> <span class="numerical">0x00</span>&emsp;&emsp;&emsp; <span class="comment">// No key here.</span><br />
			<span class="compiler">#define KEY_4_0 HID_KEYBOARD_SC_KEYPAD_1_AND_END</span><br />
			<span class="compiler">#define KEY_4_1 HID_KEYBOARD_SC_KEYPAD_2_AND_DOWN_ARROW</span><br />
			<span class="compiler">#define KEY_4_2 HID_KEYBOARD_SC_KEYPAD_3_AND_PAGE_DOWN</span><br />
			<span class="compiler">#define KEY_4_3 HID_KEYBOARD_SC_KEYPAD_ENTER</span><br />
			<span class="compiler">#define KEY_5_0 HID_KEYBOARD_SC_KEYPAD_0_AND_INSERT</span><br />
			<span class="compiler">#define KEY_5_1 </span> <span class="numerical">0x00</span>&emsp;&emsp;&emsp; <span class="comment">// No key here.</span><br />
			<span class="compiler">#define KEY_5_2 HID_KEYBOARD_SC_KEYPAD_DOT_AND_DELETE</span><br />
			<span class="compiler">#define KEY_5_3 </span> <span class="numerical">0x00</span>&emsp;&emsp;&emsp; <span class="comment">// No key here.</span><br />
			<br />
			<span class="comment">// The key map array - for regular key strokes including media control keys.</span><br />
			<span class="type">const char</span> KEYMAP[<span class="compiler">NUM_KEY_ROWS</span>][<span class="compiler">NUM_KEY_COLS</span>] PROGMEM <span class="operator">=</span> {<br />
			&emsp;&emsp;&emsp;	<span class="comment">//Col 0 &emsp;&emsp;&emsp;	Col 1 &emsp; &emsp;&emsp;	Col 2 &emsp; &emsp;&emsp;	Col 3</span><br />
			&emsp;&emsp;&emsp;	{<span class="compiler">KEY_1_0</span>,&emsp;&emsp;&emsp;	<span class="compiler">KEY_1_1</span>,&emsp;&emsp;&emsp;	<span class="compiler">KEY_1_2</span>,&emsp;&emsp;&emsp;	<span class="compiler">KEY_1_3</span>},&emsp;&emsp;&emsp;	<span class="comment">// Row 1</span><br />
			&emsp;&emsp;&emsp;	{<span class="compiler">KEY_2_0</span>,&emsp;&emsp;&emsp;	<span class="compiler">KEY_2_1</span>,&emsp;&emsp;&emsp;	<span class="compiler">KEY_2_2</span>,&emsp;&emsp;&emsp;	<span class="compiler">KEY_2_3</span>},&emsp;&emsp;&emsp;	<span class="comment">// Row 2</span><br />
			&emsp;&emsp;&emsp;	{<span class="compiler">KEY_3_0</span>,&emsp;&emsp;&emsp;	<span class="compiler">KEY_3_1</span>,&emsp;&emsp;&emsp;	<span class="compiler">KEY_3_2</span>,&emsp;&emsp;&emsp;	<span class="compiler">KEY_3_3</span>},&emsp;&emsp;&emsp;	<span class="comment">// Row 3</span><br />
			&emsp;&emsp;&emsp;	{<span class="compiler">KEY_4_0</span>,&emsp;&emsp;&emsp;	<span class="compiler">KEY_4_1</span>,&emsp;&emsp;&emsp;	<span class="compiler">KEY_4_2</span>,&emsp;&emsp;&emsp;	<span class="compiler">KEY_4_3</span>},&emsp;&emsp;&emsp;	<span class="comment">// Row 4</span><br />
			&emsp;&emsp;&emsp;	{<span class="compiler">KEY_5_0</span>,&emsp;&emsp;&emsp;	<span class="compiler">KEY_5_1</span>,&emsp;&emsp;&emsp;	<span class="compiler">KEY_5_2</span>,&emsp;&emsp;&emsp;	<span class="compiler">KEY_5_3</span>}	&emsp;&emsp;&emsp;	<span class="comment">// Row 5</span><br />
			};<br />
			<br />
			<span class="comment">// The macro map array - for key strokes that are mapped as macros.</span><br />
			<span class="type">const macro_t</span> MACROMAP[<span class="compiler">NUM_MACRO_ROWS</span>][<span class="compiler">NUM_MACRO_COLS</span>][<span class="compiler">MAX_MACRO_ACTIONS</span>] PROGMEM = <br />
			{<br />
			&emsp;&emsp;&emsp;	{ <span class="comment">//Row0</span><br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{ <span class="comment">//Col0</span><br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_KEYS</span>, {<span class="compiler">HID_KEYBOARD_SC_F12</span>}},	<span class="comment">// This macro is just the same as hitting the F12 key.</span><br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{ <span class="comment">//Col1</span><br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_KEYS</span>, {<span class="compiler">HID_KEYBOARD_SC_LEFT_GUI</span>}},	<span class="comment">// This macro will go to the specified url in a new firefox tab.</span><br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_WAIT</span>, {<span class="numerical">1</span>}},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"firefox"</span>},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_KEYS</span>, {<span class="compiler">HID_KEYBOARD_SC_ENTER</span>}},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_WAIT</span>, {<span class="numerical">3</span>}},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_KEYS</span>, {<span class="compiler">HID_KEYBOARD_SC_LEFT_CONTROL</span>, <span class="compiler">HID_KEYBOARD_SC_T</span>}},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"https://clews.pro/projects/jank.php"</span>},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_KEYS</span>, {<span class="compiler">HID_KEYBOARD_SC_ENTER</span>}},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{ <span class="comment">//Col2</span><br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"      _\n"</span>},	<span class="comment">// This macro will enter a series of strings to create some ascii art.</span><br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"     ( )\n"</span>},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"      H\n"</span>},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"      H\n"</span>},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"     _H_\n"</span>},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"  .-'-.-'-.\n"</span>},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">" /         \\\n"</span>},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"|           |\n"</span>},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"|   .-------'._\n"</span>},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"|  / /  '.' '. \\\n"</span>},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"|  \\ \\ @   @ / /\n"</span>},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"|   '---------'\n"</span>},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"|    _______|\n"</span>},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"|  .'-+-+-+|\n"</span>},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"|  '.-+-+-+|\n"</span>},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"|    '''''' |\n"</span>},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"'-.__   __.-'\n"</span>},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"     '''\n</span>"}<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{ <span class="comment">//Col3</span><br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_STRING</span>, <span class="string">"Bender is Great!"</span>},	<span class="comment">// This macro will type a string of characters then hit enter.</span><br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	{<span class="compiler">M_KEYS</span>, {<span class="compiler">HID_KEYBOARD_SC_ENTER</span>}},<br />
			&emsp;&emsp;&emsp;	&emsp;&emsp;&emsp;	}<br />
			&emsp;&emsp;&emsp;	}<br />
			};<br />
			</p></div>
			<p>Using the configuration above, the macro mapped to the key at row zero, column 1 is an example that uses all three types of macro actions (string, keys and wait).</p>
			<ol>
				<li><b>KEYS</b> - Press the keyboard "GUI" key.</li>
				<li><b>WAIT</b> - Wait a second for the OS context to switch.</li>
				<li><b>STRING</b> - Type the string "firefox".</li>
				<li><b>KEYS</b> - Press the "Enter" key, thus opening (or switching to) firefox.</li>
				<li><b>WAIT</b> - Wait a few seconds for firefox to load (in case it isn't already running).</li>
				<li><b>KEYS</b> - Enter the key combination "ctrl + t" to open a new browsing tab.</li>
				<li><b>STRING</b> - Enter a URL.</li>
				<li><b>KEYS</b> - Press the "Enter" key, thus directing firefox to the specified URL.</li>
			</ol>
			<hr />

			<h2>Improvememnts</h2>
			<p>If I ever do a revision, I'll make an adjustment to the LED controller circuit.  I implemented the PWM brightness control using the basic configuration as per figure 7 of the <a href="https://gitlab.com/clewsy/jank/-/blob/master/data/MP3202_LED_Driver_U2.pdf">MP3202 datasheet</a>.  This arrangement is for dimming with a PWM frequency of no higher than 1kHz.  This seemed fine for my purpose, however what I didn't think of was the hum from the inductor.  It's only audible if the room is otherwise silent, but I could have eliminated it completely with a PWM frequency above the human-audible range.  I should have configured the circuit in accordance with figure 8 of the datasheet which can tolerate higher frequencies because it has some additional passives for filtering the PWM signal.</p>
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
					<td class="align-left"><a href="images/jank/jank_15.jpg"><img class="photo" src="images/jank/small_jank_15.jpg" alt="Wooden frame - top." /></a></td>
					<td class="align-right"><a href="images/jank/jank_16.jpg"><img class="photo" src="images/jank/small_jank_16.jpg" alt="Wooden frame - bottom	." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_17.jpg"><img class="photo" src="images/jank/small_jank_17.jpg" alt="Wooden frame, LEDs on, no keycaps." /></a></td>
					<td class="align-right"><a href="images/jank/jank_18.jpg"><img class="photo" src="images/jank/small_jank_18.jpg" alt="Wooden frame, LEDs on, with keycaps." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_19.jpg"><img class="photo" src="images/jank/small_jank_19.jpg" alt="Testing with the laptop - 1." /></a></td>
					<td class="align-right"><a href="images/jank/jank_20.jpg"><img class="photo" src="images/jank/small_jank_20.jpg" alt="Testing with the laptop - 2." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/jank/jank_21.gif"><img class="photo" src="images/jank/jank_21.gif" alt="Fast-speed LED pulse effect, no keycaps." /></a></td>
					<td class="align-right"><a href="images/jank/jank_22.gif"><img class="photo" src="images/jank/jank_22.gif" alt="Medium-speed LED pulse effect, with keycaps." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
