<div class="row">
	<div class="col-xs-12">
		<div class="well text-center">
			<h1>Contact Us</h1>
		</div>
	</div>
</div>
<!-- main content-->
<div class="row">
	<div class="col-xs-12">
		<div class="well text-center">
			<!--Begin Contact Form-->
			<form name="sampleForm" id="sampleForm" class="form-horizontal well" ng-controller="AngularFormController" ng-submit="submit(formData, sampleForm.$valid);" novalidate>
				<h3>Important Form</h3>
				<div class="form-group" ng-class="{ 'has-error': sampleForm.fullName.$touched && sampleForm.fullName.$invalid }">
					<label for="fullName">Full Name</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-user"></i>
						</div>
						<input type="text" id="fullName" name="fullName" class="form-control" ng-model="formData.fullName" ng-minlength="4" ng-maxlength="32" ng-required="true" />
					</div>
					<div class="alert alert-danger" role="alert" ng-messages="sampleForm.fullName.$error" ng-if="sampleForm.fullName.$touched" ng-hide="sampleForm.fullName.$valid">
						<p ng-message="minlength">Name is too short.</p>
						<p ng-message="maxlength">Name is too long.</p>
						<p ng-message="required">Please enter your name.</p>
					</div>
					<label for="fullName">Email</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-envelope"></i>
						</div>
						<input type="text" id="email" name="email" class="form-control" ng-model="formData.email" ng-minlength="4" ng-maxlength="32" ng-required="true" />
					</div>
					<div class="alert alert-danger" role="alert" ng-messages="sampleForm.email.$error" ng-if="sampleForm.email.$touched" ng-hide="sampleForm.email.$valid">
						<p ng-message="minlength">Email is too short.</p>
						<p ng-message="maxlength">Email is too long.</p>
						<p ng-message="required">Please enter your email.</p>
					</div>
					<label for="fullName">Subject</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-pencil"></i>
						</div>
						<input type="text" id="subject" name="subject" class="form-control" placeholder="Subject" ng-model="formData.subject" ng-minlength="4" ng-maxlength="32" ng-required="true" />
					</div>
					<label for="fullName">Message</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-comment"></i>
						</div>
						<input type="text" id="message" name="message" class="form-control" ng-model="formData.message" ng-minlength="4" ng-maxlength="2000" ng-required="true" />
					</div>
					<div class="alert alert-danger" role="alert" ng-messages="sampleForm.message.$error" ng-if="sampleForm.message.$touched" ng-hide="sampleForm.message.$valid">
						<p ng-message="minlength">Message is too short.</p>
						<p ng-message="maxlength">Message is too long.</p>
						<p ng-message="required">Please enter your message.</p>
					</div>
					<button class="btn btn-lg btn-info" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Send</button>
					<button class="btn btn-lg btn-warning" type="reset" ng-click="reset();"><i class="fa fa-ban"></i>&nbsp;Reset</button>
					<hr />
			</form>
		</div>
	</div>
</div>
