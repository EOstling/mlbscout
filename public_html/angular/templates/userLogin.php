<div class="row">
	<div class="col-xs-12">
		<div class="well text-center">
			<h1>User Login</h1>
		</div>
	</div>
</div>
<!-- main content-->
<div class="row">
	<div class="col-xs-12">
		<div class="well text-center">
			<form name="sampleForm" id="sampleForm" class="form-horizontal well" ng-controller="AngularFormController" ng-submit="submit(formData, sampleForm.$valid);" novalidate>
				<div class="form-group" ng-class="{ 'has-error': sampleForm.fullName.$touched && sampleForm.fullName.$invalid }">
					<label for="fullName">Full Name</label>
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
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-key"></i>
						</div>
						<input type="text" id="password" name="password" class="form-control" placeholder="Password" ng-model="formData.password" ng-minlength="4" ng-maxlength="32" ng-required="true" />
					</div>
					<div class="alert alert-danger" role="alert" ng-messages="sampleForm.password.$error" ng-if="sampleForm.password.$touched" ng-hide="sampleForm.password.$valid">
						<p ng-message="minlength">Password is too short.</p>
						<p ng-message="maxlength">Password is too long.</p>
						<p ng-message="required">Please enter your password.</p>
					</div>
					<button class="btn btn-lg btn-info" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Send</button>
					<button class="btn btn-lg btn-warning" type="reset" ng-click="reset();"><i class="fa fa-ban"></i>&nbsp;Reset</button>
					<hr />
			</form>
		</div>
	</div>
</div>
