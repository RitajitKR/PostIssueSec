<?php

include('session.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Issues</title>
	<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
	 <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="bootstrap-4.0.0-dist/css/bootstrap.min.css">

	<!-- jQuery library -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 -->
	<!-- Latest compiled JavaScript -->
	<script src="bootstrap-4.0.0-dist/js/bootstrap.min.js"></script> 
</head>
<body>
	<div style="height: 100%;width: 100%;padding: 5px;">
		<nav class="navbar navbar-dark bg-dark justify-content-between">
		  <a class="navbar-brand bg-light" style="padding: 5px;">Issue-notes posted</a>
		  <div class="addNew" data-toggle="modal" data-target="#myModal"><button class="btn btn-success" type="submit"> <i class="fa fa-plus" aria-hidden="true"></i> Add post <?php echo "".$_SESSION['login_user']; ?> ?</button></a>	</div>
		  	   
		    <a href="logout.php"><button class="btn btn-outline-danger my-2 my-sm-0" type="submit"><i class="fa fa-sign-out" aria-hidden="true"></i></button></a>
		  
		</nav>
		<div style="background-color: whitesmoke;width: 100%;padding: 5px;">
			<?php
				$sql = "SELECT pid, title, body, date,priority,poster FROM posts ORDER BY date";
				$result = mysqli_query($db, $sql);

				if (mysqli_num_rows($result) > 0) {
				    // output data of each row
				    while($row = mysqli_fetch_assoc($result)) {
				        //echo "pid: " . $row["pid"]. " - title: " . $row["title"]. " ". " - body: " . $row["body"]. "<br>";
				        $p=$row["priority"];
				        if ($p=="HIGH") $p="danger";
				        else if ($p=="MED") $p="warning";
				        else $p="primary";

				        $del="<form action='delpost.php' method='post'><input type='hidden' name='pid' value='".$row["pid"]."'><button class='btn btn-outline-danger my-2 my-sm-0' type='submit' style='margin-left:10px;float:right;'><i class='fa fa-trash-o'></i></button></form>";
				        if(!($row["poster"]==$_SESSION['login_user'])) $del=""; 
				        echo "<div class='card border-".$p." mb-3' style='width: 90%;'>
							  <div class='card-header bg-".$p." border-".$p."'><i>Due on</i>:".$row["date"]."</div>
							  <div class='card-body text-".$p."'>
							    <h5 class='card-title'>".$row["title"]." [ID:".$row["pid"]."]</h5>
							    <p class='card-text'>".$row["body"]."</p>
							  </div>
							  <div class='card-footer bg-transparent border-".$p."'><div style='float:left;'><i>Posted by</i>:".$row["poster"]."</div>".$del."</div>
							</div>";
				    }
				} else {
				    echo "0 results";
				}

			?>
		</div>
		<!-- Adding meds modal-->
        <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                  
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Adding New Issue Post:</h4><br>
                      
                      <button type="button" class="close" data-dismiss="modal" id="modalclose">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                            <form action="addpost.php" method="post">
                                <div class="form-group">
                                  <label for="title">Title:</label>
                                  <input type="text" class="form-control" name="title" autocomplete="off" required>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Due Date:</label>
                                    <input  class="form-control colorful" name="date" type="date" min="2018-10-11" required/>
                                </div>

                                <div class="form-group">
                                  <label for="body">Description:</label>
                                  <input type="text" class="form-control" name="body" autocomplete="off" required>
                                </div>

								<div class="form-group">
                                  <label for="priority">Priority:</label>
                                  <select name="priority">
									  <option value="LOW" selected="selected">Low</option>
									  <option value="MED">Medium</option>
									  <option value="HIGH">High</option>
									</select>
                                </div>                                    
                                
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                      <button type="submit" class="btn btn-primary" style="margin-left:auto;margin-right:auto;">Submit</button>
                              
                    </div>

                </form>
                    
                  </div>
                </div>
              </div>
              
	</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>