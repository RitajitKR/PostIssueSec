<?php
include("session.php");
$pid=$_POST["pid"];

$sql = "SELECT poster FROM posts where pid='$pid'";
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0)
{
	$row = mysqli_fetch_assoc($result);
	if($row["poster"]==$_SESSION['login_user'])
	{
		$sql = "DELETE FROM posts WHERE pid=$pid";

		if (mysqli_query($db, $sql)) {
		    //echo "Record deleted successfully";
		} else {
		    //echo "Error deleting record: " . $conn->error;
		}

	}
	//else echo "you didnt create. so not allowed to delete";
}


header("Location: show.php");
?>