<!DOCTYPE html>
<?php
	//Choose a random image from logo_distressed_01.png to /images/logo_distressed_15.png.
	//Need to pad the random number with a zero if it has only a single digit.
	$random_image = "/images/logo_distressed_" . str_pad(rand(1, 15), 2, "0", STR_PAD_LEFT) . ".png";
?>

<html>
	<head>
		<title>clews.dev</title>
		<link href="/css/style.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<div id="header">
			<a href="https://clews.dev">
				<img id="logo_image" src="<?php echo $random_image ?>" title="Logo" width="800" />
			</a>
			<h1>clewsy</h1>
			<div id="header-links">
				<h2>
					<a href="https://clews.pro">Try here instead</a>
				</h2>
			</div>
		</div>
        </body>
</html>


