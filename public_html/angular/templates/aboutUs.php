<div class="sfooter-content">

	<!-- header -->
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
					<a class="navbar-brand" href="#">RealTimeScout</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

					<ul class="nav navbar-nav navbar-right">
						<li><a href="#">Home</a></li>
						<li><a href="#">About Us</a></li>
						<li><a href="#">Players</a></li>
						<li><a href="#">Search</a></li>
						<li><a href="#">Profile</a></li>
						<li><a href="#">Contact Us</a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</nav>
		</div>
	</header>
	<main>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="well text-center">
						<h1>About RealTimeScout</h1>
					</div>
				</div>
			</div>
			<!-- main content-->
			<div class="row">
				<div class="col-xs-12">
					<div class="well text-center">
						<div class="well text-center">
							<h3>RealTimeScout</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</div>
<footer class="p-y-4">
	<div class="container">
		<div class="copyright text-center">
			<div class="nav-center">
				<ul class="nav nav-pills nav-justified">
					<li role="presentation"><a href="#">Home</a></li>
					<li role="presentation"><a href="#">About Us</a></li>
					<li role="presentation"><a href="#">Players</a></li>
					<li role="presentation"><a href="#">Search</a></li>
					<li role="presentation"><a href="#">Profile</a></li>
					<li role="presentation"><a href="#">Contact Us</a></li>
				</ul>
			</div>
			&copy; RealTimeScout Productions
		</div>
	</div>
</footer>
