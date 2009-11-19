<?php
	$alice_password = "alice_password";
	$bob_password = "bob_password";
	$logged_in = false;
	$comments_file = "blog.data";
	
	// attempt to log the user in
	if ($_POST["password"] == $alice_password || $_COOKIE["password"] == sha1($alice_password)) {
		setcookie("password", sha1($alice_password));
		$logged_in = true;
		$user = "Alice";
	}
	if ($_POST["password"] == $bob_password || $_COOKIE["password"] == sha1($bob_password)) {
		setcookie("password", sha1($bob_password));
		$logged_in = true;
		$user = "Bob";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>XSS Example</title>
<style type="text/css">
#ajax_result {
	padding: 10px;
	background: #FBFEF5;
	border: 1px dashed black;
}
</style>
<script type="text/javascript" src="../yui/build/utilities/utilities.js"></script>
<script type="text/javascript" src="../yui/build/cookie/cookie-min.js"></script> 
<script type="text/javascript">
//<![CDATA[
var logout = function() {
	YAHOO.util.Cookie.remove("password");
	window.location = window.location;
};

// to ease debugging
var init = function() {
	if (YAHOO.util.Cookie.get("password") == null) {
		YAHOO.util.Cookie.set("password", "none");
	}
};
//YAHOO.util.Event.onDOMReady(init);
//]]>
</script>
</head>
<body>

<?php
// see if the user is logged in
if ($logged_in == true) {
	?>
	You are logged in as <?=$user ?>. <input type="button" value="Logout" onclick="logout()" /><br /><br />
	<form action="" method="POST">
		<input type="hidden" name="user" value="<?=$user ?>" />
		Comment:<br />
		<textarea name="comment" rows="10" cols="30"></textarea><br />
		<input type="submit" value="Submit" />
	</form>
	<hr />
	<?
}
else {
	?>
	You are not logged in.<br /><br />
	<form action="" method="post">
		Password: <input type="password" name="password" /> <input type="submit" value="Log in" />
	</form>
	<hr />
	<?
}

// add comments
if ($logged_in == true && $_POST["comment"] != "") {
	add_comment($comments_file, time(), $_POST["user"], $_POST["comment"]);
}

// print comments
echo '<div id="comments">';
$comments = file($comments_file);
foreach ($comments as $comment) {
	if (trim($comment) != "") echo $comment . "<hr />";
}
echo '</div>';

// functions
function add_comment($comments_file, $time, $user, $comment) {
	$fh = fopen($comments_file, 'a') or die("can't open file");
	$stringData = "On " . date("r", $time) . " $user wrote:<br />";
	$stringData .= '<div class="comment">' . $comment . "</div>\n";
	fwrite($fh, $stringData);
	fclose($fh);
}
?>
</body>
</html>