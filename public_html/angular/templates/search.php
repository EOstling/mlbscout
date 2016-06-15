<div class="row">
	<div class="col-md-3"> </div>
	<div class="col-md-6">
		<div class="well text-center">
			<h1>Search</h1>
		</div>
	</div>
</div>
<!-- main content-->
<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<div class="well text-center">
			<form name="searchForm" id="searchForm" class="form-horizontal well" ng-submit="getSearch(formData, searchForm.$valid);" novalidate>
				<div class="form-group" ng-class="{ 'has-error': searchForm.fullName.$touched && searchForm.fullName.$invalid }">
					<label for="fullName">Search</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-search"></i>
						</div>
						<input type="text" id="search" name="search" class="form-control" placeholder="search" ng-model="formData.search" ng-minlength="1" ng-maxlength="32" ng-required="true" />
					</div>
					<div class="alert alert-danger" role="alert" ng-messages="searchForm.search.$error" ng-if="searchForm.search.$touched" ng-hide="searchForm.search.$valid">
						<p ng-message="minlength">Search is too short.</p>
						<p ng-message="maxlength">Search is too long.</p>
						<p ng-message="required">Please enter your search.</p>
					</div>
					<h1></h1>
					<button class="btn btn-lg btn-info" type="submit"><i class="fa fa-search"></i>&nbsp;Find</button>
					<hr />
			</form>
			<table>
				<tr ng-repeat="player in players">
					<td>First Name: {{player.playerFirstName}}</td>
					<td>Last Name: {{player.playerLastName}}</td>
					<td>Batting: {{ player.playerBatting }}</td>
					<td>Position: {{ player.playerPosition }}</td>
					<td>Height: {{ player.playerHeight }} inches</td>
					<td>Weight: {{ player.playerWeight }} lbs</td>
					<td>HomeTown: {{ player.playerHomeTown }}</td>
					<td>Health Status: {{ player.playerHealthStatus }}</td>
				</tr>
			</table>
		</div>
	</div>
</div>
</div>
