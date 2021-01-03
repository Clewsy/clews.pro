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
			<a href="images/macr0/macr0_32.jpg"><img class="photo align-left" src="images/macr0/small_macr0_32.jpg" alt="The assembled macr0 revision 2." /></a>
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
			<p>The firmware was programmed in C and draws from Dean Camera's <a href="http://www.fourwalledcubicle.com/LUFA.php">LUFA libray</a>.
			<hr />

			<h2>Revision 1</h2>
			<p>For the most part, everything worked out.  The only goal I didn't quite hit was in regards to the LED backlighting.  I used a CAT4101 LED but I didn't size the LEDs correctly.  Using 4 LEDs total, I used two channels of the CAT4104 with two LEDs per channel.  With VCC at 5V and the CAT4104 requiring 0.4V headroom, that leaves 4.6V per channel or 2.3V per LED.  The LEDs I used are rated at 3.5V.  As a result, I still have backlighting but at a lower brightness and with some instability (flickering).</p>
			<p>I have been using the device as a media controller with the keys configured as play/pause, stop, previous and next.</p>
			<p>The wood enclosure is made from spotted gum and was intended to match another project - <a href="/projects/volcon.php">volcon</a>.  A <a href="images/macr0/macr0_13.jpg">photo</a> in the gallery below shows both devices together.</p> 
			<hr />

			<h2>Revision 2</h2>
			<a href="images/macr0/macr0_35.gif"><img class="photo align-right" src="images/macr0/small_macr0_35.gif" alt="The assembled macr0 revision 2, showing the LED pulse effect." /></a>
			<p>Having learned a few lessons and prooved concepts for a larger-scale project, I decided to revise macr0 since I've found it quite useful.  Changes to be incorporated::</p>
			<ul>
				<li>The smd crystal foorprint was from the included KiCad libray and has huge pads to ease hand-soldering.  They take up too much space and could easily be much smaller and still hand-solderable.</li>
				<li>With only four LEDs I would just drive them directly from the microcontroller instead of with the LED driver.  To have adjustable brightness I would still use a PWM pin and probably some transistors to sink the LED current.  The point of the LED driver was of course just to try it out and determine if it would be suitable for a future project.</li>
				<li>Similarly I would just use a gpio pin configured as an input to directly read each key.  For this 4-key input it would take exactly the same number of gpio pins.  Of course, then I wouldn't have learned how best to read a key matrix - also required for a future project.</li>
				<li>I put a pull-up resistor on the dimmer/brightness button for some reason.  This can be ommitted in favour of an internal pull-up.</li>
			</ul>
			<p>Since this revision won't require the keyscan functionality, I'll record the code bellow for future reference (i.e. the mentioned larger-scale project) since it will no longer be reflected in the main gitlab branch.</p>
			<p>Revision 2 works great.  I get full brightness out of the LEDs (although I set the default to quite dim).  A button underneath the unit cycles through different LED mode - off, various brighness levels and a pulse effect with three different speeds.  The PCB is also a nicer fit to the wood enclosure.</p>
			<hr />

			<h2>Configuration</h2>
			<p>With Revision 2 the keys can be configured to take any of the following actions:</p>
			<ul>
				<li>A single regular keyboard keystroke including modifiers.</li>
				<li>A media control key (e.g. play, pause, toggle, stop, previous, next, volume up/down, etc).</li>
				<li>A "macro" - effectively types a sequential string of characters.</li>
			</ul>
			<p>The key actions are set when the AVR is flashed so configuration is done with the source code.  The only file that needs to be edited is the "keymap.c" file.  Following are some examples of how the keys can be configured.</p>
			<h3>Example 1</h3>
			<p>All four keys are configured for media control - toggle (play/pause) stop, previous and next.  It is this  configuration I actually settled on for daily use.</p>
			<div class="code"><p>
				<span class="comment">// keymap.c - Configure keys with this file.</span><br />
				<br />
				<span class="compiler">#include "keymap.h"</span><br />
				<br />
				<span class="type">const uint8_t</span> KEY_PIN_ARRAY</span>[] <span class="operator">=</span> {KEY_1, KEY_2, KEY_3, KEY_4};&emsp;																<span class="comment">// Set keys as regular keystrokes or media keys.</span><br />
				<span class="type">const uint8_t</span> MACRO_PIN_ARRAY</span>[] <span class="operator">=</span> {};&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;	<span class="comment">// Set keys as macros.</span><br />
				<br />
				<span class="comment">// Map the regular keystrokes.</span><br />
				<span class="type">const char</span> KEY_MAP[] PROGMEM <span class="operator">=</span> {<br />
				&emsp;&emsp;&emsp;&emsp;	HID_MEDIACONTROLLER_SC_TOGGLE,&emsp;&emsp;&emsp;		<span class="comment">// Key 1</span><br />
				&emsp;&emsp;&emsp;&emsp;	HID_MEDIACONTROLLER_SC_STOP,&emsp;&emsp;&emsp;&emsp;&emsp;	<span class="comment">// Key 2</span><br />
				&emsp;&emsp;&emsp;&emsp;	HID_MEDIACONTROLLER_SC_PREVIOUS,&emsp;				<span class="comment">// Key 3</span><br />
				&emsp;&emsp;&emsp;&emsp;	HID_MEDIACONTROLLER_SC_NEXT&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;	<span class="comment">// Key 4</span><br />
				};<br />
				<br />
				<span class="comment">// Map the macro strings.</span><br />
				<span class="type">const char</span> MACRO_MAP[][MAX_MACRO_CHARS] PROGMEM <span class="operator">=</span> {};<br />
			</p></div>
			<h3>Example 2</h3>
			<p>In this example the top two keys (1 and 2) are for media control (toggle and stop) and the bottom two keys (3 and 4) are macros that will type two different sentences.</p>
			<div class="code"><p>
				<span class="comment">// keymap.c - Configure keys with this file.</span><br />
				<br />
				<span class="compiler">#include "keymap.h"</span><br />
				<br />
				<span class="type">const uint8_t</span> KEY_PIN_ARRAY</span>[] <span class="operator">=</span> {KEY_1, KEY_2};&emsp;&emsp;&emsp;	<span class="comment">// Set keys as regular keystrokes or media keys.</span><br />
				<span class="type">const uint8_t</span> MACRO_PIN_ARRAY</span>[] <span class="operator">=</span> {KEY_3, KEY_4};&emsp;			<span class="comment">// Set keys as macros.</span><br />
				<br />
				<span class="comment">// Map the regular keystrokes.</span><br />
				<span class="type">const char</span> KEY_MAP[] PROGMEM <span class="operator">=</span> {<br />
				&emsp;&emsp;&emsp;&emsp;	HID_MEDIACONTROLLER_SC_TOGGLE,			<span class="comment">// Key 1</span><br />
				&emsp;&emsp;&emsp;&emsp;	HID_MEDIACONTROLLER_SC_STOP&emsp;&emsp;&emsp;	<span class="comment">// Key 2</span><br />
				};<br />
				<br />
				<span class="comment">// Map the macro strings.</span><br />
				<span class="type">const char</span> MACRO_MAP[][MAX_MACRO_CHARS] PROGMEM <span class="operator">=</span> {<br />
				&emsp;&emsp;&emsp;&emsp;	{<span class="string">"The quick brown fox jumped over the lazy dog.\n"</span>},&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;	<span class="comment">// Key 3</span><br />
				&emsp;&emsp;&emsp;&emsp;	{<span class="string">"How much wood would a woodchuck chuck if a woodchuck could chuck wood?\n"</span>}&emsp;																<span class="comment">// Key 4</span><br />
				};<br />
			</p></div>
			<h3>Example 3</h3>
			<p>For this final example all keys act as regular keyboard keystrokes.  Key 1 is a modifier (left shift) and the remaining keys are A, B and C.  This configuration therefore give macr0 the ability to type 'A', 'B', 'C', 'a', 'b' and 'c'.</p>
			<div class="code"><p>
				<span class="comment">// keymap.c - Configure keys with this file.</span><br />
				<br />
				<span class="compiler">#include "keymap.h"</span><br />
				<br />
				<span class="type">const uint8_t</span> KEY_PIN_ARRAY</span>[] <span class="operator">=</span> {KEY_1, KEY_2, KEY_3, KEY_4};&emsp;																<span class="comment">// Set keys as regular keystrokes or media keys.</span><br />
				<span class="type">const uint8_t</span> MACRO_PIN_ARRAY</span>[] <span class="operator">=</span> {};&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;	<span class="comment">// Set keys as macros.</span><br />
				<br />
				<span class="type">const char</span> KEY_MAP[] PROGMEM <span class="operator">=</span> {<br />
				&emsp;&emsp;&emsp;&emsp;	HID_KEYBOAD_SC_LEFT_SHIFT,&emsp;							<span class="comment">// Key 1</span><br />
				&emsp;&emsp;&emsp;&emsp;	HID_KEYBOAD_SC_A,&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;		<span class="comment">// Key 2</span><br />
				&emsp;&emsp;&emsp;&emsp;	HID_KEYBOAD_SC_B,&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;		<span class="comment">// Key 3</span><br />
				&emsp;&emsp;&emsp;&emsp;	HID_KEYBOAD_SC_C&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;	<span class="comment">// Key 4</span><br />
				};<br />
				<br />
				<span class="comment">// Map the macro strings.</span><br />
				<span class="type">const char</span> MACRO_MAP[][MAX_MACRO_CHARS] PROGMEM <span class="operator">=</span> {};<br />
			</p></div>
			<br />
			<hr />

			<h2>Key Scanning Code Snippets (superseded by revision 2)</h2>
			<p>The following code snippets became redundant and were removed from revision 2.  I've kept them here as reference for future use in a planned project that will use this matrixing keyscan functionality.</p>
			<div class="code"><p>
				<span class="comment">// The key map array.<br /></span>
				<span class="type">const char</span> KEYMAP</span>[NUM_ROWS][NUM_COLS] PROGMEM <span class="operator">=</span> {<br />
				&emsp;&emsp;&emsp;&emsp;<span class="comment">// Column 1	&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Column 2</span><br />
				&emsp;&emsp;&emsp;&emsp;{HID_MEDIACONTROLLER_SC_TOGGLE,		&emsp;&emsp; HID_MEDIACONTROLLER_SC_STOP},	&emsp;<span class="comment">// Row 1</span><br />
				&emsp;&emsp;&emsp;&emsp;{HID_MEDIACONTROLLER_SC_PREVIOUS,	&emsp;HID_MEDIACONTROLLER_SC_NEXT}		&emsp;&emsp;<span class="comment">// Row 2</span><br />
				};<br />
			</p></div>
			<div class="code"><p>
				<span class="comment">// Initialise the gpio for scanning rows and columns.</span><br />
				<span class="type">void</span> <span class="function">keyscan_init</span>(<span class="type">void</span>)<br />
				{<br />
				&emsp;&emsp;&emsp;&emsp;<span class="comment">// Set rows as outputs and initialise all as high (disabled).</span><br />
				&emsp;&emsp;&emsp;&emsp;KEYS_DDR <span class="operator">|=</span> ((<span class="numerical">1</span> <span class="operator">&lt;&lt;</span> ROW_1) <span class="operator">|</span> (<span class="numerical">1</span> <span class="operator">&lt;&lt;</span> ROW_2));<br />
				&emsp;&emsp;&emsp;&emsp;KEYS_PORT <span class="operator">|=</span> ((<span class="numerical">1</span> <span class="operator">&lt;&lt;</span> ROW_1) <span class="operator">|</span> (<span class="numerical">1</span> <span class="operator">&lt;&lt;</span> ROW_2));<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;<span class="comment">// Set columns as inputs and enable pull-ups.</span><br />
				&emsp;&emsp;&emsp;&emsp;KEYS_DDR <span class="operator">&amp;= ~</span>((<span class="numerical">1</span> <span class="operator">&lt;&lt;</span> COL_1) <span class="operator">|</span> (<span class="numerical">1</span> <span class="operator">&lt;&lt;</span> COL_2));<br />
				&emsp;&emsp;&emsp;&emsp;KEYS_PORT <span class="operator">|=</span> ((<span class="numerical">1</span> <span class="operator">&lt;&lt;</span> COL_1) <span class="operator">|</span> (<span class="numerical">1</span> <span class="operator">&lt;&lt;</span> COL_2));<br />
				}<br />
			</p></div>
			<div class="code"><p>
				<span class="comment">// Parse the detected key and update the appropriate part of the report struct.</span><br />
				<span class="type">void</span> <span class="function">handle_key</span>(<span class="type">char</span> key, <span class="type">keyscan_report_t</span> *keyscan_report)<br />
				{<br />
				&emsp;&emsp;&emsp;&emsp;<span class="comment">// Media key scan values start at 0xF0, after the last keyboard modifier key scan.</span><br />
				&emsp;&emsp;&emsp;&emsp;<span class="flow">if</span>(key <span class="operator">&gt;</span> HID_KEYBOARD_SC_RIGHT_GUI)<br />
				&emsp;&emsp;&emsp;&emsp;{<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Convert the media key to a value from 0 to 10.</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;key <span class="operator">-=</span> HID_MEDIACONTROLLER_SC_PLAY;<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Shift a bit to the corresponding bit within the media_keys integer.</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;keyscan_report->media_keys <span class="operator">|=</span> (<span class="numerical">1</span> <span class="operator">&lt;&lt;</span> key);<br />
				&emsp;&emsp;&emsp;&emsp;}<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;<span class="comment">// Modifier keys scan values start at 0xE0, after the last keyboard modifier key scan.</span><br />
				&emsp;&emsp;&emsp;&emsp;<span class="flow">else if</span>(key <span class="operator">></span> HID_KEYBOARD_SC_APPLICATION)<br />
				&emsp;&emsp;&emsp;&emsp;{<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Convert the media key to a value from 0 to 7.</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;key <span class="operator">-=</span> HID_KEYBOARD_SC_LEFT_CONTROL;<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Shift a bit to the corresponding bit within the modifier integer.</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;keyscan_report->modifier <span class="operator">|=</span> (<span class="numerical">1</span> </span>&lt;&lt;</span> key);<br />
				&emsp;&emsp;&emsp;&emsp;}<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;<span class="comment">// Regular keys scan values range from 0x00 to 0x65.</span><br />
				&emsp;&emsp;&emsp;&emsp;<span class="flow">else if</span>(key <span class="operator">&gt;</span> HID_KEYBOARD_SC_RESERVED)<br />
				&emsp;&emsp;&emsp;&emsp;{<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Skip array elements that already have a keyscan value written.</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="type">uint8_t</span> i <span class="operator">=</span> <span class="numerical">0</span>;<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="flow">while</span>((keyscan_report->keys[i]) <span class="operator">&amp;&amp;</span> (i <span class="operator">&lt;</span> MAX_KEYS)) i<span class="operator">++</span>;<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Only register the key if the maximum number of simultaneous keys is not reached.</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="flow">if</span>(i <span class="operator">&lt;</span> MAX_KEYS) keyscan_report->keys[i] <span class="operator">=</span> key;<br />
				&emsp;&emsp;&emsp;&emsp;}<br />
				}<br />
			</p></div>
			<div class="code"><p>
				<span class="comment">// Row-by-row scan through each column and determine which keys are currently pressed.</span><br />
				<span class="type">void</span> <span class="function">create_keyscan_report</span>(<span class="type">keyscan_report_t</span> *keyscan_report)<br />
				{<br />
				&emsp;&emsp;&emsp;&emsp;<span class="comment">// Start with a blank keyscan report.</span><br />
				&emsp;&emsp;&emsp;&emsp;memset(keyscan_report, <span class="numerical">0</span>, sizeof(keyscan_report_t));<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;<span class="comment">// Define the pins to scan through.</span><br />
				&emsp;&emsp;&emsp;&emsp;<span class="type">uint8_t</span> row_array[<span class="numerical">2</span>] <span class="operator">=</span> {ROW_1, ROW_2};<br />
				&emsp;&emsp;&emsp;&emsp;<span class="type">uint8_t</span> col_array[<span class="numerical">2</span>] <span class="operator">=</span> {COL_1, COL_2};<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;<span class="comment">// Loop through for each row.</span><br />
				&emsp;&emsp;&emsp;&emsp;<span class="flow">for</span>(<span class="type">uint8_t</span> r <span class="operator">=</span> <span class="numerical">0</span>; r <span class="operator">&lt;</span> sizeof(row_array); r<span class="operator">++</span>)<br />
				&emsp;&emsp;&emsp;&emsp;{<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Set low current row (enable check).</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;KEYS_PORT <span class="operator">&amp;= ~</span>(<span class="numerical">1</span> <span class="operator">&lt;&lt;</span> row_array[r]);<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Wait until row is set low before continuing, otherwise column checks can be missed.</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="flow">while</span>(<span class="operator">!</span>(<span class="operator">~</span>KEYS_PINS <span class="operator">&amp;</span> (<span class="numerical">1</span> <span class="operator">&lt;&lt;</span> row_array[r]))) {}<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Loop through for each column in the current row.</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="flow">for</span>(<span class="type">uint8_t</span> c <span class="operator">=</span> <span class="numerical">0</span>; c <span class="operator">&lt;</span> sizeof(col_array); c<span class="operator">++</span>)<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// If the button in the current row and column is pressed, handle it.</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="flow">if</span>(<span class="operator">~</span>KEYS_PINS <span class="operator">&amp;</span> (<span class="numerical">1</span> <span class="operator">&lt;&lt;</span> col_array[c]))<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;handle_key(pgm_read_byte(&amp;KEYMAP[r][c]), keyscan_report);<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;}<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;}<br />
				<br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="comment">// Set high current row (disable check).</span><br />
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;KEYS_PORT <span class="operator">|=</span> (<span class="numerical">1</span> <span class="operator">&lt;&lt;</span> row_array[r]);<br />
				&emsp;&emsp;&emsp;&emsp;}<br />
				}<br />
			</p></div>
			<hr />

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
					<td class="align-left"><a href="images/macr0/macr0_19.jpg"><img class="photo" src="images/macr0/small_macr0_19.jpg" alt="Rev 2 PCB - top view." /></a></td>
					<td class="align-right"><a href="images/macr0/macr0_20.jpg"><img class="photo" src="images/macr0/small_macr0_20.jpg" alt="Rev 2 PCB - bottom view." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0/macr0_21.jpg"><img class="photo" src="images/macr0/small_macr0_21.jpg" alt="Rev 2 PCB assembled." /></a></td>
					<td class="align-right"><a href="images/macr0/macr0_22.jpg"><img class="photo" src="images/macr0/small_macr0_22.jpg" alt="Rev 2 assembly - 1." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0/macr0_23.jpg"><img class="photo" src="images/macr0/small_macr0_23.jpg" alt="Rev 2 assembly - 2." /></a></td>
					<td class="align-right"><a href="images/macr0/macr0_24.jpg"><img class="photo" src="images/macr0/small_macr0_24.jpg" alt="Rev 2 assembly - 3." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0/macr0_25.jpg"><img class="photo" src="images/macr0/small_macr0_25.jpg" alt="Rev 2 assembled - bottom." /></a></td>
					<td class="align-right"><a href="images/macr0/macr0_26.jpg"><img class="photo" src="images/macr0/small_macr0_26.jpg" alt="Rev 2 assembled - top." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0/macr0_27.jpg"><img class="photo" src="images/macr0/small_macr0_27.jpg" alt="Rev 2 working." /></a></td>
					<td class="align-right"><a href="images/macr0/macr0_28.png"><img class="photo" src="images/macr0/macr0_28.png" alt="Schematic for revision 2." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0/macr0_29.jpg"><img class="photo" src="images/macr0/small_macr0_29.jpg" alt="Rev 2 working with blank, black keycaps." /></a></td>
					<td class="align-right"><a href="images/macr0/macr0_30.jpg"><img class="photo" src="images/macr0/small_macr0_30.jpg" alt="Rev 2 working with blank, translucent keycaps." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0/macr0_31.jpg"><img class="photo" src="images/macr0/small_macr0_31.jpg" alt="Rev 2 working with chrome arrow keycaps, next to volcon." /></a></td>
					<td class="align-right"><a href="images/macr0/macr0_32.jpg"><img class="photo" src="images/macr0/small_macr0_32.jpg" alt="Rev 2 working with chrome arrow keycaps." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0/macr0_33.jpg"><img class="photo" src="images/macr0/small_macr0_33.jpg" alt="Rev 2 working with black media control keycaps." /></a></td>
					<td class="align-right"><a href="images/macr0/macr0_34.jpg"><img class="photo" src="images/macr0/small_macr0_34.jpg" alt="Rev 2 working with black media control keycaps." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0/macr0_35.gif"><img class="photo" src="images/macr0/small_macr0_35.gif" alt="The assembled macr0 revision 2, showing the LED pulse effect." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
