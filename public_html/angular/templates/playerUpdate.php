<div class="row">
	<div class="col-xs-12">
		<div class="well text-center">
			<h1>Update Player Information</h1>
		</div>
	</div>
</div>
<!-- main content-->
<!--Begin Update Form-->
<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<div class="well text-center">
			<form name="playerUpdate" id="playerUpdate" class="form-horizontal well" ng-controller="AngularFormController"
					ng-submit="submit(formData, contactForm.$valid);" novalidate>
				<h3>Update Player Information</h3>
				<div class="form-group"
					  ng-class="{ 'has-error': contactForm.fullName.$touched && contactForm.fullName.$invalid }">
					<label for="firstName">First Name</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-user"></i>
						</div>
						<input type="text" id="firstName" name="firstName" class="form-control" placeholder="First Name"
								 ng-model="formData.fullName" ng-minlength="4" ng-maxlength="32" ng-required="true"/>
					</div>
					<div class="alert alert-danger" role="alert" ng-messages="contactForm.fullName.$error"
						  ng-if="contactForm.fullName.$touched" ng-hide="contactForm.fullName.$valid">
						<p ng-message="minlength">First Name is too short.</p>
						<p ng-message="maxlength">First Name is too long.</p>
						<p ng-message="required">Please enter your first name.</p>
					</div>
					<label for="lastName">Last Name</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-user"></i>
						</div>
						<input type="text" id="lastName" name="lastName" class="form-control" placeholder="Last Name"
								 ng-model="formData.fullName" ng-minlength="4" ng-maxlength="32" ng-required="true"/>
					</div>
					<div class="alert alert-danger" role="alert" ng-messages="contactForm.fullName.$error"
						  ng-if="contactForm.fullName.$touched" ng-hide="contactForm.fullName.$valid">
						<p ng-message="minlength">Last Name is too short.</p>
						<p ng-message="maxlength">Last Name is too long.</p>
						<p ng-message="required">Please enter your last name.</p>
					</div>
					<div ng-controller="ExampleController">
						<!--						<form name="myForm">-->
						<label for="playerBatting"> Throwing Hand: </label><br>
						<select name="PlayerBatting" ng-model="data.singleSelect">
							<option value="option-1">R</option>
							<option value="option-2">L</option>
							<option value="option-3">S</option>
						</select>
						<label for="playerPosition"> Position: </label><br>
						<select name="playerPosition" ng-model="data.singleSelect">
							<option value="option-1">1st</option>
							<option value="option-2">2nd</option>
							<option value="option-3">3rd</option>
							<option value="option-4">SS</option>
							<option value="option-5">Catcher</option>
							<option value="option-6">R.Field</option>
							<option value="option-7">L.Field</option>
							<option value="option-8">Center</option>
							<option value="option-9">Pitcher</option>
						</select>
						<label for="playerHealthStatus"> Health Status: </label><br>
						<select name="PlayerBatting" ng-model="data.singleSelect">
							<option value="option-1">Active</option>
							<option value="option-2">Inactive</option>
						</select>
						<label for="playerHometown"> Hometown: </label><br>
						<select name="playerHometown" ng-model="data.singleSelect">
							<option value="option-1">Albuquerque, NM</option>
							<option value="option-2">Santa Fe, NM</option>
							<option value="option-3">Las Cruces, NM</option>
							<option value="option-4">Taos, NM</option>
							<option value="option-5">Roswell, NM</option>
							<option value="option-6">Rio Rancho, NM</option>
							<option value="option-7">Farmington, NM</option>
							<option value="option-8">Ruidoso, NM</option>
							<option value="option-9">Alamogordo, NM</option>
						</select>
<!--						// player height dropdown-->
						<div class="form-group" ng-class="{ 'has-error': sampleForm.bid.$touched && sampleForm.bid.$invalid }">
							<label for="playerHeight">Height</label>
							<div class="input-group">
<!--								<div class="input-group-addon">-->
<!--									<i class="fa fa-usd"></i>-->
<!--								</div>-->
								<input type="number" name="playerHeight" id="playerHeight" min="40" step="0.1" max="89" class="form-control" ng-model="formData.bid" ng-required="true" />
							</div>
							<div class="alert alert-danger" role="alert" ng-messages="sampleForm.bid.$error" ng-if="sampleForm.bid.$touched" ng-hide="sampleForm.bid.$valid">
								<p ng-message="min">Height is too small.</p>
								<p ng-message="max">Height is too large.</p>
								<p ng-message="required">Please enter a height.</p>
							</div>
						</div>
<!--						player weight dropdown box-->
						<div class="form-group" ng-class="{ 'has-error': sampleForm.bid.$touched && sampleForm.bid.$invalid }">
							<label for="playerWeight">Weight</label>
							<div class="input-group">
<!--								<div class="input-group-addon">-->
<!--									<i class="fa fa-usd"></i>-->
<!--								</div>-->
								<input type="number" name="weight" id="playerWeight" min="100" step="1" max="315" class="form-control" ng-model="formData.bid" ng-required="true" />
							</div>
							<div class="alert alert-danger" role="alert" ng-messages="sampleForm.bid.$error" ng-if="sampleForm.bid.$touched" ng-hide="sampleForm.bid.$valid">
								<p ng-message="min">Weight is too small.</p>
								<p ng-message="max">Weight is too large.</p>
								<p ng-message="required">Please enter a weight.</p>
							</div>
						</div>

						<h1></h1>
						<button class="btn btn-lg btn-info" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Update
						</button>
						<hr/>
			</form>
		</div>
	</div>
</div>
</div>