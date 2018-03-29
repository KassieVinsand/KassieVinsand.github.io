<?php require_once('Connections/connCorgi.php'); ?>
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

mysql_select_db($database_connCorgi, $connCorgi);
$query_getArchives = "SELECT DISTINCT DATE_FORMAT(news.updated, '%M %Y') AS archive, DATE_FORMAT(news.updated, '%Y-%m') AS link FROM news ORDER BY news.updated DESC";
$getArchives = mysql_query($query_getArchives, $connCorgi) or die(mysql_error());
$row_getArchives = mysql_fetch_assoc($getArchives);
$totalRows_getArchives = mysql_num_rows($getArchives);

mysql_select_db($database_connCorgi, $connCorgi);
$query_getRecent = "SELECT news.post_id, news.title FROM news ORDER BY news.updated DESC LIMIT 10";
$getRecent = mysql_query($query_getRecent, $connCorgi) or die(mysql_error());
$row_getRecent = mysql_fetch_assoc($getRecent);
$totalRows_getRecent = mysql_num_rows($getRecent);



$var1_getDisplay2 = "-1";
if (isset($_GET['archive'])) {
  $var1_getDisplay2 = $_GET['archive'];
  $query_getDisplay = sprintf("SELECT news.title, news.blog_entry, DATE_FORMAT(news.updated, '%%M %%e, %%Y') AS formatted FROM news WHERE DATE_FORMAT(news.updated, '%%Y-%%m') = %s ORDER BY news.updated DESC", GetSQLValueString($var1_getDisplay2, "text"));
} elseif (isset($_GET['post_id'])) {
  $var2_getDisplay3 = $_GET['post_id'];
  $query_getDisplay = sprintf("SELECT news.title, news.blog_entry, DATE_FORMAT(news.updated, '%%M %%e, %%Y') AS formatted FROM news WHERE news.post_id = %s", GetSQLValueString($var2_getDisplay3, "int"));
} else {
  $query_getDisplay = "SELECT news.title, news.blog_entry, DATE_FORMAT(news.updated, '%M %e, %Y') AS formatted FROM news ORDER BY news.updated DESC LIMIT 2";
}
$getDisplay = mysql_query($query_getDisplay, $connCorgi) or die(mysql_error());
$row_getDisplay = mysql_fetch_assoc($getDisplay);
$totalRows_getDisplay = mysql_num_rows($getDisplay);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Corgis - Home</title>
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
	text-align: justify;
}
</style>
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.--><script>var __adobewebfontsappname__="dreamweaver"</script><script src="http://use.edgefonts.net/lobster-two:n4:default.js" type="text/javascript"></script>
</head>

<body>
<div class="gridContainer clearfix">
  <div id="content" class="fluid"><img src="Assets/corgibanner2.jpg" alt="" class="banner"/></div>
  <ul class="footer_div">
		  <li class=".menu_bar"></li>
    <li class="menu_bar"><a href="personality.html"><span class=".menu_bar"><a href="index.html">Home</a> | <a href="personality.html">Personality</a></li>
    <li class="menu_bar">| <a href="care.html">Care</a></li>
    <li class="menu_bar">| <a href="feeding.html">Feeding</a></li>
    <li class="menu_bar">| <a href="form.php">Contact</a></li>
    <li class="menu_bar">| <a href="news.php">Blog</a></li>
  </ul>
	<div id="blog">
  <div class="blog_entry" id="archive">
    <h1 class="header">Corgi Blog</h1>
    <h4><a href="admin/login.php">Admin Login</a></h4>
    <h4>Archives</h4>
    
      <?php do { ?>
        <li><a href="news.php?archive=<?php echo $row_getArchives['link']; ?>"><?php echo $row_getArchives['archive']; ?></a></li>
        <?php } while ($row_getArchives = mysql_fetch_assoc($getArchives)); ?>
    
</div>
  <div id="recent">
      <h4>Recent Posts</h4>
    
      <?php do { ?>
        <li><a href="news.php?post_id=<?php echo $row_getRecent['post_id']; ?>"><?php echo $row_getRecent['title']; ?></a></li>
        <?php } while ($row_getRecent = mysql_fetch_assoc($getRecent)); ?>
    
  </div>
  <div id="blog_posts">
    <?php do { ?>
        <h4><?php echo $row_getDisplay['title']; ?></h4>
      <p class="updated">Updated on <?php echo $row_getDisplay['formatted']; ?></p>
      <p><?php echo nl2br($row_getDisplay['blog_entry']); ?></p>
      <?php } while ($row_getDisplay = mysql_fetch_assoc($getDisplay)); ?>
  </div>
</div>
</div>
<br />
 </footer>
		<footer class="footer"> </footer>
	</div>
    <div class="fluid footer_div"><span class="small_text" style="text-align: center">Copyright 2016<br>
Last updated on 
<!-- #BeginDate format:Aml -->2017-04-26<!-- #EndDate -->
</span>

</div>
</body>
</html>
<?php
mysql_free_result($getArchives);

mysql_free_result($getRecent);

mysql_free_result($getDisplay);
?>
