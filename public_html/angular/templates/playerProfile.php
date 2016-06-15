<div class="row">
	<button type="button" ng-click="favoritePlayer();">Favorite Prisoner</button>
	<section class="col-md-9">
		<div class="col-md-6">
			<div class="well text-center">
				<h4>Player Picture</h4>
				<img class="img-responsive" src="/public_html/image/profilePicture.jpg" alt="Profile Picture">
			</div>
		</div>
		<div class="col-md-6">
			<div class="well">
				<h4>Player Stats</h4>
				<p>First Name: {{ player.playerFirstName }}</p>
				<p>Last Name: {{ player.playerLastName }}</p>
				<p>Batting: {{ player.playerBatting }}</p>
				<p>Position: {{ player.playerPosition }}</p>
				<p>Height: {{ player.playerHeight }} inches</p>
				<p>Weight: {{ player.playerWeight }} lbs</p>
				<p>HomeTown: {{ player.playerHomeTown }}</p>
				<p>Health Status: {{ player.playerHealthStatus }}</p>
			</div>
		</div>
		<div class="col-md-12">
			<div class="well text-center">
				<h4>Player Schedule</h4>
				<h5>Location:</h5> <h5>Date:</h5>
			</div>
		</div>
	</section>
	<section class="col-md-3">
		<div class="well text-center">
			<h4>Favorite Players</h4>
			<p>pic</p>
			<p>pic</p>
			<p>pic</p>
			<p>pic</p>
			<p>pic</p>
			<p>pic</p>
			<p>pic</p>
			<p>pic</p>
		</div>
	</section>
</div>
