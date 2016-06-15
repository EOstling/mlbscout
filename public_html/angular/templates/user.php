<section class="col-md-12">
	<div class="well text-center">
		<h2>Favorite Players</h2>
		<table ng-init="loadFavoritePlayers();">
			<tr ng-repeat="player in favoritePlayer">
				<td>{{ player.playerFirstName }}</td>
			</tr>
		</table>