<?php
include ('API/embeddedLoginCheck.php');
?>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>Build-A-Babe</title>

		<link rel="stylesheet" type="text/css" href="https://bootswatch.com/cerulean/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="style/bootstrap.min.css">
		<link rel="stylesheet" href="style/viewprofilepage.css" type="text/css">
		<link rel="stylesheet" href="style/myfont.css" type="text/css">
		<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="script/accountUtils.js"></script>
		<script type="text/javascript" src="script/cookie.js"></script>
		<script type="text/javascript" src="script/constants.js"></script>
	</head>
	<body>
		<div class="container" >

			<?php
			include ("navbar.php");
			?>
			<div class="row">
				</br>
				</br>
				<div class="col-sm-12">
					<div class="page-header">
						<h1 id="typography">Browse</h1>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="col-xs-3">

						<div class="well well-sm">
							<div class="panel-heading">
								<b>Find users</b>
							</div>
							<img class="gallery-image" src="http://imgur.com/cucXLcU.png">
						</div>
					</div>
					<div class="col-xs-3">
						<div class="well well-sm">
							<img class="gallery-image" src="http://imgur.com/cucXLcU.png">
						</div>
					</div>
					<div class="col-xs-3">
						<div class="well well-sm">
							<img class="gallery-image" src="http://imgur.com/cucXLcU.png">
						</div>
					</div>
					<div class="col-xs-3">
						<div class="well well-sm">
							<img class="gallery-image" src="http://imgur.com/cucXLcU.png">
						</div>
					</div>
				</div>

			</div>

		</div>
	</body>
</html>