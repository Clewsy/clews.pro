<!DOCTYPE html>
<html>
	<head>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/head.html"); ?>
	</head>
	<body>
		<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.html"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">Contributions</h2>
			<p>Here are some projects that are not mine, but have accepted contributions from me.  This is what I love about the open source community. :)</p>
			<hr />
			<h3><a href="https://github.com/rcdailey/nextcloud-cronjob">nextcloud-cronjob</a> | <a href="https://github.com/rcdailey/nextcloud-cronjob/pull/4">Pull Request</a> | <a href="https://github.com/rcdailey/nextcloud-cronjob/pull/4/commits/9364ae75e18242b383d90a72b664a9c9d3d58ecf">Commit</a></h3>
			<p><a href="https://nextcloud.com/">Nextcloud</a> is a fantastic tool.  My <a href="https://clews.pro/projects/clews.php">self-hosted</a> delpoyment of Nextcloud is implemented with a <a href=https://www.docker.com/">Docker</a> container <a href="https://hub.docker.com/_/nextcloud">image</a>.</p>
			<p>A non-containerised Nexcloud installation requires a cronjob to execute a php script "<a href="https://github.com/nextcloud/server/blob/master/cron.php">cron.php</a>".  The script is needed to run any background tasks for installed Nextcloud apps.  For a containerised version of Nextcloud, there are a few possible methods for the routine execution of cron.php.</p>
			<p>The method I went with was another container image called "<a href="https://github.com/rcdailey/nextcloud-cronjob">nextcloud-cronjob</a>" (<a href="https://hub.docker.com/r/rcdailey/nextcloud-cronjob">dockerhub link</a>) created by <a href="https://github.com/rcdailey">Robert Dailey</a>.  I liked this solution mostly becuse I understood how it worked at a time when I was just beginning to learn about Docker.  It also has the benefit of not requiring the Nextcloud container to be run by the root user.</p>
			<p>I used the nextcloud-cronjob source <a href="https://github.com/rcdailey/nextcloud-cronjob/blob/master/Dockerfile">dockerfile</a> as a starting-point when I wanted to learn how to create my own docker image for <a href="https://clews.pro/projects/ncbu.php">ncbu</a>.  My project had similar requirements - run a command at defined intervals, and access other containers.<p>
			<p>After getting ncbu working to my sattisfaction, I began investigating techniques to improve the efficiency by reducing the image size and reducing the build time.  Initially my ncbu dockerfile would install the "<a href="https://pkgs.alpinelinux.org/package/edge/community/x86_64/docker">docker</a>" package in order to provide the ability of accessing other docker containers via the "docker exec" command within scripts.  In researching efficiencies, I learned that instead of installing the docker package and all its dependencies, all I needed was one of said dependencies - a package called "<a href="https://pkgs.alpinelinux.org/package/edge/community/x86_64/docker-cli">docker-cli</a>" which provides the "docker exec" capability.  This change reduced the size of the ncbu image by over 200MB.</p>
			<p>After this revelation and improvement, I decided to fork nextcloud-cronjob and test the same change for that image.  It appeared to work with no issues so I submitted the pull-request.  After some discussion with rcdailey, the simple <a href="https://github.com/rcdailey/nextcloud-cronjob/commit/e90dcc60d206c21749f8b8bc054e045cb3867446">commit</a> was accepted and the <a href="https://github.com/rcdailey/nextcloud-cronjob/pull/4">PR merged</a> which reduced the nextcloud-cronjob image size from 324BM to 83MB (~75% reduction).</p>
			<hr />
			<h3><a href="https://github.com/rcdailey/nextcloud-cronjob">nextcloud-cronjob</a> | <a href="https://github.com/rcdailey/nextcloud-cronjob/pull/4">Pull Request</a> | <a href="https://github.com/rcdailey/nextcloud-cronjob/pull/4/commits/9364ae75e18242b383d90a72b664a9c9d3d58ecf">Commit</a></h3>
		</div>
	</body>
</html>
