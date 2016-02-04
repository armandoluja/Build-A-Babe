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
		<link rel="stylesheet" href="style/chat.css" type="text/css">
		<link rel="stylesheet" href="style/myfont.css" type="text/css">
		<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="script/accountUtils.js"></script>
		<script type="text/javascript" src="script/cookie.js"></script>
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
            <div class="list-group table-of-contents">
              <a class="list-group-item">Person 1</a>
              <a class="list-group-item">Person 2</a>
              <a class="list-group-item">Person 3</a>
              <a class="list-group-item">Person 4</a>
              <a class="list-group-item">Person 5</a>
            </div>
        </div>
		
		<div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading"><b>Person 1</b></div>
            <div class="panel-body">
                
                <div class="row">
                <div class="col-xs-10 col-xs-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    <h3 class="panel-title convo-you"><b>You</b></h3>
                    </div>
                    <div class="panel-body convo-you">
                        Hi Joe!
                    </div>
                    <div class="panel-body convo-you">
                        How are you?
                    </div>
                </div>
                </div>
                </div>
                
                
                <div class="row">
                <div class="col-xs-10">
                <div class="panel panel-default">
                <div class="panel-heading">
                <h3 class="panel-title"><b>Joe</b></h3>
                </div>
                <div class="panel-body">
                    Great! How about you?
                </div>
                </div>
                </div>
                </div>
                
                
                <div class="row">
                <div class="col-xs-12">
                <div class="input-group">
                    <input type="text" class="form-control">
                    <span class="input-group-btn">
                      <button class="btn btn-primary" type="button">Send</button>
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