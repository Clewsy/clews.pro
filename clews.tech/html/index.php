<?php
	//Choose a random image from clews_tech_01.png to clews_tech_03.png.
	$random_image = "/images/clews_tech_logo/clews_tech_0" . rand(1, 3) . ".png";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>clews.tech</title>
		<link href="/css/style.css" type="text/css" rel="stylesheet" />
		<link rel="shortcut icon" href="/favicon.ico">
	</head>
	<body>
		<div id="header">
			<a href="/index.php"><img id="logo_image" src="<?php echo $random_image ?>" title="Logo" width="400" /></a>
			<h1>clews.tech</h1>
			<p>Adventures of a met-tech.</p>
			<div id="header-links">
				<h2>
					<b>|</b>
					<a href="/antarctica.php">antarctica</a>
					<b>|</b>
				</h2>
			</div>
		</div>
	</body>
</html>
