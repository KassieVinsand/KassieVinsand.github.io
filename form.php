<?php 
$errors = [];
$missing = [];
// check if the form has been submitted 
	if (isset($_POST['send'])) {
		// email processing script
			$to = 'vinsand22@tritons.iowacentral.edu'; 
			$subject = 'Feedback from Corgis';
		// list expected fields
			$expected = ['firstname', 'lastname', 'email', 'address', 'city', 'state', 'zip', 'gender', 'location', 'comments'];
		// set required fields
			$required = ['firstname', 'lastname', 'email', 'address', 'city', 'state', 'zip', 'gender', 'location', 'comments'];
			
			//set default values for variable that might not exist
			if (!isset($_POST['location'])) {
					$_POST['location'] = '';
				}
				
				
		// creat additional headers
			$headers = "From: Corgis<vinsand22@tritons.iowacentral.edu>\r\n";
			$headers .= 'Content-Type: text/plain; charset=utf-8';
		require './includes/processmail.php';
		if ($mailSent) {
			header('Location: http://localhost/Corgis/thank_you.php');
			exit;
		}
	}

?>


<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="">
<!--<![endif]-->
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Corgis - Contact</title>
<link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon" />
<link href="boilerplate.css" rel="stylesheet" type="text/css">
<link href="corgi.css" rel="stylesheet" type="text/css">
<style type="text/css">
body {
	background-color: rgba(238,180,98,1);
}
body,td,th {
	color: rgba(78,62,43,1);
}
</style>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<style type="text/css">
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #337ab7;
}
a:hover {
	text-decoration: underline;
	color: #337ab7;
}
a:active {
	text-decoration: none;
}
.warning {
	color:#f00;
	font-weight:normal;
}
input[type="text"], textarea {
	width: 500px;
}
textarea {
    height: 125px;
}

#location label {
    display: inline;
    padding: 0 20px 0 3px;
}

form h2 {
    color: #036;
    font-size: 80%;
    font-weight: bold;
    margin: 0 0 5px 10px;
}

form {
    margin: 0 0 0 20px;
}


</style>
<!-- 
To learn more about the conditional comments around the html tags at the top of the file:
paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/

