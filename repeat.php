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
}
</style>
</head>
<body align=center>
<div id="player"></div>
<script>
  var tag = document.createElement('script');
  tag.src = "https://www.youtube.com/iframe_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  var player;
  function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
      height: '240',
      width: '320',
      events: {
        'onReady': onPlayerReady
      }
    });
  }
  function onPlayerReady(event) {
    event.target.loadPlaylist(<?php echo ($pl) ? "{list:'$pl'}" : "'$v'" ; ?>);
    event.target.setLoop(true);
  }
  function prevVideo() {
    player.previousVideo();
  }
  function nextVideo() {
    player.nextVideo();
  }
  function loopVideo() {
    list = player.getPlaylist();
    document.getElementById("v").value = list[player.getPlaylistIndex()];
    document.getElementById("pl").value = '';
    document.forms[0].submit();
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
</body>
</html>
