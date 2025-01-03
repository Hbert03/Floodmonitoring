<!doctype html>
<html lang="en" >

<head>
<title>Smart Water Level Alert</title>
<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
<link rel="icon" type="image/x-icon" href="assets/river.png">
<link rel="stylesheet" href="../style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>

<body>


<div class="shadow navbar nav bg-light  text-dark px-2 py-0" > 
    <!-- <img src="assets/logo.jpg" alt="Tambulig Logo" width="100px"> -->
    <h3>Aurora MDRRMO Flood Alert and Monitoring System</h3> 
    <div class="d-flex align-items-center justify-content-center ">
      <svg xmlns="http://www.w3.org/2000/svg" height="42px" viewBox="0 -960 960 960" width="42px" fill="#1f1f1f"><path d="m612-292 56-56-148-148v-184h-80v216l172 172ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-400Zm0 320q133 0 226.5-93.5T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160Z"/></svg>
      <p id="clock"></p>
    </div>
</div> 

<div class="container w-100 d-flex justify-content-center">
  <div class="card bg-white text-black shadow w-50 py-2 px-4 mt-5">
    <h1 class="text-center mt-4">LOGIN</h1>
    <div class="my-1"></div>
    <h5 class="text-center">Please enter your username and password</h5>

    <div class="my-2 mt-3">
      <label>Username</label>
      <input
      type="text"
      name="username"
      id="username"
      class="form-control p-2 shadow bg-white text-dark"
      placeholder="Username"
      value=""
      />
    </div>
    
    <div class="my-2">
    <label>Password</label>
    <input
    type="password"
    name="password"
    id="password"
    class="form-control p-2 shadow bg-white text-dark"
    placeholder="Password"
    value=""
  />
  </div>  
  
    <button class=" btn bg-success p-2 my-3 text-white" id="btn_login">Login</button>
    <a href="http://localhost/signup" target="_blank" rel="noopener noreferrer" ><h6 class="text-light ">Sign up</h6></a>
    <a href="http://localhost/forgot_password" target="_blank" rel="noopener noreferrer">Forgot password?</a>
  </div>

  
</div>
</body>
<script src="assets/js/jquery-3.6.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script>
    $(document).ready(()=>{

        const myTimeout = setInterval(()=>{
            document.getElementById("clock").innerHTML =  new Date();
        }, 1000);
        $("#btn_login").click(()=>{
          var username = $("#username").val();
          var password = $("#password").val();
          $.post("../ajax.php",{action:"login",username:username,password:password},(loginResponse)=>{
            if (loginResponse.includes("OK")) {
              alert("Successfully logged in! redirecting...");
                window.location.href = "https://localhost/wateralert/homepage/screens/dashboard.php";
                  <?php
                    session_start();
                    $_SESSION["isLoggedin"] = true;
                    ?>
            }
            else{
              alert("USER NOT FOUND!");
            }
        
          });
        });
    });
</script>
</html>