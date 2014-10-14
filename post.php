<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="description" content="Deskripsi Blog">
<meta name="author" content="Judul Blog">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="omfgitsasalmon">
<meta name="twitter:title" content="Simple Blog">
<meta name="twitter:description" content="Deskripsi Blog">
<meta name="twitter:creator" content="Simple Blog">
<meta name="twitter:image:src" content="{{! TODO: ADD GRAVATAR URL HERE }}">

<meta property="og:type" content="article">
<meta property="og:title" content="Simple Blog">
<meta property="og:description" content="Deskripsi Blog">   
<meta property="og:image" content="{{! TODO: ADD GRAVATAR URL HERE }}">
<meta property="og:site_name" content="Simple Blog">

<link rel="stylesheet" type="text/css" href="assets/css/screen.css" />
<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">

<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<?php
include 'mysql.php';
$tempID = $_GET['post_ID'];

echo "<title>Simple Blog | ";
// get title

//$result = mysql_query('SELECT * FROM `post_ID` WHERE `post_ID` = $tempID') or die(mysql_error());
$sql = "SELECT * FROM `post_ID` WHERE `post_ID` = '$_GET[post_ID]'";
if (isset($_GET['post_ID'])){
	$query = @mysql_query($sql);
}

if (mysql_num_rows($query) > 0){
	$row = mysql_fetch_array($query);
	echo $row['posted_title'];
	//echo $result['post_title'];
}
echo "</title>";

echo "</head>

<body class=\"default\">
<div class=\"wrapper\">

<nav class=\"nav\">
	<a style=\"border:none;\" id=\"logo\" href=\"index.php\"><h1>Simple<span>-</span>Blog</h1></a>
	<ul class=\"nav-primary\">
		<li><a href=\"new_post.html\">+ Tambah Post</a></li>
	</ul>
</nav>

<article class=\"art simple post\">
	
	<header class=\"art-header\">
		<div class=\"art-header-inner\" style=\"margin-top: 0px; opacity: 1;\">

";
echo           " <time class=\"art-time\">". $row['posted_Date'] ."</time>";
echo           " <h2 class=\"art-title\">". $row['posted_title']."</h2>";
echo"            <p class=\"art-subtitle\"></p>
		</div>
	</header>

	<div class=\"art-body\">
		<div class=\"art-body-inner\">";
if ($row['is_feat']){
	echo "            <hr class=\"featured-article\" />";
}
echo $row['posted_body'];
?>

<hr />
<h2>Komentar</h2>
			<div id="contact-area">
			<?php
			echo	"<form method=\"post\" onsubmit=\"return false;\">";
				?>
					<label for="Nama">Nama:</label>
					<input type="text" name="Nama" id="Nama">
		
					<label for="Email">Email:</label>
					<input type="text" name="Email" id="Email">
					
					<label for="Komentar">Komentar:</label><br>
					<textarea name="Komentar" rows="20" cols="20" id="Komentar"></textarea>
<?php
echo "<input type=\"reset\" name=\"submit\" value=\"Kirim\" class=\"submit-button\" onclick=\"SubmitComment();\">";
?>					
				</form>
			</div>

<ul class="art-list-body">
<div id = "yangmaudiajaks">
<?php
include 'mysql.php';
$tempID = $_GET['post_ID'];

$result = mysql_query("SELECT * FROM `comment` WHERE `post_ID` = '$tempID' ORDER BY `comm_DT` ASC") or die(mysql_error());
if (mysql_num_rows($result) > 0){
	while ($row = mysql_fetch_array($result)){
		echo "<li class=\"art-list-item\">";
		echo "<div class=\"art-list-item-title-and-time\">";
		echo	"<h2 class=\"art-list-title\">";
		// link to mail + comment author name done
		echo 	"<a href=\"mailto:$row[comm_email]\">$row[author]</a></h2>";
		// time
		echo	"<div class=\"art-list-time\">$row[comm_DT]</div>";
		echo "</div>";
		echo "<p>$row[comm_Body]";
		// insert body here
		echo "</li>";
	}
}
else {
	echo "No Comments";
}
?>
</div>
</ul>
 </div>
	</div>
</article>

<footer class="footer">
	<div class="back-to-top"><a href="">Back to top</a></div>
	<!-- <div class="footer-nav"><p></p></div> -->
	<div class="psi">&Psi;</div>
	<aside class="offsite-links">
		Asisten IF3110 /
		<a class="rss-link" href="#rss">RSS</a> /
		<br>
		<a class="twitter-link" href="http://twitter.com/YoGiiSinaga">Yogi</a> /
		<a class="twitter-link" href="http://twitter.com/sonnylazuardi">Sonny</a> /
		<a class="twitter-link" href="http://twitter.com/fathanpranaya">Fathan</a> /
		<br>
		<a class="twitter-link" href="#">Renusa</a> /
		<a class="twitter-link" href="#">Kelvin</a> /
		<a class="twitter-link" href="#">Yanuar</a> /
		
	</aside>
</footer>

</div>

<script type="text/javascript" src="assets/js/fittext.js"></script>
<script type="text/javascript" src="assets/js/app.js"></script>
<script type="text/javascript" src="assets/js/respond.min.js"></script>
<script type="text/javascript" src="assets/js/comment.js"></script>
<script type="text/javascript">
  var ga_ua = '{{! TODO: ADD GOOGLE ANALYTICS UA HERE }}';

  (function(g,h,o,s,t,z){g.GoogleAnalyticsObject=s;g[s]||(g[s]=
	  function(){(g[s].q=g[s].q||[]).push(arguments)});g[s].s=+new Date;
	  t=h.createElement(o);z=h.getElementsByTagName(o)[0];
	  t.src='//www.google-analytics.com/analytics.js';
	  z.parentNode.insertBefore(t,z)}(window,document,'script','ga'));
	  ga('create',ga_ua);ga('send','pageview');


function SubmitComment(){
	if (VerifyEmail(document.getElementById('Email').value)) {
		 if (window.XMLHttpRequest) {
			xmlHttpObj = new XMLHttpRequest( );
		} else {
			try {
				xmlHttpObj = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					xmlHttpObj = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {
					xmlHttpObj = false;
				}
			}
		}

		var post_ID = <?php echo $_GET['post_ID']?> ;
		var author = document.getElementById('Nama').value;
		var email = document.getElementById('Email').value;
		var comment = document.getElementById('Komentar').value;

		//submit
		xmlHttpObj.open("GET", "new_comm.php?post_ID=" + post_ID + "&author=" + author + "&email=" + email + "&comment=" + comment, true);
		xmlHttpObj.send(null);
		xmlHttpObj.onreadystatechange = function() {
			if (xmlHttpObj.readyState == 4 && xmlHttpObj.status == 200) {
				document.getElementById("yangmaudiajaks").innerHTML=xmlHttpObj.responseText;
			}
		}
	}
	else {
		alert("Invalid comment. Please fix~ :3");
	}
}

function VerifyEmail(email){
	var emailRegex = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/g;
	return (emailRegex.test(email));
}

</script>

</body>
</html>