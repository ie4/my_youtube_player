<html>
<body>
<form>
<button value="youtube" onClick="javascript:window.open('repeat.php?v=<?php echo $_GET["v"]; ?>&pl=<?php echo $_GET["pl"] ?>','youtube_play','width=340, height=280, menubar=no, toolbar=no, scrollbars=yes');">repeat player open</button>
</form>
<form>
<button value="youtube" onClick="javascript:window.open('video_ids_geter.php?url='+escape(document.getElementById('url').value),'youtube_play','width=340, height=280, menubar=no, toolbar=no, scrollbars=yes');">video ids get player open</button>
<input type="text" name="url" id="url" size="50">
</form>
</body>
</html>
