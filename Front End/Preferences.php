<html>
	<head>
		<script></script>
		<meta charset="UTF-8"/>
		<meta name = "viewport" content = "width=device-width,initial-scale=1" />
		<title></title>
		<link rel="stylesheet" type="text/css" href="https://bootswatch.com/cerulean/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="style/ProfileCharacteristics.css"/>
		<script type="text/javascript" src="script/Preferences.js"></script>
	</head>
	
	<body>
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
											<input type="radio" name="genderRadio" value="M" checked="checked">
											MALE</label>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="radio">
										<label>
											<input type="radio" name="genderRadio" value="F">
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
								<label class="col-sm-2 control-label">Hair Color</label>
								<div class="col-sm-10">
									<select name="hairColor" class="form-control" id="selectHairColor">
										<option name="hairColor" value="0">Black</option>
										<option name="hairColor" value="1">Brown</option>
										<option name="hairColor" value="2">Blonde</option>
										<option name="hairColor" value="3">Red</option>
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
									<input type="range" max="100" min="1" step="1" value="10" onmousemove="showValue(this.value)"/>
									<span id="maxDistRange">10</span>
								</div> 
								<script type="text/javascript">
									function showValue(newValue){
										document.getElementById("maxDistRange").innerHTML=newValue;
									}
								</script>
							</div>
							
							<div class="form-group">
								<div class="col-sm-10 col-sm-offset-2">
									<button type="reset" class="btn btn-default">
										Cancel
									</button>
									<button type="submit" class="btn btn-primary">
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