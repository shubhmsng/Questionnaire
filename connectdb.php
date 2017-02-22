<?php
	$con=mysqli_connect("localhost","shubhmsng","shubhmsng","id354464_questionnaire");

	// Check connection
	if (mysqli_connect_errno($con))
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>