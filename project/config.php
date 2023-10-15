<?php
	$servername="localhost";
	$username="root";
	$password="";
	$database="we_onlinedb";
				
	$conn = mysqli_connect($servername,$username,$password,$database);
	
	if($conn->connect_error){
		die("Connection failed:".$mysqli->connect_error);
	}
	
	
?>