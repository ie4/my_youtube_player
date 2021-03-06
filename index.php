<?php
  $v = $_GET["video_id"];
  $pl = $_GET["playlist_id"];
  $url = $_GET["url"];
  $query = $_GET["search_query"];
?>
<html>
<head>
  <script src="http://code.jquery.com/jquery-2.1.4.js"></script>
</head>
<body>
<script>
var uuid ;
var windowName = 'youtube_play';
var windowOption = 'width=340, height=280, menubar=no, toolbar=no, scrollbars=yes';
function openRepeatPlayer(){
  var videoId    = document.getElementById('video_id').value;
  var playlistId = document.getElementById('playlist_id').value;
  window.open('repeat.php?v='+videoId+'&pl='+playlistId, windowName, windowOption);
  if(videoId)    addStorage("video_id",videoId) ;
  if(playlistId) addStorage("playlist_id",playlistId) ;
  createActionList();
}
function openVideoIdsGetPlayer(){
  var url = escape(document.getElementById('url').value);
  window.open('video_ids_geter.php?url='+url, windowName, windowOption);
  if(url) addStorage("url",url) ;
  createActionList();
}
function openSearchPlayer(){
  var query = document.getElementById('search_query').value;
  window.open('search.php?q='+query, windowName, windowOption);
  if(query) addStorage("search_query",query) ;
  createActionList();
}
function addStorage(name,value){
  var item = getItem(name);
  if(item){
    var hash = JSON.parse(getItem(name));
  }else{
    hash = {};
  }
  if(hash[value] === undefined){
    hash[value] = 1;
  }else{
    hash[value] ++;
  }
  setItem(name,JSON.stringify(hash));
}
function delStorage(name,value){
  var hash = JSON.parse(getItem(name));
  delete hash[value] ;
  setItem(name,JSON.stringify(hash));
}
function anchorPlayFunction(name,value){
  switch (name){
    case 'video_id':
      document.getElementById('video_id').value = value ;
      document.getElementById('playlist_id').value = '' ;
      openRepeatPlayer();
      break;
    case 'playlist_id':
      document.getElementById('video_id').value = '' ;
      document.getElementById('playlist_id').value = value ;
      openRepeatPlayer();
      break;
    case 'url':
      document.getElementById('url').value = value ;
      openVideoIdsGetPlayer();
      break;
    case 'search_query':
      document.getElementById('search_query').value = value ;
      openSearchPlayer();
      break;
  }
  createActionList();
}
function anchorDeleteFunction(name,value){
  if(confirm('Are you sure delete this item ?\n\n' + name + ' : ' + value)){
    delStorage(name,value);
    createActionList();
  }
}
function createActionList(){
  var actionList = document.getElementById('action_list') ;
  var names = ['video_id','playlist_id','url','search_query'];
  var historyText = '<h2>play history</h2>';
  for(var i=0; i < names.length; i++ ){
    var name = names[i];
    var hist = getItem(name);
    if(hist){
      var list = JSON.parse(getItem(name));
      historyText += '========== ' + name + '<br />' ;
      for(var key in list){
        playFunc = 'anchorPlayFunction(\'' + name + '\',\'' + key + '\')' ;
        delFunc  = 'anchorDeleteFunction(\'' + name + '\',\'' + key + '\')' ;
        histLink = '<a href="javascript:(function(){' + playFunc + ';return false;}());">' + key + '</a>' ;
        dltLink  = '<a href="javascript:(function(){' + delFunc  + ';return false;}());">x</a>' ;
        historyText += histLink + ' : ' + list[key] + ' times play ' + dltLink +  '<br />' ;
      }
    }
  }
  actionList.innerHTML = historyText;
}
function getItem(name){
  // localStorage.getItem(name)
  var msg;
  $.ajax({
    type: "POST",
    url: "api/json_storage.php",
    data: "uuid="+uuid+"&name="+name,
    async: false,
    success: function(res){
      msg = res;
    }
  });
  return msg ;
  console.log(msg);
}
function setItem(name,data){
  // localStorage.setItem(name,data)
  var msg;
  $.ajax({
    type: "POST",
    url: "api/json_storage.php",
    data: "uuid="+uuid+"&name="+name+"&data="+data,
    async: false,
    success: function(res){
      msg = res;
    }
  });
  return msg;
}
function checkUUID(){
  uuid = localStorage.getItem("uuid");
  if(!uuid){
    uuid = createUUID();
    localStorage.setItem("uuid",uuid);
  }
  document.getElementById("uuid_box").value = uuid ;
}
function createUUID() {
  var uuid = "", i, random;
  for (i = 0; i < 32; i++) {
    random = Math.random() * 16 | 0;
    if (i == 8 || i == 12 || i == 16 || i == 20) {
      uuid += "-"
    }
    uuid += (i == 12 ? 4 : (i == 16 ? (random & 3 | 8) : random)).toString(16);
  }
  return uuid;
}
function saveUUID() {
  uuid = document.getElementById("uuid_box").value ;
  if(uuid){
    localStorage.setItem("uuid",uuid);
    createActionList();
  }
}
window.onload = function(){
  checkUUID();
  createActionList();
}
</script>
<h1>My Youtube Player</h1>

