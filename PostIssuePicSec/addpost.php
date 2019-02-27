<?php
include("session.php");

$title = htmlspecialchars(mysqli_real_escape_string($db,$_POST["title"]));
$date = htmlspecialchars(mysqli_real_escape_string($db,$_POST["date"]));
$body = htmlspecialchars(mysqli_real_escape_string($db,$_POST["body"]));
$priority = htmlspecialchars(mysqli_real_escape_string($db,$_POST["priority"]));
$poster=htmlspecialchars(mysqli_real_escape_string($db,$_SESSION['login_user']));
$pid;
// Here, you can also perform some database query operations with above values.
$sql = "SELECT * FROM posts where title='$title'";
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0){
    //echo "same name";
    //header("Location: userlogin.php");
}
else{
    //add
    $sql = "SELECT pid FROM posts ORDER BY pid DESC LIMIT 1";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    $pid = (int)$row['pid'] + 1;
    //$sql2 = "INSERT INTO posts (pid,title,body,date,priority,poster) VALUES ('$pid','$title','$body','$date','$priority','$poster')";

    // Prepare an insert statement
    $sql = "INSERT INTO posts (pid,title,body,date,priority,poster) VALUES (?, ?, ?, ?, ?, ?)";
     
    if($stmt = mysqli_prepare($db, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "isssss", $pid, $title, $body, $date, $priority, $poster);
        
        /* Set the parameters values and execute
        the statement again to insert another row */
        
        mysqli_stmt_execute($stmt);
        
        //echo "Records inserted successfully.";
    } else{
        //echo "ERROR: Could not prepare query: $sql. " . mysqli_error($link);
    }
 
    // Close statement
    mysqli_stmt_close($stmt);
 


    // if (mysqli_query($db, $sql2)) {
    //     //echo "New record created successfully";
        
    // } else {
    //     //echo "Error: " . $sql2 . "<br>" . mysqli_error($db);
    // }
}
 // Success Message
header("Location: show.php");

?>