Do the following if you're using your customized build of modernizr (http://www.modernizr.com/):
* insert the link to your js here
* remove the link below to the html5shiv
* add the "no-js" class to the html tags at the top
* you can also remove the link to respond.min.js if you included the MQ Polyfill in your modernizr build 
-->
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="respond.min.js"></script>
<!-- HTML5 shim for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<![endif]-->
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.--><script>var __adobewebfontsappname__="dreamweaver"</script><script src="http://use.edgefonts.net/lobster-two:n4:default;source-sans-pro:n4:default.js" type="text/javascript"></script>
</head>
<body>
	<div class="gridContainer clearfix">
		<div id="content" class="fluid"><img src="Assets/corgibanner2.jpg" alt="" class="banner"/></div>
	  <nav class="menu_bar">
	    <ul>
	      <li class="menu_bar"><a href="index.html">Home</a> | </li>
	      <li class="menu_bar"><a href="personality.html">Personality</a></li>
	      <li class="menu_bar">| <a href="care.html">Care</a></li>
          <li class="menu_bar">| <a href="feeding.html">Feeding</a></li>
          <li class="menu_bar">| <a href="form.php">Contact</a></li>
          <li class="menu_bar">| <a href="news.php">Blog</a></li>
	    </ul>
	    </ul>
	  </nav>
	  <br>
      
      
    <main>
        <h1 class="header">Contact Us  </h1>
   <?php if (($_POST && $suspect) || ($_POST && isset($errors['mailfail']))) { ?>
   	<p class="warning">Sorry, your mail could not be sent.
    Please try later.</p>
    <?php } elseif ($missing || $errors) { ?>
   		<p class="warning">Please fix the item(s) indicated.</p>
    <?php } ?>
 
        <form method="post" action="">
            <p>
                <label for="firstname">First Name:
                <?php if ($missing && in_array('firstname', $missing)) { ?>
                	<span class="warning">Please enter your first name</span>
                <?php } ?>
                </label>
                <br>
                <input name="firstname" id="firstname" type="text"
                <?php if ($missing || $errors) {
					echo 'value="' . htmlentities($firstname) . '"';
				} ?>>
            </p>
            <p>
                <label for="lastname">Last Name:
                <?php if ($missing && in_array('lastname', $missing)) { ?>
                	<span class="warning">Please enter your last name</span>
                <?php } ?>
                </label>
                <br>
                <input name="lastname" id="lastname" type="text"
                <?php if ($missing || $errors) {
					echo 'value="' . htmlentities($lastname) . '"';
				} ?>>
            </p>  
            <p>
                <label for="email">Email:
                <?php if ($missing && in_array('email', $missing)) { ?>
                	<span class="warning">Please enter your email address</span>
                <?php } elseif (isset($errors['email'])) { ?>
                    <span class="warning">Invalid email address</span>
                <?php } ?>
                </label>
                <br>
                <input name="email" id="email" type="text"
                <?php if ($missing || $errors) {
					echo 'value="' . htmlentities($email) . '"';
				} ?>>
            </p>
            <p>
                <label for="address">Address:
                <?php if ($missing && in_array('address', $missing)) { ?>
                	<span class="warning">Please enter your address</span>
                <?php } ?>
                </label>
                <br>
                <input name="address" id="address" type="text"
                <?php if ($missing || $errors) {
					echo 'value="' . htmlentities($address) . '"';
				} ?>>
            </p>  
            <p>
                <label for="city">City:
                <?php if ($missing && in_array('city', $missing)) { ?>
                	<span class="warning">Please enter your city</span>
                <?php } ?>
                </label>
                <br>
                <input name="city" id="city" type="text"
                <?php if ($missing || $errors) {
					echo 'value="' . htmlentities($city) . '"';
				} ?>>
            </p>  
            <p>
                <label for="state">State:
                <?php if ($missing && in_array('state', $missing)) { ?>
                	<span class="warning">Please enter your state</span>
                <?php } ?>
                </label>
                <br>
                <input name="state" id="state" type="text"
                <?php if ($missing || $errors) {
					echo 'value="' . htmlentities($state) . '"';
				} ?>>
            </p> 
            <p>
                <label for="zip">ZIP Code:
                <?php if ($missing && in_array('zip', $missing)) { ?>
                	<span class="warning">Please enter your zip code</span>
                <?php } ?>
                </label>
                <br>
                <input name="zip"  maxlength="5" id="zip" type="text" 
                <?php if ($missing || $errors) {
					echo 'value="' . htmlentities($zip) . '"';
				} ?>>
            </p>  
            
            
            <p>
                <label for="gender">Gender:
                    <?php if ($missing && in_array('gender', $missing)) { ?>
                        <span class="warning">Please make a selection</span>
                    <?php } ?>
                </label>
                <br>
                <select name="gender" id="gender">
                    <option value=""
                        <?php
                        if (!$_POST || $_POST['gender'] == '') {
                            echo 'selected';
                        } ?>>Select one</option>
                    <option value="male"
                        <?php
                        if ($_POST && $_POST['gender'] == 'male') {
                            echo 'selected';
                        } ?>>Male</option>
                    <option value="female"
                        <?php
                        if ($_POST && $_POST['gender'] == 'female') {
                            echo 'selected';
                        } ?>>Female</option>
                    <option value="not"
                        <?php
                        if ($_POST && $_POST['gender'] == 'not') {
                            echo 'selected';
                        } ?>>Prefer not to answer</option>
                </select>
            </p> 
            
            
            <fieldset id="location">
            <p><strong>Store Location:</strong>
  <?php if ($missing && in_array('location', $missing)) { ?>
              <span class="warning">Please make a selection</span>
              <?php } ?>
              <br>
            </p>
            <p>
            <input name="location" type="radio" value="fortdodge" id="location-fortdodge"
            <?php
			if ($_POST && $_POST['location'] == 'fortdodge') {
				echo 'checked';
			} ?>>
            <label for="location-fortdodge">Fort Dodge </label>
            <input name="location" type="radio" value="webster" id="location-webster"
            <?php
			if ($_POST && $_POST['location'] == 'webster') {
				echo 'checked';
			} ?>>
            <label for="location-webster"> Webster City</label>
            </p>
            </fieldset>
      
      <p>
                <label for="comments">Questions/Comments:
                <?php if ($missing && in_array('comments', $missing)) { ?>
                        <span class="warning">Please enter your questions/comments</span>
                    <?php } ?>
                </label>
                <br>
                <textarea name="comments" id="comments"><?php if ($missing || $errors) {
					echo htmlentities($comments);
				} ?></textarea>
            </p>
            <br>
            <p>
                <input name="send" type="submit" value="Send message">
            </p>
        </form>
        
      
      
<br>
<br>
<footer class="footer"> </footer>
	
    <div class="fluid footer_div"><span class="small_text" style="text-align: center">Copyright 2016<br>
Last updated on 
<!-- #BeginDate format:Aml -->2017-04-26<!-- #EndDate -->
</span>

</div>
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
