<?php
	//Choose a random image from clewsy_00.png to clewsy_05.png.
	//Need to pad the random number with a zero if it has only a single digit.
	//clewsy_00.png - font: Cyberpunk - https://www.fonts4free.net/cyberpunk-font.html
	//clewsy_01.png - font: Hacked - https://www.fontspace.com/hacked-font-f28425
	//clewsy_02.png - font: Cyberway Riders - https://www.fontspace.com/cyberway-riders-font-f43849
	//clewsy_03.png - font: Hirosh - https://www.fontspace.com/hirosh-font-f1549
	//clewsy_04.png - font: Revamped - https://www.fontspace.com/revamped-font-f44237
	//clewsy_05.png - font: Atari Kids - https://www.fontspace.com/atari-kids-font-f5704
	$random_image = "/images/clewsy_" . str_pad(rand(0, 5), 2, "0", STR_PAD_LEFT) . ".png";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>clews.dev</title>
		<link href="/css/style.css" type="text/css" rel="stylesheet" />
		<link rel="shortcut icon" href="/favicon.ico">
	</head>
	<body>
		<div id="header">
			<a href="https://clews.dev"><img id="clewsy_image" src="<?php echo $random_image ?>" title="clewsy" height="180" /></a>
			<br />
			<a href="https://clews.pro"><b>Click here for something less rad.</b></a>
		</div>
		<div id="content">
			<br />
		</div>
        </body>
</html>
