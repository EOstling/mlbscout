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
			<form name="signupForm" id="signupForm" class="form-horizontal well" ng-submit="createSignup(formData, signupForm.$valid);" novalidate>
				<div class="form-group" ng-class="{ 'has-error': signupForm.fullName.$touched && signupForm.fullName.$invalid }">
					<label for="userFirstName">First Name</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-bomb"></i>
						</div>
						<input type="text" id="userFirstName" name="userFirstName" class="form-control" placeholder="First Name" ng-model="formData.userFirstName" ng-minlength="2" ng-maxlength="32" ng-required="true" />
					</div>
					<div class="alert alert-danger" role="alert" ng-messages="signupForm.userPassword.$error" ng-if="signupForm.userPassword.$touched" ng-hide="signupForm.userPassword.$valid">
						<p ng-message="minlength">First name is too short.</p>
						<p ng-message="maxlength">First name is too long.</p>
						<p ng-message="required">Please enter your first name.</p>
					</div>
					<label for="userLastName">Last Name</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-rocket"></i>
						</div>
						<input type="text" id="userLastName" name="userLastName" class="form-control" placeholder="Last Name" ng-model="formData.userLastName" ng-minlength="2" ng-maxlength="32" ng-required="true" />
					</div>
					<div class="alert alert-danger" role="alert" ng-messages="signupForm.userPassword.$error" ng-if="signupForm.userPassword.$touched" ng-hide="signupForm.userPassword.$valid">
						<p ng-message="minlength">Last Name is too short.</p>
						<p ng-message="maxlength">Last Name is too long.</p>
						<p ng-message="required">Please enter your last name.</p>
					</div>
					<label for="userPhoneNumber">Phone Number</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-phone"></i>
						</div>
						<input type="text" id="userPhoneNumber" name="userPhoneNumber" class="form-control" placeholder="Phone Number" ng-model="formData.userPhoneNumber" ng-minlength="4" ng-maxlength="32" ng-required="true" />
					</div>
					<div class="alert alert-danger" role="alert" ng-messages="signupForm.userPassword.$error" ng-if="signupForm.userPassword.$touched" ng-hide="signupForm.userPassword.$valid">
						<p ng-message="minlength">Phone number is too short.</p>
						<p ng-message="maxlength">Phone number is too long.</p>
						<p ng-message="required">Please enter your phone number.</p>
					</div>
					<label for="email">Email</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-envelope"></i>
						</div>
						<input type="text" id="userEmail" name="userEmail" class="form-control" placeholder="Email" ng-model="formData.userEmail" ng-minlength="4" ng-maxlength="32" ng-required="true" />
					</div>
					<div class="alert alert-danger" role="alert" ng-messages="signupForm.userEmail.$error" ng-if="signupForm.userEmail.$touched" ng-hide="signupForm.email.$valid">
						<p ng-message="minlength">Email is too short.</p>
						<p ng-message="maxlength">email is too long.</p>
						<p ng-message="required">Please enter your email.</p>
					</div>
					<label for="userPassword">Password</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-key"></i>
						</div>
						<input type="password" id="userPassword" name="userPassword" class="form-control" placeholder="Password" ng-model="formData.userPassword" ng-minlength="4" ng-maxlength="32" ng-required="true" />
					</div>
					<div class="alert alert-danger" role="alert" ng-messages="signupForm.userPassword.$error" ng-if="signupForm.userPassword.$touched" ng-hide="signupForm.userPassword.$valid">
						<p ng-message="minlength">Password is too short.</p>
						<p ng-message="maxlength">Password is too long.</p>
						<p ng-message="required">Please enter your userPassword.</p>
					</div>
					<button class="btn btn-lg btn-info" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Send</button>
					<hr />
			</form>
		</div> <!-- form group end -->
	</div> <!-- well text center end -->
</div> <!-- col-6-end -->
</div> <!-- row end -->