<?php
   include("config.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = htmlspecialchars(mysqli_real_escape_string($db,$_POST['username']));
      $mypassword = htmlspecialchars(mysqli_real_escape_string($db,$_POST['password'])); //secure
      // $myusername = $_POST['username'];
      // $mypassword = $_POST['password']; //insecure
      $numpts = htmlspecialchars(mysqli_real_escape_string($db,$_POST['numpts']));
      if($numpts>=3){
      
	      	$sql = "SELECT * FROM people where username='$myusername'";
			$result = mysqli_query($db, $sql);

			if (mysqli_num_rows($result) > 0){
			    //echo "same name";
			    $error="Username already exists.";
			    //header("Location: userlogin.php");
			}
			else{
			    //add
			    $sql = "SELECT uid FROM people ORDER BY uid DESC LIMIT 1";
			    $result = mysqli_query($db, $sql);
			    $row = mysqli_fetch_assoc($result);
			    $uid = (int)$row['uid'] + 1;
			    $adminity=0;
			    $locked=0;

			    $options = [
				    'cost' => 11,
				];
				// Get the password from post
				$passwordFromPost = $mypassword;

				$mypassword = password_hash($passwordFromPost, PASSWORD_BCRYPT, $options);
			    //insecre->
			    // $sql2 = "INSERT INTO people (uid,username,password,adminity,locked) VALUES ('$uid','$myusername','$mypassword','0','0')";
			    // if (mysqli_query($db, $sql2)) {
			    //     //echo "New record created successfully";
			    //     $error = "<p style='color:green;'>New record created successfully</p>";
			        
			    // } else {
			    //     //echo "Error: " . $sql2 . "<br>" . mysqli_error($db);
			    // }

			    //secured->
			    $sql = "INSERT INTO people (uid,username,password,adminity,locked) VALUES (?, ?, ?, ?, ?)";
     
			    if($stmt = mysqli_prepare($db, $sql)){
			        // Bind variables to the prepared statement as parameters
			        mysqli_stmt_bind_param($stmt, "issii", $uid,$myusername,$mypassword,$adminity,$locked);
			        
			        /* Set the parameters values and execute
			        the statement again to insert another row */
			        // $first_name = "Hermione";
			        // $last_name = "Granger";
			        // $email = "hermionegranger@mail.com";
			        mysqli_stmt_execute($stmt);
			        $error = "<p style='color:green;'>New record created successfully</p>";
			        //echo "Records inserted successfully.";
			    } else{
			        //echo "ERROR: Could not prepare query: $sql. " . mysqli_error($link);
			        $error = "<p style='color:red;'>Some problem. Retry.</p>";
			    }
			 
			    // Close statement
			    mysqli_stmt_close($stmt);


			}
		}
		else $error = "Atleast 3 points have to be selected";
   }
?>
<!DOCTYPE html>
<html>
<head>
	<title>PostIssue Sign-Up</title>
	<link rel="stylesheet" href="gateways.css">
	<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
	<style type="text/css">
		.img-holder {
			    
			    animation-name: example;
			    animation-duration: 1s;
			}
			/* Standard syntax */
			@keyframes example {
			    from {border-radius: 7px;    box-shadow: 0 0 50px lightgreen;}
			    to {border: 2px solid black;}
			}
			.point { cursor: url('cursor7big.cur'), auto;}
	</style>
	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script> 
	<script type="text/javascript">
		var passkey="";
		var numpts=0;
		var tries=0;
		var passkeyini="";
		function selectImage(image){
			document.getElementById('pointer_div').style.display="block";
			document.getElementById('passpic').src=image;
			
		}
		function point_it(event){
			
			document.getElementById("pointer_div").classList.toggle("img-holder");
			pos_x = event.offsetX?(event.offsetX):event.pageX-document.getElementById("pointer_div").offsetLeft;
			pos_y = event.offsetY?(event.offsetY):event.pageY-document.getElementById("pointer_div").offsetTop;
			// document.getElementById("cross").style.left = (pos_x-1) ;
			// document.getElementById("cross").style.top = (pos_y-15) ;
			// document.getElementById("cross").style.visibility = "visible" ;
			pos_x=(pos_x-(pos_x%15));
			pos_y=(pos_y-(pos_y%15));
			passkey=passkey+pos_x+","+pos_y+".";
			numpts=numpts+1;
			console.log(passkey);
			document.getElementById('password').value=passkey;
			document.getElementById('numpts').value=numpts;
			window.setTimeout(function(){
			  document.getElementById("pointer_div").classList.toggle("img-holder");
			}, 1000);
			//document.getElementById("pointer_div").style.borderColor = "green";
		}

		function check(){
			if(numpts>=3)
			{
				if(tries==0)
				{
					tries=tries+1;
					passkeyini=passkey;
					passkey="";
					numpts=0;
					alert("Tap secret sequence another time to confirm.");
				}
				else if(tries==1)
				{
					if(!(passkeyini==passkey))
					{
						passkey="";
						numpts=0;
						alert ("Two passwords didn't match. Try again.");
					}
					else document.getElementById("signupform").submit();
				}
			}
			else alert ("Fill Username and Tap '>=3' Points!");
		}
		
	</script>	
	</head>
<body style="background-color: whitesmoke;">

	<div id="myModal" class="modal" style="display: block;">
	<div class="modal-dialog modal-login">
		<div class="modal-content">
			<div class="modal-header" style="background-image: linear-gradient(to right, pink, skyblue);color: white;">				
				<h4 class="modal-title">Sign Up : Create Account</h4>
			</div>
			<div class="modal-body">
				<form action="" method="post" id="signupform">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<input class="form-control" name="username" placeholder="Username" required="required" type="text">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">Select password image-&nbsp<i class="fa fa-lock"></i>&nbsp-Tap secret points(>=3) in sequence</span>
							<input class="form-control" name="password" id="password" required="required" type="hidden">
							<input class="form-control" name="numpts" id="numpts"  required="required" type="hidden">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="hovereffect rounded float-left" onclick="selectImage('heros.jpg')" style="width: 120px;height: 70px;">
						        <img class="img-responsive" style="" src="heros.jpg"  alt="">
						        <div class="overlay">
						           <h4>Tap to choose</h4>
						        </div>
			    			</div>
			    			<div class="hovereffect rounded float-left" onclick="selectImage('tnj1.png')" style="width: 120px;height: 70px;">
						        <img class="img-responsive" style="" src="tnj1.png"  alt="">
						        <div class="overlay">
						           <h4>Tap to choose</h4>
						        </div>
			    			</div>
						</div>
						<div class="rounded point" style="width: 370px;height: 250px;margin:10px;border-style: solid; border-width: 2px;display:none;" id="pointer_div" onmousedown="point_it(event)">
					        <img class="img-responsive rounded" style="width: auto;  height : auto;  max-height: 100%;  max-width: 100%;" src="" id="passpic"  alt="">
					
					    </div>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-primary btn-block btn-lg" onclick="check()">Sign Up</button>
					</div>
					<div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php error_reporting(0); echo $error; ?></div>
				</form>
			</div>
			<!-- <div class="modal-footer">Don't have an account? <a href="#">Create one</a></div> -->
		</div>
	</div>
</div>


</body>
</html>