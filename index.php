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
  if(actionList){ document.body.removeChild(actionList); }
  var names = ['video_id','playlist_id','url','search_query'];
  var historyText = '';
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
  var actionList = document.createElement( "div" );
  actionList.id = 'action_list';
  actionList.style.cssText = "line-height:1.8em";
  actionList.innerHTML = historyText;
  document.body.appendChild( actionList );
}
function getItem(name){
  // localStorage.getItem(name)
  var msg;
  $.ajax({
    type: "POST",
    url: "json_storage.php",
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
    url: "json_storage.php",
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
window.onload = function(){
  checkUUID();
  createActionList();
}
</script>
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
</body>
</html>
