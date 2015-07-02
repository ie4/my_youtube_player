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
  if(videoId)    addLocalStorage("video_id",videoId) ;
  if(playlistId) addLocalStorage("playlist_id",playlistId) ;
}
function openVideoIdsGetPlayer(){
  var url = escape(document.getElementById('url').value);
  window.open('video_ids_geter.php?url='+url, windowName, windowOption);
  if(url) addLocalStorage("url",url) ;
}
function openSearchPlayer(){
  var query = document.getElementById('search_query').value;
  window.open('search.php?q='+query, windowName, windowOption);
  if(query) addLocalStorage("search_query",query) ;
}
function addLocalStorage(name,value){
  var hash = JSON.parse(localStorage.getItem(name));
  if(hash === null){
    hash = {};
    hash[value] = 1;
  }else if(hash[value] === undefined){
    hash[value] = 1;
  }else{
    hash[value] ++;
  }
  localStorage.setItem(name,JSON.stringify(hash));
}
function delLocalStorage(name,value){
  var hash = JSON.parse(localStorage.getItem(name));
  delete hash[value] ;
  localStorage.setItem(name,JSON.stringify(hash));
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
    delLocalStorage(name,value);
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
    var list = JSON.parse(localStorage.getItem(name));
    historyText += '========== ' + name + '<br />' ;
    for(var key in list){
      playFunc = 'anchorPlayFunction(\'' + name + '\',\'' + key + '\')' ;
      delFunc  = 'anchorDeleteFunction(\'' + name + '\',\'' + key + '\')' ;
      histLink = '<a href="javascript:(function(){' + playFunc + ';return false;}());">' + key + '</a>' ;
      dltLink  = '<a href="javascript:(function(){' + delFunc  + ';return false;}());">x</a>' ;
      historyText += histLink + ' : ' + list[key] + ' times play ' + dltLink +  '<br />' ;
    }
  }
  var actionList = document.createElement( "div" );
  actionList.id = 'action_list';
  actionList.style.cssText = "line-height:1.8em";
  actionList.innerHTML = historyText;
  document.body.appendChild( actionList );
}
window.onload = function(){
  createActionList();
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
