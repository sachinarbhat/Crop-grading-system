<?php
require_once "config.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
// define variables and set to empty values
$firstnameErr = $lastnameErr = $emailErr = $issuesErr = "";
$firstname = $lastname = $email = $issues = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["firstname"])) {
    $firstnameErr = "First Name is required";
  } else {
    $firstname = trim($_POST["firstname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$firstname)) {
      $firstnameErr = "Only letters and white space allowed";
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = trim($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
    

  if (empty($_POST["issues"])) {
    $issues = "";
  } else {
    $issues = trim($_POST["issues"]);
  }
  $lastname=trim($_POST["lastname"]);
}
date_default_timezone_set('Asia/Kolkata');
$dt=date("d/m/Y  h:ia");
$sql = "INSERT INTO problems (firstname, lastname, email, issues, datetime) VALUES (?, ?, ?, ?, ?)";


        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_firstname, $param_lastname, $param_email, $param_issues, $param_dt);
          
            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_email=$email;
            $param_issues=$issues;
            $param_dt=$dt;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: m.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

mysqli_close($link);
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Suggestions</title>
  <link rel="icon" href="favi.ico" type="image/ico">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

input[type=text], textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}

input[type=submit] {
  background-color: green;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

    li input[type=button]{ float: right; }
    li a{ color: white; text-align: center; padding: 15px;
    display: block; text-decoration: none; float: left; }
    ul{ background-color: #333333;
        
    list-style-type: none;overflow: hidden; margin:0px; padding:0px; position: -webkit-sticky;
  position: sticky;
  top: 0;}
  
    li a:hover{ background-color: green; }
</style>
</head>
<body>
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

<h3>Give your suggestions here!!</h3>

<div class="container">
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" name="con">
    <label for="firstname">First Name</label>
    <input type="text" id="firstname" name="firstname" placeholder="Your name" required>


    <label for="lastname">Last Name</label>
    <input type="text" id="lname" name="lastname"  placeholder="Your last name">

    <label for="email">Email adderess</label>
    <input type="text" name="email" required>


    <label for="issues">Issues </label>
    <textarea id="subject" name="issues" value="<?php echo $issues; ?>" placeholder="Please write the issue" style="height:200px" required></textarea>

    <input type="submit" onclick="msg()" value="Submit">
  </form>
</div>
<script>
function msg() {
  var fir = document.forms["con"]["firstname"].value.length;
  var em = document.forms["con"]["email"].value.length;
  var issu = document.forms["con"]["issues"].value.length;
  if((fir>0)&&(em>0)&&(issu>0))
  {
    alert("Thank you! your response has been submited");
  }
}
</script>

</body>
</html>
