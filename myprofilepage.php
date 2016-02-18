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
					<div id="profile_pic_panel" class="panel panel-default  hoverable">
						<div class="panel-heading">
							<b>Change profile picture</b>
						</div>
						<div class="panel-body">
							<div class="col-xs-8 col-xs-offset-2">
								<div class="well">
									<img id="profile_picture" class="gallery-image" src="http://i.imgur.com/j9u2WtH.gif"/>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div id="view_saved_users_panel" class="panel panel-default  hoverable">
						<div class="panel-heading">
							<b>View saved users</b>
						</div>
						<div class="panel-body">
                            
                            <div class="row">
                                <div class="col-xs-4">
								    <div class="well well-sm">
									   <img id="savedUserImage1" class="gallery-image" src="http://i.imgur.com/j9u2WtH.gif"/>
								    </div>
							     </div>
                                <div class="col-xs-4">
								    <div class="well well-sm">
									   <img id="savedUserImage2" class="gallery-image" src="http://i.imgur.com/j9u2WtH.gif"/>
								    </div>
							     </div>
                                <div class="col-xs-4">
								    <div class="well well-sm">
									   <img id="savedUserImage3" class="gallery-image" src="http://i.imgur.com/j9u2WtH.gif"/>
								    </div>
							     </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
								    <div class="well well-sm">
									   <img id="savedUserImage4" class="gallery-image" src="http://i.imgur.com/j9u2WtH.gif"/>
								    </div>
							     </div>
                                <div class="col-xs-4">
								    <div class="well well-sm">
									   <img id="savedUserImage5" class="gallery-image" src="http://i.imgur.com/j9u2WtH.gif"/>
								    </div>
							     </div>
                                <div class="col-xs-4">
								    <div class="well well-sm">
									   <img id="savedUserImage6" class="gallery-image" src="http://i.imgur.com/j9u2WtH.gif"/>
								    </div>
							     </div>
                                
                            </div>
                            
						</div>
					</div>
				</div>
                
                <div class="col-sm-4">
					<div id="view_saved_users_panel" class="panel panel-default  hoverable">
						<div class="panel-heading">
							<b>Recently viewed users</b>
						</div>
						<div class="panel-body">
                            
                            <div class="row">
                                <div class="col-xs-4">
								    <div class="well well-sm">
									   <img id="viewedUserImage1" class="gallery-image" src="http://i.imgur.com/j9u2WtH.gif"/>
								    </div>
							     </div>
                                <div class="col-xs-4">
								    <div class="well well-sm">
									   <img id="viewedUserImage2" class="gallery-image" src="http://i.imgur.com/j9u2WtH.gif"/>
								    </div>
							     </div>
                                <div class="col-xs-4">
								    <div class="well well-sm">
									   <img id="viewedUserImage3" class="gallery-image" src="http://i.imgur.com/j9u2WtH.gif"/>
								    </div>
							     </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
								    <div class="well well-sm">
									   <img id="viewedUserImage4" class="gallery-image" src="http://i.imgur.com/j9u2WtH.gif"/>
								    </div>
							     </div>
                                <div class="col-xs-4">
								    <div class="well well-sm">
									   <img id="viewedUserImage5" class="gallery-image" src="http://i.imgur.com/j9u2WtH.gif"/>
								    </div>
							     </div>
                                <div class="col-xs-4">
								    <div class="well well-sm">
									   <img id="viewedUserImage6" class="gallery-image" src="http://i.imgur.com/j9u2WtH.gif"/>
								    </div>
							     </div>
                                
                            </div>
                            
						</div>
					</div>
				</div>
                
                
                
			</div>

			<form id="uploadimage" action="" method="post" enctype="multipart/form-data" style="display: none;">
				<input type="file" name="file" id="profile_picture_upload_input" style="display: none;" />
			</form>

			<div class="row">
				<div class="col-sm-4">
                    <div id="attributes_panel" class="well hoverable">
                        <b>Manage my attributes</b>
                    </div>
				</div>
                <div class="col-sm-4">
                    <div id="preferences_panel" class="well hoverable">
                        <b>Manage my preferences</b>
                    </div>
                </div>
			</div>

		</div>
	</body>
</html>