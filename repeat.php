<?php
// https://developers.google.com/youtube/iframe_api_reference?hl=ja
// https://developers.google.com/youtube/player_parameters?hl=ja
if($_GET["pl"]){
  $pl = $_GET["pl"];
}
if($_GET["v"]){
  $v = $_GET["v"] ;
}
?>
<html>
<head>
<style type="text/css">
body{
  margin:0px;
  background:#000;
  color:#fff;
}
</style>
</head>
<body align=center>
<div id="player"></div>
<script src="js/base.js"></script>
<script>
function onPlayerReady(event) {
  event.target.loadPlaylist(<?php echo ($pl) ? "{list:'$pl'}" : "'$v'" ; ?>);
  event.target.setLoop(true);
}
</script>
<form action="repeat.php">
<a href="javascript:void(0);" onClick="prevVideo()" style="color:#fff;text-decoration:none;">&lt;&lt;</a>
<input type="text" id="v" name="v" value="<?php print $v; ?>" size="8">
<a href="javascript:void(0);" onClick="loopVideo()" style="color:#fff;text-decoration:none;"> o </a>
<input type="text" id="pl" name="pl" value="<?php print $pl; ?>" size="8">
<input type="submit">
<a href="javascript:void(0);" onClick="nextVideo()" style="color:#fff;text-decoration:none;">&gt;&gt;</a>
</form>
<div id="title" style="display:none;padding:0 0 10px;"></div>
</body>
</html>
