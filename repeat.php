<?php
$v = $_GET["v"]; if(!$v) $v = "iIUgwCQz6ZU";
?><html>
<head>
<style type="text/css">
body{
  margin:0px;
  background:#000;
}
</style>
</head>
<body align=center>
<iframe width="320" height="240" src="//www.youtube.com/embed/<?php print $v; ?>?loop=1&playlist=<?php print $v; ?>" frameborder="0" allowfullscreen></iframe>
<!-- iframe width="320" height="240" src="//www.youtube.com/embed/<?php print $_GET["v"]; ?>?loop=1&playlist=3exsRhw3xt8" frameborder="0" allowfullscreen></iframe -->
<!--
http://ie4.me/youtube.php?v=iIUgwCQz6ZU

-->
<form action="youtube.php">
<input type="text" name="v" value="<?php print $v; ?>"><input type="submit">
</form>
</body>
</html>
