<!DOCTYPE html>
<html>
	<head>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/head.html"); ?>
	</head>
	<body>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.html"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">led_matrix</h2>
			<a href="images/led_matrix_04.jpg"><img class="photo align-left" src="images/small_led_matrix_04.jpg" alt="The still-working led_matrix." /></a>
			<h3>Summary</h3>
			<p>According to early pages in my notebook, I built this in 2006.  I'm pretty sure this was my first microcontroller project (excluding of course blinking an LED).  Back then I didn't have good back-up habits and had never even heard of git, so the code I wrote is gone forever (maybe for the best).</p>
			<p>The enclosure is a translucent blue plastic so I can see some of the internals.  I'm not willing to open it up though - I can see a birds-nest of wiring and I expect after openeing it may never work again.  I was surprised it still works at all as it is!<p>
			<p>The matrix runs in two modes:</p>
			<ol>
				<li>Clock mode.  By default it displays hours and minutes but you can "scroll" right to show seconds.  There is a neat vertical scrolling animation when a digit changes.  There is no battery back-up of any kind so the clock resets to 12:00 every time it switches on.  It also keeps awful time - loses a few minutes each hour.  Pretty sure I was relying on the internal oscillator and whatever scaling got me closest to a one-second interrupt trigger.</li>
				<li>Text mode.  By default it scrolls the text "GAME OVER..." but you can change the text by scrolling through the alphabet for each character.</li>
			</ol>
			<p>From my notes and from what I can see through the case, I know this much:<p>
			<ul>
				<li>It has a matrix of 100 blue 5mm LEDs - 20 columns by 5 rows.</li>
				<li>It takes a 5V DC power supply.</li>
				<li>There is a socketed DIP ATMEGA8535 microcontroller running the show (I wish I could find the code I wrote!).</li>
				<li>Six buttons used for control and programming settings.</li>
				<li>Three 74HC138 3-to-8 line decoders are used for multiplexing each column.</li>
			</ul>
			<hr />
			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="images/led_matrix_01.jpg"><img class="photo" src="images/small_led_matrix_01.jpg" alt="Front view - 20x5 matrix." /></a></td>
					<td class="align-right"><a href="images/led_matrix_02.jpg"><img class="photo" src="images/small_led_matrix_02.jpg" alt="Rear view - proto-board." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/led_matrix_03.jpg"><img class="photo" src="images/small_led_matrix_03.jpg" alt="Side view - ATMEGA8535." /></a></td>
					<td class="align-right"><a href="images/led_matrix_04.jpg"><img class="photo" src="images/small_led_matrix_04.jpg" alt="Powered up - still works!" /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/led_matrix_05.gif"><img class="photo" src="images/small_led_matrix_05.gif" alt="Clock mode." /></a></td>
					<td class="align-right"><a href="images/led_matrix_06.gif"><img class="photo" src="images/small_led_matrix_06.gif" alt="Text mode." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/led_matrix_07.jpg"><img class="photo" src="images/small_led_matrix_07.jpg" alt="Old notes - matrix configuration." /></a></td>
					<td class="align-right"><a href="images/led_matrix_08.jpg"><img class="photo" src="images/small_led_matrix_08.jpg" alt="Old notes - 3x 74HC138 configuration." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
