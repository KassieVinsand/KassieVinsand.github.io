<?php require_once('../Connections/connCorgi.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")&& ($_POST['title'] && ($_POST['blog_entry']))) {
  $insertSQL = sprintf("INSERT INTO news (title, blog_entry) VALUES (%s, %s)",
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['blog_entry'], "text"));

  mysql_select_db($database_connCorgi, $connCorgi);
  $Result1 = mysql_query($insertSQL, $connCorgi) or die(mysql_error());

  $insertGoTo = "manage_posts.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>




<!DOCTYPE HTML>  
<html>
<head>

<title>Add New Post</title>
<link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon" />
<link href="boilerplate.css" rel="stylesheet" type="text/css">
<link href="corgi.css" rel="stylesheet" type="text/css">
<style type="text/css">
body {
	
}
body,td,th {
	color: rgba(32,32,32,1);
}
</style>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<style type="text/css">
a:link {
	text-decoration: none;
	color: #337ab7;
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

.error {color: #FF0000;}
</style>
<link href="../corgi.css" rel="stylesheet" type="text/css">
<meta charset="UTF-8">
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.--><script>var __adobewebfontsappname__="dreamweaver"</script><script src="http://use.edgefonts.net/lobster-two:n4:default;source-sans-pro:n2:default.js" type="text/javascript"></script>
</head>
<body>  
<img src="../Assets/corgibanneradmin.jpg" alt=""/>
<?php
// define variables and set to empty values
$titleErr = $blog_entryErr = "";
$title = $blog_entry = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
  if (empty($_POST["title"])) {
    $titleErr = "Title is required";
  } else {
    $title = test_input($_POST["title"]);
  }

  if (empty($_POST["blog_entry"])) {
    $blog_entryErr = "Post is required";
  } else {
    $blog_entry = test_input($_POST["blog_entry"]);
  }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h1 class="header">Add New Post</h1>
<p><a href="index.php">Admin Menu</a></p>
<p><span class="error">* required field.</span></p>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  
  <p>Title:
  <input type="text" name="title">
    <span class="error">* <?php echo $titleErr;?></span>
    <br><br>
    Post:  <span class="error">* <?php echo $blog_entryErr;?></span>
  <p>
    <textarea name="blog_entry" rows="5" cols="40"></textarea>
    
    <br><br>
    <input type="submit" name="insert" id="insert" value="Post It!" />
  </p> 
   <input type="hidden" name="MM_insert" value="form1" /> 
</form>


</body>
</html>