<section class="col-md-12">
	<div class="well text-center">
		<h2>Favorite Players</h2>
		<table class="table table-striped" ng-init="loadFavoritePlayers();">
			<tr ng-repeat="player in favoritePlayer" ng-click="goToPlayer(player.playerId);">
				<td>{{ player.playerFirstName }}</td>
			</tr>
		</table>