<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.php"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">Contributions</h2>
			<p>Here are some projects that are not mine, but have accepted contributions I have suggested.  This is what I love about the open source community. :)</p>
			<hr />

			<h3 class="align-center">Summary</h3>
			<table class="simple-table">
				<tr>
					<th scope="col">Project</th>
					<th scope="col">Contribution</th>
					<th scope="col">Pull Request</th>
				</tr>
				<tr>
					<td><a href="https://github.com/rcdailey/nextcloud-cronjob">nextcloud-cronjob</a></td>
					<td>Decrease container image size by 75%.</td>
					<td><a href="https://github.com/rcdailey/nextcloud-cronjob/pull/4">apk add docker-cli instead of docker. #4</a></td>
				</tr>
				<tr>
					<td><a href="https://github.com/hassio-addons/addon-motioneye">addon-motioneye</a></td>
					<td>Add ability to implement <a href="https://github.com/ccrisan/motioneye/">motioneye</a> <a href="https://github.com/ccrisan/motioneye/wiki/Action-Buttons">action buttons</a>.</td>
					<td><a href="https://github.com/hassio-addons/addon-motioneye/pull/75">:sparkles: Add action buttons #75</a></td>
				</tr>
			</table><br />
			<hr />

			<h3><a href="https://github.com/rcdailey/nextcloud-cronjob">nextcloud-cronjob</a> | <a href="https://github.com/rcdailey/nextcloud-cronjob/pull/4">Pull Request</a> | <a href="https://github.com/rcdailey/nextcloud-cronjob/pull/4/commits/9364ae75e18242b383d90a72b664a9c9d3d58ecf">Commit</a></h3>
			<p><a href="https://nextcloud.com/">Nextcloud</a> is a fantastic tool.  My <a href="https://clews.pro/projects/clews.php">self-hosted</a> delpoyment of Nextcloud is implemented with a <a href="https://www.docker.com/">Docker</a> container <a href="https://hub.docker.com/_/nextcloud">image</a>.</p>
			<p>A Nexcloud installation requires a cronjob to execute a php script "<a href="https://github.com/nextcloud/server/blob/master/cron.php">cron.php</a>".  The script is needed to run any background tasks for installed Nextcloud apps.  For a containerised version of Nextcloud, there are a few possible methods for the routine execution of cron.php.</p>
			<p>The method I went with was another container image called "<a href="https://github.com/rcdailey/nextcloud-cronjob">nextcloud-cronjob</a>" (<a href="https://hub.docker.com/r/rcdailey/nextcloud-cronjob">dockerhub link</a>) created by <a href="https://github.com/rcdailey">Robert Dailey</a>.  I liked this solution mostly becuse I understood how it worked at a time when I was just beginning to learn about Docker.  It also has the benefit of not requiring the Nextcloud container to be run by the root user.</p>
			<a href="https://nextcloud.com/"><img class="image align-left" src="images/contributions/contributions_01.png" alt="Nextcloud" /></a>
			<p>I used the nextcloud-cronjob source <a href="https://github.com/rcdailey/nextcloud-cronjob/blob/master/Dockerfile">dockerfile</a> as a starting-point when I wanted to learn how to create my own docker image for <a href="https://clews.pro/projects/ncbu.php">ncbu</a>.  My project had similar requirements - run a command at defined intervals, and access other containers.<p>
			<p>After getting ncbu working to my satisfaction, I began investigating techniques to improve the efficiency by reducing both the image size and the build time.  Initially my <a href="https://gitlab.com/clewsy/ncbu/-/blob/master/Dockerfile">ncbu dockerfile</a> would install the "<a href="https://pkgs.alpinelinux.org/package/edge/community/x86_64/docker">docker</a>" package to facilitate accessing other docker containers via scripted "docker exec" commands.  I learned that instead of installing the docker package and all its dependencies, all I needed was <i>one</i> of said dependencies - a package called "<a href="https://pkgs.alpinelinux.org/package/edge/community/x86_64/docker-cli">docker-cli</a>" which provides the "docker exec" capability.  This change reduced the size of the ncbu image by over 200MB.</p>
			<p>After this revelation and improvement, I decided to fork nextcloud-cronjob and test the same change for that image.  It appeared to work with no issues so I submitted the pull-request.  After some discussion with rcdailey, the simple <a href="https://github.com/rcdailey/nextcloud-cronjob/commit/e90dcc60d206c21749f8b8bc054e045cb3867446">commit</a> was accepted and the <a href="https://github.com/rcdailey/nextcloud-cronjob/pull/4">PR merged</a> which reduced the nextcloud-cronjob image size from 324BM to 83MB (~75% reduction).</p>
			<hr />

			<h3><a href="https://github.com/hassio-addons/addon-motioneye">addon-motioneye</a> | <a href="https://github.com/hassio-addons/addon-motioneye/issues/74">issue</a> | <a href="https://github.com/hassio-addons/addon-motioneye/pull/75">Pull Request</a> | <a href="https://github.com/hassio-addons/addon-motioneye/pull/75/commits">Commits</a></h3>
			<p>At home I use a few IP cameras, mostly for remotely monitoring animals.  I have a combination of proprietary dedicated IP cams (stock and modified) and raspberry pis with either a pi-cam or a usb web-cam.</p>
			<p>After trialing a few options, I settled on <a href="https://github.com/ccrisan/motioneye/">motioneye</a> as my preferred method of wrangling all of the camera feeds into a single interface.</p>
			<a href="https://home-assistant.io/"><img class="image align-right" src="images/contributions/contributions_02.png" alt="Home Assistant" /></a>
			<p>A useful feature of motioneye is the ability to create "<a href="https://github.com/ccrisan/motioneye/wiki/Action-Buttons">action buttons</a>".  Once configured, action buttons take the form of icons overlayed on the camera video feed.  When pressed, they can execute arbitrary scripts.  Some examples of my use-cases include:</p>
			<ul>
				<li>A light-bulb button that controls a lamp which is otherwise independent of the camera.</li>
				<li>Arrow icon buttons that are used to pan or tilt the camera.</li>
			</ul>
			<p>For a while I used motioneye installed on a dedicated raspberry pi.  Later though, I began experimenting with <a href="https://www.home-assistant.io/">Home Assistant</a> with the intention to integrate some services and automations I had scattered across multiple machines/devices.</p>
			<p>A feature of Home Assistant is the ability to install "<a href="https://www.home-assistant.io/addons/">Add-ons</a>" - both <a href="https://github.com/home-assistant/addons">official</a> and <a href="https://github.com/hassio-addons/repository">community developed</a> - which effectively install containerised versions of independently available applications.  Motioneye is <a href="https://github.com/hassio-addons/addon-motioneye">available</a> as one such add-on.</p>
			<p>Rather than run Home Assistant and motioneye on separate boxes, I decided to migrate my motioneye configuration into the containerised Home Assistant add-on version.</p>
			<p>This worked well in every way except one; I lost the ability to implement action buttons.  For action buttons to work, specifically named script files must be stored within a specific directory of the motioneye host.  This isn't possible for a Home Assistant add-on containerised image since the scripts are user-specific.  A more traditional container would allow you to bind the action button scripts directory so that they remain persistent even after rebuilding the container.  However, binding arbitrary directories isn't practical for the standardised Home Assistant add-on format.</p>
			<p>After some initial conversation via an <a href="https://github.com/hassio-addons/addon-motioneye/issues/74">issue</a> raised on GitHub and suggestions made by the maintainer <a href="https://github.com/frenck">Franck Nijhof</a>, I forked addon-motioneye to experiment and see if I could add the ability to implement action buttons.</p>
			<p>The solution was to define the action button names and script commands within the existing add-on configuration yaml file via the Home Assistant interface.  Modifications to the motioneye initialisation cause it to generate the action button script files when the container is started.</p>
			<p>I also updated the add-on documentation with a <a href="https://github.com/hassio-addons/addon-motioneye/blob/main/motioneye/DOCS.md#option-action_buttons">section</a> explaining to users how to configure the add-on to make use of action buttons.</p>
			<p>After some testing and incorporating feedback from frenck, the pull request was <a href="https://github.com/hassio-addons/addon-motioneye/pull/75">merged</a> and the <a href="https://github.com/hassio-addons/addon-motioneye/pull/75/files">commits</a> incorporated into the next addon-motioneye release.</p> 
			<hr />
			<a href="https://clews.pro/"><img class="image align-center" src="images/contributions/contributions_03.png" alt="clews.pro" /></a>
		</div>
	</body>
</html>