<h2>plyer opener</h2>
<form onSubmit="return false;">
video_id <input type="text" name="video_id" id="video_id" value="<?php echo $v; ?>" size="10">
playlist_id <input type="text" name="playlist_id" id="playlist_id" value="<?php echo $pl; ?>" size="20">
<button value="youtube" onClick="openRepeatPlayer()">repeat player open</button>
</form>
<form onSubmit="return false;">
url <input type="text" name="url" id="url" value="<?php echo $url; ?>" size="50">
<button value="youtube" onClick="openVideoIdsGetPlayer()">video ids get player open</button>
</form>
<form onSubmit="return false;">
search word <input type="text" name="search_query" id="search_query" value="<?php echo $query; ?>" size="30">
<button value="youtube" onClick="openSearchPlayer()">search video player open</button>
</form>

<h2>config</h2>
<form onSubmit="return false;" style="margin:10px 0px;">
your uuid: <input type="text" id="uuid_box" size="35">
<input type="submit" value="uuid update" onClick="saveUUID()">
</form>
<div id="action_list" style="line-height: 1.8em;"></div>
<div style="line-height: 1.8em;">
<h2>sample links</h2>
========== video_id<br>
<a href="javascript:(function(){anchorPlayFunction('video_id','5zs1ClgqhLw');return false;}());">5zs1ClgqhLw</a><br>
========== playlist_id<br>
<a href="javascript:(function(){anchorPlayFunction('playlist_id','PL4DIwTaDEThGTKnIdVwO_KGSqWpSuxWG6');return false;}());">PL4DIwTaDEThGTKnIdVwO_KGSqWpSuxWG6</a><br>
========== url<br>
<a href="javascript:(function(){anchorPlayFunction('url','https://www.youtube.com/results?search_query=ne-yo');return false;}());">https://www.youtube.com/results?search_query=ne-yo</a><br>
<a href="javascript:(function(){anchorPlayFunction('url','http://bmr.jp/feed');return false;}());">http://bmr.jp/feed</a><br>
========== search_query<br>
<a href="javascript:(function(){anchorPlayFunction('search_query','little mix');return false;}());">little mix</a><br>
<a href="javascript:(function(){anchorPlayFunction('search_query','craig david');return false;}());">craig david</a><br>
<a href="javascript:(function(){anchorPlayFunction('search_query','usher');return false;}());">usher</a><br>
</div>
<div style="line-height: 1.8em;">
<h2>author</h2>
ie4 <a href="https://github.com/ie4" target="_blank">GitHub</a>
</div>
</body>
</html>
