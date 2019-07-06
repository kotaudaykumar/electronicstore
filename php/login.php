<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../css/style.css" rel="stylesheet" />
<link href="../css/bootstrap.min.css" rel="stylesheet" />
<link href="../css/jquery.bxslider.css" rel="stylesheet" />
<link href="../css/css_animation.css" rel="stylesheet">
<title>Untitled Document</title>
<!--[if lt IE 9]>
    <script src="../js/html5shiv.js"></script>
  <![endif]-->
</head>
<body>
<div id="loading"></div>
<section class="title">
  <h3><a href="../index.html">Electronic Store<span id="tagline">Your Stores.Your Place.</span></a></h3>
</section>
<header>
  <nav id='cssmenu'>
    <div class="logo"><a href="../index.html">Electronic Store<span id="tagliner">Your Stores.Your Place.</span></a></div>
    <div id="head-mobile"></div>
    <div class="button"></div>
    <ul>
      <li><a href="../index.html">HOME</a></li>
      <li><a href="#">PRODUCTS</a>
        <ul>
          <li><a href="../products_mobile.html">MOBILE</a> </li>
          <li><a href="../products_tv.html">TELEVISION</a> </li>
          <li><a href="../product-dlsr.html">DLSR</a>
        </ul>
      </li>
      <li><a href="../about_us.html">ABOUT&nbsp;US</a></li>
      <li><a href="#">PROFILE</a>
        <ul>
          <li><a href="register.php">SIGN&nbsp;UP</a> </li>
          <li><a href="login.php">SIGN&nbsp;IN</a> </li>
        </ul>
      </li>
      <li><a href="../contact_us.html">VIDEO</a></li>
      <li><a href="../faqs.html">FAQ</a></li>
      <li><a href="../index_mail.html">MAIL&nbsp;US</a></li>
    </ul>
  </nav>
</header>
<section class="signup_section">
  <p class="signup_header animated finite bounceIn delay-5s"><img src="../images/line.png" width="100" height="10" alt="line" class="signup_line">Sign&nbsp;In<img src="../images/line.png" width="100" height="10" alt="line" class="signup_line"></p>
  <div class="signup_form">
    <p class="create">Sign&nbsp;In <span class="tagline_signup">Please&nbsp;Enter&nbsp;Your&nbsp;Details</span></p>
    <form class="main_signup_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <input type="text" name="username" class="password" placeholder="Username" value="<?php echo $username; ?>">
      <span class="help-block"><?php echo $username_err; ?></span>
      <input type="password" name="password" class="password" placeholder="Password">
      <span class="help-block"><?php echo $password_err; ?></span>
      <input type="submit" class="signup_button" value="Login">
      <p id="dontac">Don't have an account?<a href="register.php">Sign up now</a>.</p>
    </form>
  </div>
</section>
<section class="section_nine">
  <div class="news_letter">
    <div class="matter">
      <p class="news_letters">Newsletter<span class="news_tagline">News&nbsp;letter&nbsp;from&nbsp;others&nbsp;that&nbsp;can&nbsp;Improve&nbsp;our&nbsp;Services</span></p>
      <form class="box_search">
        <input type="text" placeholder="Email" name="search" class="box"/>
        <input type="submit" value="submit" name="submit_here" class="submit_box" />
      </form>
    </div>
  </div>
  <div class="last_information">
    <div class="contact">
      <p class="contact_header">CONTACT</p>
      <p class="contact_matter">The Communication Address</p>
      <div class="address_colony"><img src="../images/address.png" width="30" height="30" alt="address" />
        <p class="nagole">New Nagole,Hyderabad,PIN:500035</p>
      </div>
      <div class="email_id"><img src="../images/email.png" width="30" height="30" alt="email" />
        <p class="namew">kotauday95@gmail.com</p>
      </div>
      <div class="mobile_number"><img src="../images/phone.png" width="30" height="30" alt="phone" />
        <p class="cont_number">8500145012</p>
      </div>
    </div>
    <div class="information">
      <p class="info_header">INFORMATION</p>
      <ul class="informationr">
        <li><a href="../about_us.html"><img src="../images/last_arrow.png" width="13" height="6" alt="arrow" />
          <p>About&nbsp;Us</p>
          </a></li>
        <li><a href="../index_mail.html"><img src="../images/last_arrow.png" width="13" height="6" alt="arrow" />
          <p>Mail&nbsp;Us</p>
          </a></li>
        <li><a href="../faqs.html"><img src="../images/last_arrow.png" width="13" height="6" alt="arrow" />
          <p>FAQ's</p>
          </a></li>
      </ul>
    </div>
    <div class="category">
      <p class="cat_header">CATEGORY</p>
      <ul class="categoryr">
        <li><a href="../products_mobile.html"><img src="../images/last_arrow.png" width="13" height="6" alt="arrow" />
          <p>Mobiles</p>
          </a></li>
        <li><a href="../products_tv.html"><img src="../images/last_arrow.png" width="13" height="6" alt="arrow" />
          <p>Televisions</p>
          </a></li>
        <li><a href="../product-dlsr.html"><img src="../images/last_arrow.png" width="13" height="6" alt="arrow" />
          <p>DLSR</p>
          </a></li>
      </ul>
    </div>
    <div class="profile">
      <p class="profile_header">PROFILE</p>
      <ul class="profiler">
        <li><a href="../index.html"><img src="../images/last_arrow.png" width="13" height="6" alt="arrow" />
          <p>Home</p>
          </a></li>
      </ul>
      <p class="follow">Follow Us:</p>
      <ul class="follows_us">
        <li><a href="https://www.facebook.com/"><img src="../images/facebook_square.png" width="37" height="37" alt="facebook" /></a></li>
        <li><a href="https://twitter.com/login?lang=en"><img src="../images/twitter.png" width="37" height="37" alt="twitter" /></a></li>
        <li><a href="https://plus.google.com/discover"><img src="../images/google_plus.png" width="37" height="37" alt="google" /></a></li>
        <li><a href="https://www.youtube.com/"><img src="../images/pininterest.png" width="37" height="37" alt="pininterest" /></a></li>
      </ul>
    </div>
  </div>
</section>
<footer>
  <p class="footer_text">Copy&nbsp;&copy;2018&nbsp;Electronic&nbsp;Store.All&nbsp;rights&nbsp;reserved.Designed&nbsp;by&nbsp;Uday</p>
</footer>
<script src="../js/jquery.min.js" type="text/javascript"></script> 
<script src="../js/bootstrap.min.js" type="text/javascript"></script> 
<script src="../js/jquery.bxslider.min.js" type="text/javascript"></script> 
<script src="../js/jquery.isotope.min.js"></script> 
<script src="../js/own.js" type="text/javascript"></script> 
<script src="../js/page_loader.js" type="text/javascript"></script> 
<script src="../js/navbar.js" type="text/javascript"></script>
</body>
</html>