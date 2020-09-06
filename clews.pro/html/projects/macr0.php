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
			<a href="images/macr0_15.jpg"><img class="photo align-left" src="images/small_macr0_15.jpg" alt="The current, final assembled volcon." /></a>
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
			<h2>Reflection</h2>
			<p>For the most part, everything worked out.  The only goal I didn't quite hit was in regards to the LED backlighting.  I used a CAT4101 LED but I didn't size the LEDs correctly.  Using 4 LEDs total, I used two channels of the CAT4104 with two LEDs per channel.  With VCC at 5V and the CAT4104 requiring 0.4V headroom, that leaves 4.6V per channel or 2.3V per LED.  The LEDs I used are rated at 3.5V.  As a result, I still have backlighting but at a lower brightness and with some instability (flickering).</p>
			<p>I have been using the device as a media controller with the keys configured as play/pause, stop, previous and next.</p>
			<p>The wood enclosure is made from spotted gum and was intended to match another project - <a href="/projects/volcon.php">volcon</a>.  A <a href="images/macr0_13.jpg">photo</a> in the gallery below shows both devices together.</p> 
			<p>I would make a few changes for a future revision:</p>
			<ul>
				<li>The smd crystal foorprint was from the included KiCad libray and has huge pads to ease hand-soldering.  They take up too much space and could easily be much smaller and still hand-solderable.</li>
				<li>With only four LEDs I would just drive them directly from the microcontroller instead of with the LED driver.  To have adjustable brightness I would still use a PWM pin and probably some transistors to sink the LED current.  The point of the LED driver was of course just to try it out and determine if it would be suitable for a future project.</li>
				<li>Similarly I would just use a gpio pin configured as an input to directly read each key.  For this 4-key input it would take exactly the same number of gpio pins.  Of course, then I wouldn't have learned how best to read a key matrix - also required for a future project.</li>
				<li>I put a pull-up resistor on the dimmer/brightness button for some reason.  This can be ommitted in favour of an internal pull-up.</li>
				<li>A thinner PCB would better suit the USB connector.  The pins don't quite extend through the default 1.6mm thick PCB I ordered from JLCPCB.</li>
			</ul>
			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="images/macr0_01.png"><img class="photo" src="images/macr0_01.png" alt="PCB design - top." /></a></td>
					<td class="align-right"><a href="images/macr0_02.png"><img class="photo" src="images/macr0_02.png" alt="PCB design - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0_03.jpg"><img class="photo" src="images/small_macr0_03.jpg" alt="PCB fabricated - top." /></a></td>
					<td class="align-right"><a href="images/macr0_04.jpg"><img class="photo" src="images/small_macr0_04.jpg" alt="PCB fabricated - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0_05.jpg"><img class="photo" src="images/small_macr0_05.jpg" alt="PCB assembled - bottom." /></a></td>
					<td class="align-right"><a href="images/macr0_06.jpg"><img class="photo" src="images/small_macr0_06.jpg" alt="PCB assembled - top." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0_07.jpg"><img class="photo" src="images/small_macr0_07.jpg" alt="PCB assembled - top with keycaps." /></a></td>
					<td class="align-right"><a href="images/macr0_08.jpg"><img class="photo" src="images/small_macr0_08.jpg" alt="Beginning fabrication of frame." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0_09.jpg"><img class="photo" src="images/small_macr0_09.jpg" alt="Frame and base fabrication 1." /></a></td>
					<td class="align-right"><a href="images/macr0_10.jpg"><img class="photo" src="images/small_macr0_10.jpg" alt="Frame and base fabrication 2." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0_11.jpg"><img class="photo" src="images/small_macr0_11.jpg" alt="Frame assembled." /></a></td>
					<td class="align-right"><a href="images/macr0_12.jpg"><img class="photo" src="images/small_macr0_12.jpg" alt="Enclosed - bottom view.." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0_13.jpg"><img class="photo" src="images/small_macr0_13.jpg" alt="Next to volcon." /></a></td>
					<td class="align-right"><a href="images/macr0_14.jpg"><img class="photo" src="images/small_macr0_14.jpg" alt="Assembled, pen for scale." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0_15.jpg"><img class="photo" src="images/small_macr0_15.jpg" alt="Assembled, closer view." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
