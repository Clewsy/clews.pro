<?php include("$_SERVER[DOCUMENT_ROOT]/includes/header.php"); ?>
<!-- Above here can be copied for a consistent header across pages -->
		<div id="page">
			<h2 class="align-center">clews.monster</h2>
			<a href="https://clews.monster"><img class="align-left" src="images/clews_monster/clews_monster_01.png" alt="Glitchy." width="340px" style="padding-right: 20px" /></a>
			<p><a href="https://clews.monster">clews.monster</a> is another site I created, this time to quickly set up some personal services and experiment with <a href="https://github.com/linuxserver/docker-swag">SWAG</a> (Secure Web Application Gateway) for reverse proxy/certbot and <a href="https://hub.docker.com/r/authelia/authelia">authelia</a> for authentication.</a></p>
			<p>The .monster top-level domain was chosen arbitrarily because it was cheap.</p>
			<p>I did have a bit more <a href="https://inkscape.org/">Inkscape</a> fun to make another variation on the logo I've used elsewhere.</p>
			<p>The site is automatically configured with an <a href="https://gitlab.com/clewsy/clewsy_ansible/-/tree/master/roles/monster"</a>ansible role</a>.  When run, the target host will install <a href="https://www.docker.com/">docker</a>/<a href="https://docs.docker.com/compose/">docker-compose</a> and copy a docker-compose.yml file which includes everything to pull and run the SWAG and Authelia images (as well as a few other services).</p>
			<p>The <a href="https://clews.monster">index page</a> is externally accessible, but authelia prevents access to the sub-domain pages without the correct credentials.</p>
		</div>
	</body>
</html>
