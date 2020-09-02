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
			<a href="images/macr0_04.jpg"><img class="photo align-left" src="images/small_macr0_04.jpg" alt="The current, final assembled volcon." /></a>
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
			<h3>Summary</h3>
			<p>For the most part, everything worked out.  The only goal I didn't quite hit was in regards to the LED backlighting.  I used a CAT4101 LED but I didn't size the LEDs correctly.  Using 4 LEDs total, I used two channels of the CAT4104 with two LEDs per channel.  With VCC at 5V and the CAT4104 requiring 0.4V headroom, that leaves 4.6V per channel or 2.3V per LED.  The LEDs I used are rated at 3.5V.  As a result, I still have backlighting but at a lower brightness and with some instability (flickering).</p>
			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="images/macr0_01.png"><img class="photo" src="images/macr0_01.png" alt="PCB design - top." /></a></td>
					<td class="align-right"><a href="images/macr0_02.png"><img class="photo" src="images/macr0_02.png" alt="PCB design - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/macr0_03.jpg"><img class="photo" src="images/small_macr0_03.jpg" alt="PCP fabricated - top." /></a></td>
					<td class="align-right"><a href="images/macr0_04.jpg"><img class="photo" src="images/small_macr0_04.jpg" alt="PCB fabricated - bottom." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
