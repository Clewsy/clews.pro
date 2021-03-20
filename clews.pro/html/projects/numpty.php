<!DOCTYPE html>
<html>
	<head>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/head.html"); ?>
	</head>
	<body>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.html"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">numpty</h2>
			<a href="images/numpty/numpty_01.jpg"><img class="photo align-left" src="images/numpty/small_numpty_01.jpg" alt="A description of the image." /></a>
			<p>numpty is a 21-key usb numeric keypad.  I wanted one for use with my laptop.  Sure it would have cost a lot less to just buy one, but... (insert justification here when you think of one).</p>
			<p>The main features of this keypad include:</p>
			<ul>
				<li><a href="https://en.wikipedia.org/wiki/Human_interface_device">HID</a> compliant USB peripheral using an <a href="https://www.microchip.com/wwwproducts/en/ATmega32U4">ATmega32U4</a> microcontroller with connectivity via a USB type-c connector configured as a USB 2.1 device.</li>
				<li>21 mechanical keys (gateron blues which are pin-compatible clones of <a href="https://www.cherrymx.de/en">Cherry MX</a> blues) with variable brightness white LED backlight on each key.</li>
				<li>In addition to the standard keys of a numerical keypad, there is also a row of four keys across the top of the device which are programmable macros.</li>
			</ul>

			<h2>Hardware</h2>
			<p>The schematic and PCB layout were designed in KiCAD.</p>
			<ul>
				<li>21 gateron mechanical keyswitches connected in a matrix of 4 columns and 6 rows.</li>
				<li>ATmega32u4 AVR microcontroller.</li>
				<li>MP3202 LED driver.</li>
			</ul>
			<hr />

			<h2>Firmware</h2>
			<a href="images/numpty/numpty_02.jpg"><img class="photo align-right" src="images/numpty/small_numpty_02.jpg" alt="A description of the second image." /></a>
			<p>Paragraph.</p>
			<ul>
				<li>First item.</li>
				<li>Second item.</li>
			</ul>

			<hr />

			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="images/numpty/numpty_01.png"><img class="photo" src="images/numpty/numpty_01.png" alt="PCB design - top." /></a></td>
					<td class="align-right"><a href="images/numpty/numpty_02.png"><img class="photo" src="images/numpty/numpty_02.png" alt="PCB design - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/numpty/numpty_03.jpg"><img class="photo" src="images/numpty/small_numpty_03.jpg" alt="PCB fabricated - top." /></a></td>
					<td class="align-right"><a href="images/numpty/numpty_04.jpg"><img class="photo" src="images/numpty/small_numpty_04.jpg" alt="PCB fabricated - bottom." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/numpty/numpty_05.jpg"><img class="photo" src="images/numpty/small_numpty_05.jpg" alt="PCB assembled - bottom." /></a></td>
					<td class="align-right"><a href="images/numpty/numpty_06.jpg"><img class="photo" src="images/numpty/small_numpty_06.jpg" alt="PCB assembled - top." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/numpty/numpty_07.jpg"><img class="photo" src="images/numpty/small_numpty_07.jpg" alt="PCB assembled - top with keycaps." /></a></td>
					<td class="align-right"><a href="images/numpty/numpty_08.jpg"><img class="photo" src="images/numpty/small_numpty_08.jpg" alt="Beginning fabrication of frame." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/numpty/numpty_09.jpg"><img class="photo" src="images/numpty/small_numpty_09.jpg" alt="Frame and base fabrication 1." /></a></td>
					<td class="align-right"><a href="images/numpty/numpty_10.jpg"><img class="photo" src="images/numpty/small_numpty_10.jpg" alt="Frame and base fabrication 2." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/numpty/numpty_11.jpg"><img class="photo" src="images/numpty/small_numpty_11.jpg" alt="Frame assembled." /></a></td>
					<td class="align-right"><a href="images/numpty/numpty_12.jpg"><img class="photo" src="images/numpty/small_numpty_12.jpg" alt="Enclosed - bottom view.." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/numpty/numpty_13.jpg"><img class="photo" src="images/numpty/small_numpty_13.jpg" alt="Next to volcon." /></a></td>
					<td class="align-right"><a href="images/numpty/numpty_14.jpg"><img class="photo" src="images/numpty/small_numpty_14.jpg" alt="Assembled, pen for scale." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/numpty/numpty_15.jpg"><img class="photo" src="images/numpty/small_numpty_15.jpg" alt="Assembled, closer view." /></a></td>
					<td class="align-right"><a href="images/numpty/numpty_16.png"><img class="photo" src="images/numpty/numpty_16.png" alt="Schematic for revision 1." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/numpty/numpty_17.png"><img class="photo" src="images/numpty/numpty_17.png" alt="PCB design - top - revision 2." /></a></td>
					<td class="align-right"><a href="images/numpty/numpty_18.png"><img class="photo" src="images/numpty/numpty_18.png" alt="PCB design - bottom - revision 2." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
