<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" lang= "en" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" type="text/css" href="../style/style.css" media ="screen" />
	<link rel="stylesheet" type="text/css" href="../style/reset.css" media ="screen" />
	<title>Blackbuck</title>
</head>	

<body>
<div class="topheader">
	<div class="topheader_page">
		<img  class="logo" src="../images/img.png" />
		<span class="credit">Madras Naturalists&apos; Society</span>
	</div>
</div>
<div class="page">
	<div id="header">
		<img class="title" src="../images/logo_white.png" />
		<div id="menu">
			<ul>
				<li><a href="../../index.php">Home</a></li>
				<li><a href="../about.php">About</a></li>
				<li><a class="active" href="volumes.php">Blackbuck</a></li>
				<li><a href="../bulletin/volumes.php">Bulletin</a></li>
				<li><a href="../special-publications.php">Special Publications</a></li>
			</ul>
		</div>
	</div>
	<div class="mainpage">
		<div class="archive_volume">
			<div class="col_amenu">
				<ul>
					<li><span class="amenu bigger">Blackbuck</span><span class="issuespan_delim bigger"><span class="bigger">|</span></span></li>
					<li><span class="amenu"><a href="volumes.php">Volumes</a></span><span class="issuespan_delim big">|</span></li>
					<li><span class="amenu"><a href="articles.php?letter=A">Articles</a></span><span class="issuespan_delim big">|</span></li>
					<li><span class="amenu"><a class="active" href="authors.php?letter=A">Authors</a></span><span class="issuespan_delim big">|</span></li>
					<li><span class="amenu"><a href="../search.php">Search</a></span><span class="issuespan_delim big">|</span></li>
				</ul>
			</div>
			<div class="alphabet">
				<span class="letter"><a href="authors.php?letter=A">A</a></span>
				<span class="letter"><a href="authors.php?letter=B">B</a></span>
				<span class="letter"><a href="authors.php?letter=C">C</a></span>
				<span class="letter"><a href="authors.php?letter=D">D</a></span>
				<span class="letter"><a href="authors.php?letter=E">E</a></span>
				<span class="letter"><a href="authors.php?letter=F">F</a></span>
				<span class="letter"><a href="authors.php?letter=G">G</a></span>
				<span class="letter"><a href="authors.php?letter=H">H</a></span>
				<span class="letter"><a href="authors.php?letter=I">I</a></span>
				<span class="letter"><a href="authors.php?letter=J">J</a></span>
				<span class="letter"><a href="authors.php?letter=K">K</a></span>
				<span class="letter"><a href="authors.php?letter=L">L</a></span>
				<span class="letter"><a href="authors.php?letter=M">M</a></span>
				<span class="letter"><a href="authors.php?letter=N">N</a></span>
				<span class="letter"><a href="authors.php?letter=O">O</a></span>
				<span class="letter"><a href="authors.php?letter=P">P</a></span>
				<span class="letter"><a href="authors.php?letter=Q">Q</a></span>
				<span class="letter"><a href="authors.php?letter=R">R</a></span>
				<span class="letter"><a href="authors.php?letter=S">S</a></span>
				<span class="letter"><a href="authors.php?letter=T">T</a></span>
				<span class="letter"><a href="authors.php?letter=U">U</a></span>
				<span class="letter"><a href="authors.php?letter=V">V</a></span>
				<span class="letter"><a href="authors.php?letter=W">W</a></span>
				<span class="letter"><a href="authors.php?letter=X">X</a></span>
				<span class="letter"><a href="authors.php?letter=Y">Y</a></span>
				<span class="letter"><a href="authors.php?letter=Z">Z</a></span>
			</div>
			<div class="archive">
				<ul>
					<?php

include("connect.php");

$db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
$rs = mysql_select_db($database,$db) or die("No Database");


if(isset($_GET['letter']))
{
	$letter = $_GET['letter'];
}
else
{
	$letter = 'A';
}

$query = "select * from author where authorname like '$letter%' and type regexp '$type_code' order by authorname";
$result = mysql_query($query);

$num_rows = mysql_num_rows($result);

if($num_rows)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		$row=mysql_fetch_assoc($result);

		$authid=$row['authid'];
		$authorname=$row['authorname'];

		if($authorname != '')
		{
			echo "<li class=\"btml\">";
			echo "<span class=\"titlespan\"><a href=\"../auth.php?authid=$authid&author=$authorname\">$authorname</a></span>";
			echo "</li>";
		}
	}
}
else
{
    echo "<li><span class=\"titlespan\">Sorry! No author names were found to begin with the letter '$letter' in Black Buck</span></li>";
}

?>
				</ul>
			</div>	
		</div>
	</div>
	<div id="footer"><img src="../images/twig.png"/><br /><p>&copy; 2015 Madras Naturalists&apos; Society</p></div>
</div>				
</body>
</html>
