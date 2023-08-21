<html>
<head>
<title>ThaiCreate.Com PHP & opendir()</title>
</head>
<body>
<?
$objOpen = opendir("thaicreate");
while (($file = readdir($objOpen)) !== false)
{
	echo "filename: <a href='thaicreate/$file'>" . $file . "</a><br />";
}
?>
</body>
</html>