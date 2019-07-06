<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
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
<link href="../css/css_animation.css" rel="stylesheet" />
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
  <p class="signup_header animated finite bounceIn delay-5s"><img src="../images/line.png" width="100" height="10" alt="line" class="signup_line">Sign&nbsp;Up<img src="../images/line.png" width="100" height="10" alt="line" class="signup_line"></p>
  <div class="signup_form">
    <p class="create">Sign&nbsp;Up <span class="tagline_signup">Please&nbsp;fill&nbsp;the&nbsp;below&nbsp;Form</span></p>
    <form class="main_signup_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <input type="text" name="username" class="first_name"  placeholder="Username" value="<?php echo $username; ?>">
      <span class="help-block"><?php echo $username_err; ?></span>
      <input type="password" name="password" class="password" placeholder="Password" value="<?php echo $password; ?>">
      <span class="help-block"><?php echo $password_err; ?></span>
      <input type="password" name="confirm_password" class="confpassword_signup" placeholder="Confirm&nbsp;Password" value="<?php echo $confirm_password; ?>">
      <span class="help-block"><?php echo $confirm_password_err; ?></span>
      <input type="submit" class="signup_button" value="Submit">
      <input type="reset" id="bts" value="Reset">
      <p id="already">Already have an account? <a href="login.php">Login here</a>.</p>
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
        <li><a href="../index_mail.html"><img src="images/last_arrow.png" width="13" height="6" alt="arrow" />
          <p>Mail&nbsp;Us</p>
          </a></li>
        <li><a href="../faqs.html"><img src="images/last_arrow.png" width="13" height="6" alt="arrow" />
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