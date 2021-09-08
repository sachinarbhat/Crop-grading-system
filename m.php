<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>
		HOME
  </title>
  <link rel="icon" href="favi.ico" type="image/ico">
<style >
	body, html {
  height: 100%;
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

		li input[type=button]{ float: right; }
		li a{ color: white; text-align: center; padding: 15px;
		display: block; text-decoration: none; float: left; }
		ul{ background-color: rgb(0,0,0); background-color:	rgba(0,0,0,1);/* Fallback color */
        
		list-style-type: none;overflow: hidden; margin:0px; padding:0px;}
  
		li a:hover{ background-color: green; }


.im {
  /* The image used */
  
  background-image: url("mango.jpg");
  /* Add the blur effect */
  filter: blur(8px);
  webkit-filter: blur(8px);
  
  /* Full height */
  height: 100%; 
  
  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
.tex {
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
  color: white;
  font-weight: bold;
  border: 3px solid #f1f1f1;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 2;
  width: 80%;
  padding: 20px;
  text-align: center;
}
.btn {
  background-color: #0059b3;
  border: none;
  border-radius: 6px;
  color: white;
  padding: 16px 32px;
  text-align: center;
  font-size: 16px;

  opacity: 1;
  transition: 0.3s;
}

.btn:hover {opacity: 0.7}
</style>

</head>
<body>

	<form name="Home_page">
<ul>
	<li>
		<a href="m.php">HOME</a>
	</li>
	<li>
		<a href="instruction.html">INSTRUCTION</a>
	</li>
	<li>
		<a href="about.html">GRADE TYPES</a>
	</li>
	<li>
		<a href="contact.php">SUGGESTION</a>
	</li>

		<li>
<input type="button" onclick="location.href='logout.php';" value="Log out" />
	</li>

</ul>
</form>
<div class="im"> </div>
	<div class="tex">
		<h1 style="font-size:50px"><b>Welcome to our application</b></h1>
        <p>Click the below button to check your crop grade</p>
		<input type="button" id="myFile" class="btn" onclick="location.href='http://127.0.0.1:5000/'" value="Go for it">
</div>

</body> 
</html>