<!DOCTYPE html>
<html>
	<head>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/head.html"); ?>
	</head>
	<body>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.html"); ?>
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
				<li>The optical disk was fixed to the shaft and optical sensors mounted off some strip-board and attached to the base of the drum.</li>
				<li>This assembly is mounted to a custom PCB with some nylon stand-offs. The PCB became the base of the whole unit.</li>
				<li>I cut some wooden rings to enclose the electronics and the base of the VCR drum.</li>
				<li>The custom PCB was designed in eagle and etched at home from some single-sided copper-clad board. The circuit was designed around an AVR at90usb162.</li>
				<li>The code is written in C and implements the <a href="http://www.fourwalledcubicle.com/LUFA.php">LUFA</a> library <a href="https://github.com/abcminiuser/lufa/">developed</a> by <a href="http://www.fourwalledcubicle.com/AboutMe.php">Dean Camera</a>.</li>
				<li>The whole unit plugs into a PC via USB and is automatically identified as a HID - no drivers required (tested in Debian Linux and Windows).</li>
				<li>It's a very simple device - rotate clockwise to increase volume, counter-clockwise to decrease.</li>
        			<li>Code and PCB design are available via <a href="https://gitlab.com/clewsy/volcon">gitlab</a>). Here are some reference links:</li>
				<ul>
					<li><a href="https://gitlab.com/clewsy/volcon">VolCon gitlab repo</a> - for code and eagle design (PCB)</li>
					<li><a href="http://www.fourwalledcubicle.com/LUFA.php">LUFA</a> (lightweight USB Framework for AVRs) main page</li>
				</ul>
			</ul>
			<hr />
			<p>After some time (about six years!) of having this device in-use on my desk, I finally got sick of the simple (gross) stained pine wood enclosure.  With some scrap spotted gum and a router (with a Roman ogee and a roundover bit) I made a slightly nicer enclosure for volcon.
			<hr />
			<a href="images/volcon/volcon_22.gif"><img class="photo align-right" src="images/volcon/small_volcon_22.gif" alt="Rev 2 - Demo of gray code LED visualisation." /></a>
			<h2>Revision 2</h2>
			<p>After even more time, I decided to do an overhaul.  Revision 2 would use the same head drum, optical encoder sensors and wooden enclosure.  The upgrades from revision 1 include:</p>
			<ul>
				<li>Schematic and PCB layout completely redone but using <a href="https://www.kicad.org/">KiCad</a> instead of Eagle.</li>
				<li>Microcontroller changed from an AT90usb162 AVR to an ATmega32U4.</li>
				<li>Remove the serial Tx/Rx connector.</li>
				<li>Remove the reset tact-switch.</li>
				<li>Use smd components instead of through-hole.</li>
				<li>Connect with a USB type C connector instead of a USB type B.</li>
				<li>Have the PCB fabricated (<a href="https://jlcpcb.com/">JLCPCB</a>) instead of the home-made copper-etch method.</li>
				<li>A couple of LEDs on the bottom of the PCB purely to visualise the gray code (Rev 1 had LEDs but they only barely shone through etched sections of the PCB).</li>
				<li>Generally improved and cleaner code (still using the LUFA library).</li>
			</ul>
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
