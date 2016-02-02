<?php
include('API/embeddedLoginCheck.php');
?> 
<html>
	<head>
		<meta charset="UTF-8"/>
		<meta name = "viewport" content = "width=device-width,initial-scale=1" />
		<title>Build-A-Babe</title>
		<link rel="stylesheet" type="text/css" href="style/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="style/ProfileCharacteristics.css"/>
		<link rel="stylesheet" href="style/myfont.css" type="text/css">
		<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="script/accountUtils.js"></script>
		<script type="text/javascript" src="script/cookie.js"></script>
		<script type="text/javascript" src="script/constants.js"></script>
		<script type="text/javascript" src="script/preferences.js"></script>
	</head>
	
	<body>
		<?php
		include("navbar.php");
		?>
		<div class="row">
		</br>
		</br>
		</div>
		<div class="row">
		</br>
		</br>
		</div>
		<div class="container">
			<div class="row">
				
			</div>
			<div class="row">
			<div class = "col-sm-8 col-sm-offset-2">
				<div class = "well bs-component">
					<form class="form-horizontal">
						<fieldset>
							<legend>
								What are you looking for in a match?
							</legend>
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
								<label class="col-sm-2 control-label">Minimum Age</label>
								<div class="col-sm-10">
									<input id="inputMinAge" type="range" max="100" min="18" step="1" value="18" onmousemove="showMinAge(this.value)"/>
									<span id="minAge">18</span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Maximum Age</label>
								<div class="col-sm-10">
									<input id="inputMaxAge" type="range" max="100" min="18" step="1" value="22" onmousemove="showMaxAge(this.value)"/>
									<span id="maxAge">22</span>
								</div>
							</div>
						
							<div class="form-group">
								<label class="col-sm-2 control-label">Minimum Height</label>
								<div class="col-sm-10">
									<input id="inputMinHeight" type="range" max="96" min="36" step="1" value="36" onmousemove="showMinHeight(this.value)"/>
									<span id="minHeight">3' 0"</span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Maximum Height</label>
								<div class="col-sm-10">
									<input id="inputMaxHeight" type="range" max="96" min="36" step="1" value="96" onmousemove="showMaxHeight(this.value)"/>
									<span id="maxHeight">8' 0"</span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Favorite Hair Color</label>
								<div class="col-sm-10">
									<select name="hairColor_first" class="form-control" id="selectFirstHairColor">
										<option name="hairColor_first" value="0">Black</option>
										<option name="hairColor_first" value="1">Light Brown</option>
										<option name="hairColor_first" value="2">Dark Brown</option>
										<option name="hairColor_first" value="3">Blonde</option>
										<option name="hairColor_first" value="4">Red</option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Second Favorite Hair Color</label>
								<div class="col-sm-10">
									<select name="hairColor_second" class="form-control" id="selectSecondHairColor">
										<option name="hairColor_second" value="0">Black</option>
										<option name="hairColor_second" value="1">Light Brown</option>
										<option name="hairColor_second" value="2">Dark Brown</option>
										<option name="hairColor_second" value="3">Blonde</option>
										<option name="hairColor_second" value="4">Red</option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Least Favorite Hair Color</label>
								<div class="col-sm-10">
									<select name="hairColor_least" class="form-control" id="selectLeastHairColor">
										<option name="hairColor_least" value="0">Black</option>
										<option name="hairColor_least" value="1">Light Brown</option>
										<option name="hairColor_least" value="2">Dark Brown</option>
										<option name="hairColor_least" value="3">Blonde</option>
										<option name="hairColor_least" value="4">Red</option>
									</select>
								</div>
							</div>
							
							
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Favorite Eye Color</label>
								<div class="col-sm-10">
									<select name="eyeColor_1" class="form-control" id="selectEyeColor_1">
										<option name="eyeColor_1" value="0">Dark Brown</option>
										<option name="eyeColor_1" value="1">Light Brown</option>
										<option name="eyeColor_1" value="2">Blue</option>
										<option name="eyeColor_1" value="3">Green</option>
										<option name="eyeColor_1" value="4">Hazel</option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Second Favorite Eye Color</label>
								<div class="col-sm-10">
									<select name="eyeColor_2" class="form-control" id="selectEyeColor_2">
										<option name="eyeColor_2" value="0">Dark Brown</option>
										<option name="eyeColor_2" value="1">Light Brown</option>
										<option name="eyeColor_2" value="2">Blue</option>
										<option name="eyeColor_2" value="3">Green</option>
										<option name="eyeColor_2" value="4">Hazel</option>
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
										<div class="col-sm-2">
											<div class="radio">
												<label>
													<input type="radio" name="skinTone" value="10">
													<div class="skinColorOption" id="skin6">No Preference</div>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							
							
							<div class="form-group">
								<div class="col-sm-10 col-sm-offset-2">
									<button id="cancel_preference_btn" type="button" class="btn btn-default">
										Cancel
									</button>
									<button id="save_preference_btn" type="button" class="btn btn-primary">
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
	</body>
</html>