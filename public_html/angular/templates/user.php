<section class="col-md-3">
	<div class="well text-center">
		<h4>Favorite Players</h4>
		<table ng-init="loadFavoritePlayers();">
			<tr ng-repeat="player in favoritePlayer">
				<td>{{ player.playerFirstName }}</td>
			</tr>
		</table>`