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
					<div class="dropdown">
						<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							Dropdown
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							<li><a href="#">L</a></li>
							<li><a href="#">R</a></li>
							<li><a href="#">S</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#">Separated link</a></li>
						</ul>
					</div>
					<h1></h1>
					<button class="btn btn-lg btn-info" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Update</button>
					<hr/>
			</form>
		</div>
	</div>
</div>
</div>