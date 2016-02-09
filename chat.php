<?php
include('API/embeddedLoginCheck.php');
?>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>Build-A-Babe</title>

		<link rel="stylesheet" type="text/css" href="./style/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="style/bootstrap.min.css">
		<link rel="stylesheet" href="style/chat.css" type="text/css">
		<link rel="stylesheet" href="style/myfont.css" type="text/css">
		<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
		<script src="./js/bootstrap.min.js"></script>
		<script type="text/javascript" src="script/chat.js"></script>
		<script type="text/javascript" src="script/cookie.js"></script>
		<script type="text/javascript" src="script/accountUtils.js"></script>
		<script type="text/javascript" src="script/constants.js"></script>
	</head>
	<body>
		
		<div class="container">

		<?php
			include ("navbar.php");
		?>
		<div class="row">
		</br>
		</br>
		</br>
		</br>
		</div>
		
		<div class="row">
		<div class="col-sm-4 col-sm-offset-1">
            <div class="list-group table-of-contents" id="peopleList">
            </div>
        </div>
		
		<div class="col-sm-6">
        <div class="panel panel-default" id="chatOuterPanel">
            <div class="panel-heading"><b><span id="chatWindowPersonName"></span></b></div>
            <div class="panel-body">
                <div id="chatWindow">
                </div>
				
                <div class="row">
                <div class="col-xs-12">
                <div class="input-group">
                    <input type="text" id="message_content" class="form-control">
                    <span class="input-group-btn">
                      <button class="btn btn-primary" id="send_message" type="button">Send</button>
                    </span>
                  </div>
                </div>
                 
                </div>
                
                
            </div>
        </div>
    </div>
		
		
		
		</div>
		
		
		
		</div>
	</body>
</html>