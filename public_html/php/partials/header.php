<header ng-controller="NavController">
	<bootstrap-breakpoint></bootstrap-breakpoint>

	<div class="container">
		<nav class="navbar navbar-inverse">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
						  data-target="#bs-example-navbar-collapse-1" aria-expanded="false"
						  ng-click="navCollapsed =!navCollapsed">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="user-login">RealTimeScout</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div uib-collapse="navCollapsed" class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

				<ul class="nav navbar-nav navbar-right">
					<?php
					// if (there is NOT a user in the session)
					if(empty($_SESSION["user"]) === true) {
						?>
						<li><a href="sign-up">Have an Account? Sign Up</a></li>
					<?php } ?>
					<li><a href="user-login">Home</a></li>
					<li><a href="about-us">About Us</a></li>
					<li><a href="search">Search</a></li>
					<?php
					// if (there is NOT a user in the session)
					if(empty($_SESSION["user"]) !== true) {
						?>
						<li><a href="user">My Favorite Players</a></li>
					<?php } ?>
					<li><a href="contact-us">Contact Us</a></li>
					<?php if(!empty($_SESSION["user"]) === true) { ?>
						<li>
							<button class="btn btn-info navbar-btn" ng-click="logout();">Logout</button>
						</li>
					<?php } ?>
				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>
	</div>
</header>