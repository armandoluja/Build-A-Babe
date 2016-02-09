<?php
include('API/embeddedLoginCheck.php');
?>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>Build-A-Babe</title>

		<link rel="stylesheet" type="text/css" href="https://bootswatch.com/cerulean/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="style/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="style/myprofilepage.css">
		<link rel="stylesheet" href="style/viewprofilepage.css" type="text/css">
		<link rel="stylesheet" href="style/myfont.css" type="text/css">
		<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="script/accountUtils.js"></script>
		<script type="text/javascript" src="script/cookie.js"></script>
		<script type="text/javascript" src="script/constants.js"></script>
		<script type="text/javascript" src="script/myProfilePage.js"></script>
		
	</head>
	<body>
		
		<div class="container">

		<?php
			include ("navbar.php");
		?>
		<div class="row">
			</br>
			</br>
		</div>
		
			<div class="row">
				<div class="col-sm-12">
					<div class="page-header">
						<h1 id="typography">My Profile</h1>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<div id="browse_users_panel" class="panel panel-default hoverable">
						<div class="panel-heading">
							<b>Browse other users</b>
						</div>
						<div class="panel-body">
							<div class="col-xs-4">
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div id="view_stared_users_panel" class="panel panel-default  hoverable">
						<div class="panel-heading">
							<b>View starred users</b>
						</div>
						<div class="panel-body">
							<div class="col-xs-4">
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div id="recently_viewed_panel" class="panel panel-default  hoverable">
						<div class="panel-heading">
							<b>Recently viewed users</b>
						</div>
						<div class="panel-body">
							<div class="col-xs-4">
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<div id="profile_pic_panel" class="panel panel-default  hoverable">
						<div class="panel-heading">
							<b>Change profile picture</b>
						</div>
						<div class="panel-body">
							<div class="col-xs-8 col-xs-offset-2">
								<div class="well">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div id="gallery_panel" class="panel panel-default  hoverable">
						<div class="panel-heading">
							<b>Manage gallery</b>
						</div>
						<div class="panel-body">
							<div class="col-xs-4">
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div id="preferences_panel" class="panel panel-default  hoverable">
						<div class="panel-heading">
							<b>Manage my preferences</b>
						</div>
						<div class="panel-body">
							<div class="col-xs-12">
								<ul class="list-group">
									<li class="list-group-item">
										Height: 4'11" - 5'2"
									</li>
									<li class="list-group-item">
										Favorite hair color: Blonde
									</li>
									<li class="list-group-item">
										...
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<div id="attributes_panel" class="panel panel-default  hoverable">
						<div class="panel-heading">
							<b>Manage my attributes</b>
						</div>
						<div class="panel-body">
							<div class="col-xs-12">
								<ul class="list-group">
									<li class="list-group-item">
										Height: 5'11"
									</li>
									<li class="list-group-item">
										Hair color: Blonde
									</li>
									<li class="list-group-item">
										...
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div id="chat_panel" class="panel panel-default  hoverable">
						<div class="panel-heading">
							<b>View conversations</b>
						</div>
						<div class="panel-body">
							<div class="col-xs-4">
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
								<div class="well well-sm">
									<img class="gallery-image" src="http://imgur.com/cucXLcU.png"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</body>
</html>