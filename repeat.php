<?php
if($_GET["pl"]){
  $pl = $_GET["pl"];
  $prms = "?listType=playlist&list=$pl";
}
if($_GET["v"]){
  $v = $_GET["v"] ;
  $prms = "$v?loop=1&playlist=$v";
}
?>
<html>
<head>
<style type="text/css">
body{
  margin:0px;
  background:#000;
}
</style>
</head>
<body align=center>
<iframe width="320" height="240" src="//www.youtube.com/embed/<?php print $prms; ?>" frameborder="0" allowfullscreen></iframe>
<!--
https://developers.google.com/youtube/iframe_api_reference?hl=ja
https://developers.google.com/youtube/player_parameters?hl=ja
-->
<form action="repeat.php">
<input type="text" name="v" value="<?php print $v; ?>" size="10">
<input type="text" name="pl" value="<?php print $pl; ?>" size="12">
<input type="submit">
</form>
</body>
</html>
