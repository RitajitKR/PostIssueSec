<?php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', 'MySQL');
   define('DB_DATABASE', 'postissue');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   if(!isset($_SESSION['count'])) $_SESSION['count'] = 0;

?>