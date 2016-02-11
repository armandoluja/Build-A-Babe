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
        <script type="text/javascript" src="script/imageUtils.js"></script>
		<script type="text/javascript" src="script/browse.js"></script>
	</head>
	<body>
		<div class="container">

			<?php
			include ("navbar.php");
			?>
			<div class="row">
				<div id="browse_header_container">
					</br>
					</br>
					<div class="col-sm-12">
						<div class="page-header">
							<h1 id="page_header_text">Browse</h1>
						</div>
					</div>
				</div>

				<div id="quick_view_button_container" style="display: none">
					</br>
					</br>
					</br>
					</br>
					<div class="btn-group btn-group-justified">
						<a id="back_to_results_button" href="#" class="btn btn-default">Back to results</a>
						<a id="view_full_profile_button" href="#" class="btn btn-default">View full profile</a>
					</div>
				</div>
			</div>
			<div class="row" id="browse_container">
				
				
			</div>

			<div class="row" id="quick_view_profile_container" style="display: none">

				<div class="col-sm-12">
					<div class="page-header">
						<h1 id="full_name"></h1>
					</div>
				</div>

				<div class="col-sm-4">
					<div class="well">
						<img id="view_profile_pic" class="profile-image" src="http://imgur.com/cucXLcU.png"/>
					</div>
				</div>

				<div class="col-sm-8">
					<div class="panel panel-default">
						<div class="panel-heading">
							<b>Bio</b>
						</div>
						<div class="panel-body"  id="view_profile_bio"></div>
					</div>
				</div>

				<div class="col-sm-8">
					<div class="panel panel-default">
						<div class="panel-heading">
							<b>Profile Info:</b>
						</div>
						<div class="panel-body">
							<ul class="list-group">
								<li id="view_profile_age" class="list-group-item">
									Age: 23
								</li>
								<li id="view_profile_height" class="list-group-item">
									Height: 5'11"
								</li>
								<li id="view_profile_hair_color" class="list-group-item">
									Hair Color: Brown
								</li>
							</ul>
						</div>
					</div>
				</div>

			</div>
		</div>
	</body>
</html>