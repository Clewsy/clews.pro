<?php
	//Choose a random image from clews_logo_00.png to clews_logo_15.png.
	//Need to pad the random number with a zero if it has only a single digit.
	$random_image = "/images/clews_logo/clews_logo_" . str_pad(rand(0, 15), 2, "0", STR_PAD_LEFT) . ".png";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>clews.pro</title>
		<link href="/css/style.css" type="text/css" rel="stylesheet" />
		<link rel="shortcut icon" href="/favicon.ico">
	</head>
	<body>
		<div id="header">
			<a href="/index.php"><img id="logo_image" src="<?php echo $random_image ?>" title="Logo" width="250" /></a>
			<h1>clewsy</h1>
			<p>A work-in-progress</p>
			<div id="header-links">
				<h2>
					<b>|</b>
					<a href="/projects.php">Projects</a>
					<b>|</b>
					<a href="/about.php">About</a>
					<b>|</b>
					<a href="https://nextcloud.clews.pro">Cloud</a>
					<b>|</b>
				</h2>
			</div>
		</div>
<!-- Don't forget to close the </body> and </html> tags. -->