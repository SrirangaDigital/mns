<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" lang= "en" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" type="text/css" href="../style/style.css" media ="screen" />
	<link rel="stylesheet" type="text/css" href="../style/reset.css" media ="screen" />
	<link rel="icon" type="image/png" href="../images/favicon.png">
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
				<li><a href="../search.php">Search</a></li>
			</ul>
		</div>
	</div>
	<div class="mainpage">
		<div class="archive_volume">
			<div class="col_amenu">
				<ul>
					<li><span class="amenu bigger">Blackbuck</span><span class="issuespan_delim bigger"><span class="bigger">|</span></span></li>
					<li><span class="amenu"><a href="volumes.php">Volumes</a></span><span class="issuespan_delim big">|</span></li>
					<li><span class="amenu"><a class="active" href="articles.php?letter=A">Articles</a></span><span class="issuespan_delim big">|</span></li>
					<li><span class="amenu"><a href="authors.php?letter=A">Authors</a></span><span class="issuespan_delim big">|</span></li>
					<li><span class="amenu"><a href="../search.php">Search</a></span><span class="issuespan_delim big">|</span></li>
				</ul>
			</div>
			<div class="alphabet">
				<span class="letter"><a href="articles.php?letter=A">A</a></span>
				<span class="letter"><a href="articles.php?letter=B">B</a></span>
				<span class="letter"><a href="articles.php?letter=C">C</a></span>
				<span class="letter"><a href="articles.php?letter=D">D</a></span>
				<span class="letter"><a href="articles.php?letter=E">E</a></span>
				<span class="letter"><a href="articles.php?letter=F">F</a></span>
				<span class="letter"><a href="articles.php?letter=G">G</a></span>
				<span class="letter"><a href="articles.php?letter=H">H</a></span>
				<span class="letter"><a href="articles.php?letter=I">I</a></span>
				<span class="letter"><a href="articles.php?letter=J">J</a></span>
				<span class="letter"><a href="articles.php?letter=K">K</a></span>
				<span class="letter"><a href="articles.php?letter=L">L</a></span>
				<span class="letter"><a href="articles.php?letter=M">M</a></span>
				<span class="letter"><a href="articles.php?letter=N">N</a></span>
				<span class="letter"><a href="articles.php?letter=O">O</a></span>
				<span class="letter"><a href="articles.php?letter=P">P</a></span>
				<span class="letter"><a href="articles.php?letter=Q">Q</a></span>
				<span class="letter"><a href="articles.php?letter=R">R</a></span>
				<span class="letter"><a href="articles.php?letter=S">S</a></span>
				<span class="letter"><a href="articles.php?letter=T">T</a></span>
				<span class="letter"><a href="articles.php?letter=U">U</a></span>
				<span class="letter"><a href="articles.php?letter=V">V</a></span>
				<span class="letter"><a href="articles.php?letter=W">W</a></span>
				<span class="letter"><a href="articles.php?letter=X">X</a></span>
				<span class="letter"><a href="articles.php?letter=Y">Y</a></span>
				<span class="letter"><a href="articles.php?letter=Z">Z</a></span>
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

$month_name = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

$query = "select * from article_blb where title like '$letter%' order by title, volume, part, page";
$result = mysql_query($query);

$num_rows = mysql_num_rows($result);

if($num_rows>0)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		$row=mysql_fetch_assoc($result);

		$titleid=$row['titleid'];
		$title=$row['title'];
		$page=$row['page'];
		$authid=$row['authid'];
		$volume=$row['volume'];
		$part=$row['part'];
		$year=$row['year'];
		$month=$row['month'];
        
        $dpart = $part;
        $dpart = preg_replace("/^0/", "", $dpart);
        $dpart = preg_replace("/\-0/", "-", $dpart);
        $dpart = preg_replace('/\-/', '–', $dpart);
		$dpart = (preg_match('/\–/', $dpart)) ? "Nos. $dpart" : "No. $dpart";

        $dvolume = $volume;
        $dvolume = preg_replace("/^0+/", "", $dvolume);
        $dvolume = preg_replace("/\-0+/", "-", $dvolume);

		echo "<li class=\"btml\"><span class=\"titlespan\"><a target=\"_blank\" href=\"../bookReader.php?part=$part&amp;volume=$volume&amp;page=$page&amp;vtype=$type\">$title</a></span>&nbsp;&nbsp;|&nbsp;&nbsp;<span class=\"yearspan\"><a href=\"toc.php?vol=$volume&part=$part\">Volume $dvolume&nbsp;$dpart&nbsp;(" . $month_name{intval($month)} . " $year)</a></span>";
		if($authid != 0)
		{
			echo "<br />";
			$aut = preg_split('/;/',$authid);

			foreach ($aut as $aid)
			{
				$query2 = "select * from author where authid=$aid";
				$result2 = mysql_query($query2);

				$num_rows2 = mysql_num_rows($result2);

				if($num_rows2)
				{
					$row2=mysql_fetch_assoc($result2);

					$authorname=$row2['authorname'];
					
					echo "<span class=\"authorspan\"><a href=\"../auth.php?authid=$aid&author=$authorname\">$authorname</a></span>";
				}
			}
		}
		echo "<br /><span class=\"downloadspan\"><a href=\"../downloadPdf.php?titleid=$titleid&amp;vtype=$type\" target=\"_blank\">Download pdf</a></span>";
		echo "</li>\n";
	}
}
else
{
    echo "<li><span class=\"titlespan\">Sorry! No articles were found to begin with the letter '$letter' in <i>Blackbuck</i></span></li>";
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
