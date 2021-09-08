<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="favi.ico" type="image/ico">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.loader {
  border: 16px solid #0bdb2d;
  border-radius: 12px;

  
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;

    position: fixed;
    top: 50%;
    left: 45%;
}
body{ background-color: black; }
.alert {
  padding: 20px;
  background-color: green;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
</head>
<body>
<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <H1><strong>You have successfully logged in</strong></H1>
</div>



<div class="loader"></div>
<?php 
  header( "refresh:3; url=m.php" ); 
?>

</body>
</html>
