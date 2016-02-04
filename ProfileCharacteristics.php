<?php
include ('API/embeddedLoginCheck.php');
?>
<html>
	<head>
		<meta charset="UTF-8"/>
		<meta name = "viewport" content = "width=device-width,initial-scale=1" />
		<title>Build-A-Babe</title>
		<link rel="stylesheet" type="text/css" href="style/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="style/ProfileCharacteristics.css"/>
		<link rel="stylesheet" href="style/myfont.css" type="text/css">
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
		</br>
		</br>
		</div>
			<div class="row">
			</div>
			<div class="row">
			<div class = "col-sm-8 col-sm-offset-2">
				<div class = "well bs-component">
					<div ng-app="appForm" ng-controller="ctrlName">
					<form name="profileCharForm" class="form-horizontal">
						<fieldset>
							<legend>
								Please fill out your characteristics.
							</legend>
							
							<div class="form-group">
								<span class="help-block"></span>
								<label class="col-sm-2 control-label">Name</label>
										<div class="col-sm-5">
											<input id="inputFirstName"  name="firstName"  ng-model="firstName" 
											type="text" placeholder="First" maxlength="16"  class="form-control" 
											valid-name></input>
											<span class="help-block" ng-show="profileCharForm.firstName.$touched && profileCharForm.firstName.$invalid">Invalid first name.</span>
										</div>
										<span class="help-block"></span>
										<div class="col-sm-5">
											<input id="inputLastName" name="lastName" ng-model="lastName" 
											type="text"  placeholder="Last" maxlength="16" class="form-control" 
											valid-name></input>
											<span class="help-block" ng-show="profileCharForm.lastName.$touched && profileCharForm.lastName.$invalid">Invalid last name.</span>
										</div>
								
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Birth Date</label>
								<div class="col-sm-3 col-sm-offset-0">
									<select name="bmonth" class="form-control" id="selectBirthMonth">
										<?php 
											for($i = 1 ; $i <= 12 ; $i++){
												$j = $i;
												if($i < 10){
													$j = "0".$i;
												}
												?>
												<option name="bmonth" value="<?= $j ?>"><?= $i ?></option>
												<?php
												}
										?>
									</select>
									<span class="help-block">MM</span>
								</div>
								<div class="col-sm-3">
									<select name="bday" class="form-control" id="selectBirthDay">
										<?php 
											for($i = 1 ; $i <= 31 ; $i++){
												$j = $i;
												if($i < 10){
													$j = "0".$i;
												}
												?>
												<option name = "bday" value="<?= $j ?>"><?= $i ?></option>
												<?php
												}
										?>
									</select>
									<span class="help-block">DD</span>
								</div>
								<div class="col-sm-3">
									<select name="byear" class="form-control" id="selectBirthYear">
										<?php 
											for($i = 1960 ; $i <= 2000 ; $i++){
												?>
												<option name = "byear" value="<?= $i ?>"><?= $i ?></option>
												<?php
												}
										?>
							
									</select>
									<span class="help-block">YYYY</span>
								</div>
							</div>
							
							
							<div class="form-group">
								<label class="col-lg-2 control-label">Bio</label>
								<div class="col-lg-10"  >
									<span class="help-block">Say something about yourself.</span>
									<textarea name="bio" ng-model="bio" class="form-control" rows="3" id="textArea"
									valid-bio></textarea>
									<span ng-show="profileCharForm.bio.$invalid">Too long!</span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Gender</label>
								<div class="col-sm-3">
									<div class="radio">
										<label>
											<input id="radio_male" type="radio" name="genderRadio" value="M" checked="checked">
											MALE</label>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="radio">
										<label>
											<input id="radio_female" type="radio" name="genderRadio" value="F">
											FEMALE</label>
									</div>
								</div>
								
									
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Height</label>
								<div class="col-sm-10">
									<input id="inputHeight" type="range" max="96" min="36" step="1" value="66" onmousemove="showHeight(this.value)"/>
									<span id="height">5' 6"</span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Hair Color</label>
								<div class="col-sm-10">
									<select name="hairColor" class="form-control" id="selectHairColor">
										<option name="hairColor" value="0">Black</option>
										<option name="hairColor" value="1">Light Brown</option>
										<option name="hairColor" value="2">Dark Brown</option>
										<option name="hairColor" value="3">Blonde</option>
										<option name="hairColor" value="4">Red</option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Eye Color</label>
								<div class="col-sm-10">
									<select name="eyeColor" class="form-control" id="selectEyeColor">
										<option name="eyeColor" value="0">Dark Brown</option>
										<option name="eyeColor" value="1">Light Brown</option>
										<option name="eyeColor" value="2">Blue</option>
										<option name="eyeColor" value="3">Green</option>
										<option name="eyeColor" value="4">Hazel</option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Body Type</label>
								<div class="col-sm-10">
									<select name="bodyType" class="form-control" id="selectBodyType">
										<option name="bodyType" value="0">Skinny</option>
										<option name="bodyType" value="1">Fit</option>
										<option name="bodyType" value="2">Athletic</option>
										<option name="bodyType" value="3">Curvy</option>
										<option name="bodyType" value="4">Fat</option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Skin Tone</label>
								<div class="col-sm-9">
									<div class="row">
										<div class="col-sm-2">
											<div class="radio">
												<label>
													<input type="radio" name="skinTone" value="0" checked="checked">
													<div class="skinColorOption" id="skin0"></div>
												</label>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="radio">
												<label>
													<input type="radio" name="skinTone" value="1">
													<div class="skinColorOption" id="skin1"></div>
												</label>
											</div>
										</div>
										
										<div class="col-sm-2">
											<div class="radio">
												<label>
													<input type="radio" name="skinTone" value="2">
													<div class="skinColorOption" id="skin2"></div>
												</label>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="radio">
												<label>
													<input type="radio" name="skinTone" value="3">
													<div class="skinColorOption" id="skin3"></div>
												</label>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="radio">
												<label>
													<input type="radio" name="skinTone" value="4">
													<div class="skinColorOption" id="skin4"></div>
												</label>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="radio">
												<label>
													<input type="radio" name="skinTone" value="5">
													<div class="skinColorOption" id="skin5"></div>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Maximum Search Distance (mi)</label>
								<div class="col-sm-10">
									<input id="maxDistInput" type="range" max="100" min="1" step="1" value="10" onmousemove="showMaxDist(this.value)"/>
									<span id="maxDistRange">10</span>
								</div> 
							</div>
							
							<div class="form-group">
								<div class="col-sm-10 col-sm-offset-2">
									<button id="cancel_prof_chars" type="reset" class="btn btn-default">
										Cancel
									</button>
									<button id="save_prof_chars" type="button" class="btn btn-primary">
										Save
									</button>
								</div>
							</div>
							
						</fieldset>
					</form>
					</div>
				</div>
			</div>
		</div>
		</div>
		<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
		<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="script/accountUtils.js"></script>
		<script type="text/javascript" src="script/cookie.js"></script>
		<script type="text/javascript" src="script/constants.js"></script>
		<script type="text/javascript" src="script/profileCharacteristics.js"></script>
	</body>
</html>