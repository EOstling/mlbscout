<div class="row">
	<div class="col-md-3"> </div>
	<div class="col-md-6">
		<div class="well text-center">
			<h1>Sign Up!</h1>
		</div>
	</div>
</div>
<!-- main content-->
<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<div class="well text-center">
			<form name="sampleForm" id="sampleForm" class="form-horizontal well" ng-submit="submit(formData, sampleForm.$valid);" novalidate>
				<div class="form-group" ng-class="{ 'has-error': sampleForm.fullName.$touched && sampleForm.fullName.$invalid }">
					<label for="firstName">First Name</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-bomb"></i>
						</div>
						<input type="text" id="firstName" name="firstName" class="form-control" placeholder="First Name" ng-model="formData.firstName" ng-minlength="2" ng-maxlength="32" ng-required="true" />
					</div>
					<div class="alert alert-danger" role="alert" ng-messages="sampleForm.password.$error" ng-if="sampleForm.password.$touched" ng-hide="sampleForm.password.$valid">
						<p ng-message="minlength">First name is too short.</p>
						<p ng-message="maxlength">First name is too long.</p>
						<p ng-message="required">Please enter your first name.</p>
					</div>
					<label for="lastName">Last Name</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-rocket"></i>
						</div>
						<input type="text" id="lastName" name="lastName" class="form-control" placeholder="Last Name" ng-model="formData.lastName" ng-minlength="2" ng-maxlength="32" ng-required="true" />
					</div>
					<div class="alert alert-danger" role="alert" ng-messages="sampleForm.password.$error" ng-if="sampleForm.password.$touched" ng-hide="sampleForm.password.$valid">
						<p ng-message="minlength">Last Name is too short.</p>
						<p ng-message="maxlength">Last Name is too long.</p>
						<p ng-message="required">Please enter your last name.</p>
					</div>
					<label for="phoneNumber">Phone Number</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-phone"></i>
						</div>
						<input type="text" id="phoneNumber" name="phoneNumber" class="form-control" placeholder="Phone Number" ng-model="formData.phoneNumber" ng-minlength="4" ng-maxlength="32" ng-required="true" />
					</div>
					<div class="alert alert-danger" role="alert" ng-messages="sampleForm.password.$error" ng-if="sampleForm.password.$touched" ng-hide="sampleForm.password.$valid">
						<p ng-message="minlength">Phone number is too short.</p>
						<p ng-message="maxlength">Phone number is too long.</p>
						<p ng-message="required">Please enter your phone number.</p>
					</div>
					<label for="email">Email</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-envelope"></i>
						</div>
						<input type="text" id="email" name="email" class="form-control" placeholder="Email" ng-model="formData.email" ng-minlength="4" ng-maxlength="32" ng-required="true" />
					</div>
					<div class="alert alert-danger" role="alert" ng-messages="sampleForm.email.$error" ng-if="sampleForm.email.$touched" ng-hide="sampleForm.email.$valid">
						<p ng-message="minlength">Email is too short.</p>
						<p ng-message="maxlength">email is too long.</p>
						<p ng-message="required">Please enter your email.</p>
					</div>
					<label for="password">Password</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-key"></i>
						</div>
						<input type="password" id="password" name="password" class="form-control" placeholder="Password" ng-model="formData.password" ng-minlength="4" ng-maxlength="32" ng-required="true" />
					</div>
					<div class="alert alert-danger" role="alert" ng-messages="sampleForm.password.$error" ng-if="sampleForm.password.$touched" ng-hide="sampleForm.password.$valid">
						<p ng-message="minlength">Password is too short.</p>
						<p ng-message="maxlength">Password is too long.</p>
						<p ng-message="required">Please enter your password.</p>
					</div>
					<button class="btn btn-lg btn-info" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Send</button>
					<hr />
			</form>
		</div> <!-- form group end -->
	</div> <!-- well text center end -->
</div> <!-- col-6-end -->
</div> <!-- row end -->