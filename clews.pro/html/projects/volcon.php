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
			<a href="images/volcon_01.jpg"><img class="photo align-left" src="images/small_volcon_01.jpg" alt="The final assembled volcon." /></a>
			<p>This project began as an experiment when I inexplicably decided to learn how an optical rotary encoder worked (FYI, 2-bit gray code).</p>
			<p>It transformed into a learning experience around USB - specifically the HID protocol. Ultimately I ended up with a simple gadget that now sits on my desk and allows me to control the PC volume.</p>
			<p>A salvaged optical encoder was used to detect rotation along with a reclaimed head drum from a VCR which was repurposed as a control knob.  I very much like the smotth bearings combined with the heavy mass that let the drum spin forever.</p>
			<p>Key concepts for the project were:</p>
			<ul>
				<li>The optical encoder parts (sensors and disk) were salvaged from an old track-ball.</li>
				<li>The "knob" was made from the head drum of a VCR (remember those?).  This is the part that spins and is used to adjust volume on my PC.</li>
				<li>The optical disk was fixed to the shaft and optical sensors mounted off some strip-board and attached to the base of the drum.</li>
				<li>This assembly is mounted to a custom PCB with some nylon stand-offs. The PCB became the base of the whole unit.</li>
				<li>I cut some wooden rings to enclose the electronics and the base of the VCR drum.</li>
				<li>The custom PCB was designed in eagle and etched at home from some single-sided copper-clad board. The circuit was designed around an AVR at90usb162.</li>
				<li>The code is written in C and implements the LUFA library developed by Dean Cameron.</li>
				<li>The whole unit plugs into a PC via USB and is automatically identified as a HID - no drivers required (tested in Debian Linux and Windows).</li>
				<li>It's a very simple device - rotate clockwise to increase volume, counter-clockwise to decrease.</li>
        			<li>Code and PCB design are available via <a href="https://gitlab.com/clewsy/volcon">gitlab</a>). Here are some reference links:</li>
				<ul>
					<li><a href="https://gitlab.com/clewsy/volcon">VolCon gitlab repo</a> - for code and eagle design (PCB)</li>
					<li><a href="http://www.fourwalledcubicle.com/LUFA.php">LUFA</a> (lightweight USB Framework for AVRs) main page</li>
				</ul>
			</ul>
			<hr />
			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="images/volcon_02.jpg"><img class="photo" src="images/small_volcon_02.jpg" alt="Partially assembled." /></a></td>
					<td class="align-right"><a href="images/volcon_03.jpg"><img class="photo" src="images/small_volcon_03.jpg" alt="Bottom view." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/volcon_04.jpg"><img class="photo" src="images/small_volcon_04.jpg" alt="Planning - block diagram." /></a></td>
					<td class="align-right"><a href="images/volcon_05.jpg"><img class="photo" src="images/small_volcon_05.jpg" alt="Planning - sensors." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
