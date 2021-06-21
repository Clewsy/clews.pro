<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.php"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">WiSHABI</h2>
			<a href="images/wishabi/wishabi_01.jpg"><img class="photo align-left" src="images/wishabi/small_wishabi_01.jpg" alt="The final project." /></a>
			<p>WiSHABI (WIreless Single-Handed Accelerometer-based Interface) is the project I created to complete of my university course. It was my first real exposure to programming microcontrollers and was a significant learning experience.</p>
			<p>The hardware consists of two units:</p>
			<ol>
				<li>Transmitter
				<ul>
					<li><a href="https://www.microchip.com/wwwproducts/en/ATmega8">ATmega8</a> AVR microcontroller.</li>
					<li><a href="https://www.analog.com/en/products/adxl330.html">ADXL330</a> three-axis  accelerometer.</li>
					<li>Battery pack with charge controller.</li>
					<li>433.92MHx serial transmitter module.</li>
				</ul>
				<li>Receiver
				<ul>
					<li><a href="https://www.microchip.com/wwwproducts/en/ATmega8">ATmega8</a> AVR microcontroller.</li>
					<li>USB Connector.</li>
					<li>Detachable LED grid display.</li>
					<li>433.92MHx serial receiver module.</li>
				</ul></li>	
			</ol>
			<p>A user of WiSHABI would connect the receiver into a USB port and then the transmitter can be used to as an input device.  It could be switched between two modes - mouse and keyboard.</p>
			<p>In mouse mode the cursor would be moved by the tilting motion of the transmitter.  Thumb buttons are used for left- and right-click.</p>
			<p>To type in keyboard mode, the unit would be pointed into one of nine sectors in a 3x3 grid then click to scroll through characters.  A similar concept to the 3x3 alpha-numeric character grid of a mobile phone keypad (this was pre-touchscreen smartphones!).</p>
			<p>The receiver unit connects to a PC via a USB-B connecor.  The ATmega8 doesn't have a USB peripheral, so the USB HID implementation was done in code with <a href="https://www.obdev.at/products/vusb/index.html">V-USB</a>.</p>
			<p>An aluminium enclosure was used for the receiver unit and a broken cordless screwdriver body was re-purposed for the transmitter.</p>
			<p>The transmitter ran off batteries but would still operate when tethered to a plug-pack for charging.</p>
			<p>In addition to the photo gallery below, I also archived the following resources:</p>
			<table class="simple-table">
				<tr>
					<td class="thumbnail"><a href="/projects/documents/wishabi/wishabi_report.pdf"><img class="thumbnail" src="/projects/documents/wishabi/thumbnail_wishabi_report.png" /></a>Report<br>(pdf)</td>
					<td class="thumbnail"><a href="/projects/documents/wishabi/wishabi_code.tar.gz"><img class="thumbnail" src="/projects/documents/wishabi/thumbnail_wishabi_code.png" /></a>Code<br>(gzipped tar)</td>
					<td class="thumbnail"><a href="/projects/video/wishabi/wishabi_1.mp4"><img class="thumbnail" src="/projects/video/wishabi/thumbnail_wishabi_1.png" /></a>Keyboard Demo<br>(mp4)</td>
					<td class="thumbnail"><a href="/projects/video/wishabi/wishabi_2.mp4"><img class="thumbnail" src="/projects/video/wishabi/thumbnail_wishabi_2.png" /></a>Mouse Demo 1<br>(mp4)</td>
					<td class="thumbnail"><a href="/projects/video/wishabi/wishabi_3.mp4"><img class="thumbnail" src="/projects/video/wishabi/thumbnail_wishabi_3.png" /></a>Mouse Demo 2<br>(mp4)</td>
				</tr>
			</table>
			<hr />
			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="images/wishabi/wishabi_02.jpg"><img class="photo" src="images/wishabi/small_wishabi_02.jpg" alt="Final assemblies." /></a></td>
					<td class="align-right"><a href="images/wishabi/wishabi_03.jpg"><img class="photo" src="images/wishabi/small_wishabi_03.jpg" alt="Transmitter in hand (ISP connector exposed)." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/wishabi/wishabi_04.jpg"><img class="photo" src="images/wishabi/small_wishabi_04.jpg" alt="Transmitter in hand (ISP connector exposed)." /></a></td>
					<td class="align-right"><a href="images/wishabi/wishabi_05.jpg"><img class="photo" src="images/wishabi/small_wishabi_05.jpg" alt="Transmitter (ISP connector exposed)." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/wishabi/wishabi_06.jpg"><img class="photo" src="images/wishabi/small_wishabi_06.jpg" alt="Transmitter open." /></a></td>
					<td class="align-right"><a href="images/wishabi/wishabi_07.jpg"><img class="photo" src="images/wishabi/small_wishabi_07.jpg" alt="Transmitter (ISP connector exposed)." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/wishabi/wishabi_08.jpg"><img class="photo" src="images/wishabi/small_wishabi_08.jpg" alt="Transmitter (ISP connector exposed)." /></a></td>
					<td class="align-right"><a href="images/wishabi/wishabi_09.jpg"><img class="photo" src="images/wishabi/small_wishabi_09.jpg" alt="LED grid display." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/wishabi/wishabi_10.jpg"><img class="photo" src="images/wishabi/small_wishabi_10.jpg" alt="Receiver circuit board." /></a></td>
					<td class="align-right"><a href="images/wishabi/wishabi_11.jpg"><img class="photo" src="images/wishabi/small_wishabi_11.jpg" alt="Receiver circuit board." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/wishabi/wishabi_12.jpg"><img class="photo" src="images/wishabi/small_wishabi_12.jpg" alt="Receiver unit." /></a></td>
					<td class="align-right"><a href="images/wishabi/wishabi_13.jpg"><img class="photo" src="images/wishabi/small_wishabi_13.jpg" alt="Receiver unit." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/wishabi/wishabi_14.png"><img class="photo" src="images/wishabi/wishabi_14.png" alt="Transmitter schematic." /></a></td>
					<td class="align-right"><a href="images/wishabi/wishabi_15.png"><img class="photo" src="images/wishabi/wishabi_15.png" alt="Receiver schematic." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
