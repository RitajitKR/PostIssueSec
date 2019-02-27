<?php
   include("config.php");
   session_start();
   if(!isset($_SESSION['count'])) $_SESSION['count'] = 0;

   $flag=0;
   $button="";
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
	 
	 	if($_SESSION['count']=="3"){
	 		$error = "maximum attempts exceeded(".$_SESSION['count']." now). Close and reopen browser to login.";
	 		$button = "disabled";
	 	}
		    else{  
		      $myusername = mysqli_real_escape_string($db,$_POST['username']);
		      $mypassword = mysqli_real_escape_string($db,$_POST['password']); //secure
		      // $myusername = $_POST['username'];
		      // $mypassword = $_POST['password']; //insecure

		      $flag=0;
		      
		      // $sql = "SELECT id FROM admin WHERE username = '$myusername' and passcode = '$mypassword'"; //SEC
		      $sql = "SELECT password FROM people WHERE username = '$myusername'";
		      $result = mysqli_query($db,$sql);
		      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		      //$active = $row['active'];
		      
		      $count = mysqli_num_rows($result);
		      
		      // If result matched $myusername and $mypassword, table row must be 1 row
		      if($row){
		      	$passwordFromPost = $mypassword;
				$hashedPasswordFromDB = $row['password'];

				if (password_verify($passwordFromPost, $hashedPasswordFromDB)) {
				    //echo 'Password is valid!';
				    $flag=1;
				} else {
				    //echo 'Invalid password.';
				}
		      }
		      
		      if($flag==1) { //$count == 1
		         //session_register("myusername");
		         $_SESSION['login_user'] = $myusername;
		         $_SESSION['count'] = 0;
		         $button = "";
		         header("location: show.php");
		      }
		      else {
		         $error = "Your Login Name or Password is invalid";
		         
		         
		         	$counter = $_SESSION['count']; 
				    $counter = (int)$counter;
			        $counter++;
			        $_SESSION['count'] = $counter; 
			        if($_SESSION['count']=="3"){
				 		$error = "maximum attempts exceeded(".$_SESSION['count']." now). Close and reopen browser to login.";
				 		$button = "disabled";
				 	}
		         
		      }
		  }
	  
   }
?>
<!DOCTYPE html>
<html>
<head>
	<title>PostIssue Login</title>
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
			    from {border-radius: 7px;    box-shadow: 0 0 50px green;}
			    to {border: 2px solid black;}
			}
			.point { cursor: url('cursor7big.cur'), auto;}
	</style>
	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script> 
	<script type="text/javascript">
		var passkey="";
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
			console.log(passkey);
			document.getElementById('password').value=passkey;
			window.setTimeout(function(){
			  document.getElementById("pointer_div").classList.toggle("img-holder");
			}, 1000);
			//document.getElementById("pointer_div").style.borderColor = "green";
		}
		
	</script>	
	</head>
<body style="background-color: whitesmoke;">

	<div id="myModal" class="modal" style="display: block;">
	<div class="modal-dialog modal-login">
		<div class="modal-content">
			<div class="modal-header" style="background-image: linear-gradient(to right, lightgreen, skyblue);color: white;">				
				<h4 class="modal-title">Sign In: to your account</h4>
			</div>
			<div class="modal-body">
				<form action="" method="post">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<input class="form-control" name="username" placeholder="Username" required="required" type="text">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">Select password image-&nbsp<i class="fa fa-lock"></i>&nbsp-Tap secret points in sequence</span>
							<input class="form-control" name="password" id="password" placeholder="Password" required="required" type="hidden">
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
						<button type="submit" class="btn btn-primary btn-block btn-lg" <?php echo $button; ?> >Sign In</button>
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