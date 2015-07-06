var tag = document.createElement('script');
tag.src = 'https://www.youtube.com/iframe_api';
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;
function onYouTubeIframeAPIReady() {
  player = new YT.Player('player', {
    height: '240',
    width: '320',
    events: {
      'onReady': onPlayerReady,
      'onError': onError,
      'onStateChange': onPlayerStateChange
    }
  });
}
function onError(event) {
  nextVideo();
}
function onPlayerStateChange(event) {
  var title = document.getElementById('title');
  console.log(player.B.videoData.title) ;
  title.innerText = player.B.videoData.title ;
  title.style.display = 'block';
}
function prevVideo() {
  player.previousVideo();
  title.style.display = 'none';
}
function nextVideo() {
  player.nextVideo();
  title.style.display = 'none';
}
function loopVideo() {
  list = player.getPlaylist();
  document.getElementById("v").value = list[player.getPlaylistIndex()];
  document.getElementById("pl").value = '';
  document.forms[0].submit();
}
