<!DOCTYPE html>
<html>
	<head>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/head.html"); ?>
	</head>
	<body>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.html"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">gps_clock</h2>
			<a href="images/gps_clock/gps_clock_01.jpg"><img class="photo align-left" src="images/gps_clock/small_gps_clock_01.jpg" alt="The final clock, epoch time display mode." /></a>
			<p>I read somewhere about <a href="https://en.wikipedia.org/wiki/Unix_time">UNIX Epoch Time</a> and thought, wouldn't it be neat to have a clock that showed time in this format?  This project developed from that idea.</p>
			<p>I had a disused GPS module with serial output so I thought I could use that for syncing the time and thus avoiding setting the clock manually.</p>
			<p>The final clock has the following features and characteristics:</p>
			<ol>
				<li>16 digit 7-segment LED display (in cold white, though the photos below give it a blue tint).</li>
				<li>Date/Time display in EPOCH format (seconds elapsed since 1970-01-01T00:00:00).</li>
				<li>Date/Time display ISO-8601 format (YYYY.MM.DD.HH.MM.SS).</li>
				<li>Adjustable brightness (setting retained with power-cycle).</li>
				<li>Programmable UTC offset from -12hrs to +12hrs in 0.5 hour increments (setting retained with power-cycle).</li>
				<li>RTC with battery back-up to retain time with power-cycle or loss of GPS signal.</li>
			</ol>
			<p>The date/time data is parsed from the <a href="https://en.wikipedia.org/wiki/NMEA_0183">NMEA</a> sentence output by the GPS module via the ATmega's USART.  This is converted to local time according to an adjustable UTC offset.  This offset is stored in eeprom so that it is retained after a power-cycle.  The offset can be adjusted in half-hour increments from -12hrs to +12hrs.</p>
			<p>After a sync, the time is set in the <a href="https://www.maximintegrated.com/en/products/analog/real-time-clocks/DS3234.html">DS3234</a> RTC module which is referenced whenever the display is refreshed.  The RTC has a battery back-up so that the time is retained with no power.  The RTC is only re-set after a "successful" time sync from the GPS, so if there is no signal, the current time is not changed.</p>
			<p>The schematic and PCB CAD files were developed with <A href="https://kicad-pcb.org/">KiCad</a>.  The code was written in C and developed using <a href="https://atom.io/">Atom</a>.  All these files are included in the <a href="https://gitlab.com/clewsy/gps_clock">gitlab repository</a>.</p>
			<a href="images/gps_clock/gps_clock_14.jpg"><img class="photo align-right" src="images/gps_clock/small_gps_clock_14.jpg" alt="Assembled with new display board." /></a>
			<p>This project served as my first attempt at sourcing boards from a fabricator (previously I have etched using the toner transfer method).  This meant I was able to use SMD components (also a first) to reduce board size.  I used <a href="https://oshpark.com/">OSH Park</a> for board fab due to user-friendlieness.  Next time I will try a different supplier (hopefully more local or at lower cost, preferably both).</p>
			<p>The enclosure was made on the fly from some <a href="https://duckduckgo.com/?t=canonical&q=spotted+gum&iax=images&ia=images">spotted gum</a>.  The back panel is just stained plywood.</p>
			<p>The project is actually an iteration on a similar project (rev_1) created in 2014.  Rev_1 used single-sided hand-etched PCBs and was finished with a much more "rustic" enclosure (stained pine).  It also had an internal power supply which made the enclosure significantly bulkier.  Rev_2 has a number of newer features and improvements, notable better firmware, hardware and woodwork (i.e. everything).</p>
			<p>By default, the clock boots into a mode that displays date/time in human-readable <a href="https://en.wikipedia.org/wiki/ISO_8601">ISO-8601</a> format.  The EPOCH time display mode isn't super intuitive and was really just implemented to amuse myself.</p>
			<p>The epoch time variable is stored as an unsigned 32-bit integer, so this clock should not suffer the <a href="https://en.wikipedia.org/wiki/Year_2038_problem">year 2038 problem</a> which is an affliction of devices that use a signed 32-bit integer.  The down-side is that it cannot show time/date prior to the 1st of January 1970, but that's not a feature needed for a clock anyway.</p>
			<p>More recently, I had some additional display board PCBs fabricated, this time with a correction.  The previous iteration had a de-coupling capacitor on one of the <a href="https://www.maximintegrated.com/en/products/power/display-power-control/MAX7219.html">MAX-7219</a> chips that wasn't grounded.  I also tried out an alternative fabricator, this time going with <a href="https://jlcpcb.com/">JLCPCB</a> and having the boards fabricated in slick black.</p>
			<hr />
			<h2 class="align-center">Gallery</h2>
			<table class="gallery">
				<tr>
					<td class="align-left"><a href="images/gps_clock/gps_clock_17.gif"><img class="photo" src="images/gps_clock/small_gps_clock_17.gif" alt="Demo." /></a></td>
					<td class="align-right"><a href="images/gps_clock/gps_clock_02.jpg"><img class="photo" src="images/gps_clock/small_gps_clock_02.jpg" alt="In development." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/gps_clock/gps_clock_03.jpg"><img class="photo" src="images/gps_clock/small_gps_clock_03.jpg" alt="PCB modules, rear view." /></a></td>
					<td class="align-right"><a href="images/gps_clock/gps_clock_04.jpg"><img class="photo" src="images/gps_clock/small_gps_clock_04.jpg" alt="PCB modules, top view." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/gps_clock/gps_clock_05.jpg"><img class="photo" src="images/gps_clock/small_gps_clock_05.jpg" alt="Assembled into the wooden enclosure." /></a></td>
					<td class="align-right"><a href="images/gps_clock/gps_clock_06.jpg"><img class="photo" src="images/gps_clock/small_gps_clock_06.jpg" alt="Comparison to the first iteration." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/gps_clock/gps_clock_07.jpg"><img class="photo" src="images/gps_clock/small_gps_clock_07.jpg" alt="The final clock, one of the ISO-8601 display modes." /></a></td>
					<td class="align-right"><a href="images/gps_clock/gps_clock_08.png"><img class="photo" src="images/gps_clock/gps_clock_08.png" alt="The Control Board Schematic." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/gps_clock/gps_clock_09.png"><img class="photo" src="images/gps_clock/gps_clock_09.png" alt="The Display Board Schematic." /></a></td>
					<td class="align-right"><a href="images/gps_clock/gps_clock_10.jpg"><img class="photo" src="images/gps_clock/small_gps_clock_10.jpg" alt="Slick new black PCB - front." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/gps_clock/gps_clock_11.jpg"><img class="photo" src="images/gps_clock/small_gps_clock_11.jpg" alt="Slick new black PCB - back." /></a></td>
					<td class="align-right"><a href="images/gps_clock/gps_clock_12.jpg"><img class="photo" src="images/gps_clock/small_gps_clock_12.jpg" alt="Black display board populated - back." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/gps_clock/gps_clock_13.jpg"><img class="photo" src="images/gps_clock/small_gps_clock_13.jpg" alt="Black display board populated - front." /></a></td>
					<td class="align-right"><a href="images/gps_clock/gps_clock_14.jpg"><img class="photo" src="images/gps_clock/small_gps_clock_14.jpg" alt="Assembled with new display board." /></a></td>
				</tr>
				<tr>
					<td class="align-left"><a href="images/gps_clock/gps_clock_15.jpg"><img class="photo" src="images/gps_clock/small_gps_clock_15.jpg" alt="Assembled with new display board - ISO8601." /></a></td>
					<td class="align-right"><a href="images/gps_clock/gps_clock_16.jpg"><img class="photo" src="images/gps_clock/small_gps_clock_16.jpg" alt="Assembled with new display board - EPOCH." /></a></td>
				</tr>
			</table>
		</div>
	</body>
</html>
