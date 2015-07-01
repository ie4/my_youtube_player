<?php
  $v = $_GET["video_id"];
  $pl = $_GET["playlist_id"];
  $url = $_GET["url"];
  $query = $_GET["search_query"];
?>
<html>
<body>
<script>
var windowName = 'youtube_play';
var windowOption = 'width=340, height=280, menubar=no, toolbar=no, scrollbars=yes';
function openRepeatPlayer(){
  var videoId    = document.getElementById('video_id').value;
  var playlistId = document.getElementById('playlist_id').value;
  window.open('repeat.php?v='+videoId+'&pl='+playlistId, windowName, windowOption);
}
function openVideoIdsGetPlayer(){
  var url = escape(document.getElementById('url').value);
  window.open('video_ids_geter.php?url='+url, windowName, windowOption);
}
function openSearchPlayer(){
  var query = document.getElementById('search_query').value;
  window.open('search.php?q='+query, windowName, windowOption);
}
</script>
<form>
video_id <input type="text" name="video_id" id="video_id" value="<?php echo $v; ?>" size="10">
playlist_id <input type="text" name="playlist_id" id="playlist_id" value="<?php echo $pl; ?>" size="20">
<button value="youtube" onClick="openRepeatPlayer()">repeat player open</button>
</form>
<form>
url <input type="text" name="url" id="url" value="<?php echo $url; ?>" size="50">
<button value="youtube" onClick="openVideoIdsGetPlayer()">video ids get player open</button>
</form>
<form>
search word <input type="text" name="search_query" id="search_query" value="<?php echo $query; ?>" size="30">
<button value="youtube" onClick="openSearchPlayer()">search video player open</button>
</form>
</body>
</html>
