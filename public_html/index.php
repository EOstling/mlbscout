<?php
 require_once("php/partials/head-utils.php");
?>

<body class="sfooter">
	<div class="sfooter-content">

		<!-- insert header -->
		<?php require_once("php/partials/header.php");?>
		<main>
			<div class="container">

				<!-- angular view directive-->
				<div ng-view></div>

			</div>
		</main>
	</div><!--/.sfooter-content-->

	<!-- insert footer -->
	<?php require_once("php/partials/footer.php");?>
</body>