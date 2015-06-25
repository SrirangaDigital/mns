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
		<img class="title" src="../images/logo_bulletin.png" />
		<div id="menu">
			<ul>
				<li><a href="../../index.php">Home</a></li>
				<li><a href="../about.php">About</a></li>
				<li><a href="../blb/volumes.php">Blackbuck</a></li>
				<li><a class="active" href="volumes.php">Bulletin</a></li>
				<li><a href="../special-publications.php">Special Publications</a></li>
			</ul>
		</div>
	</div>
	<div class="mainpage">
		<div class="archive_volume">
			<div class="col_amenu">
				<ul>
					<li><span class="amenu"><a class="active" href="volumes.php">Volumes</a></span><span class="issuespan_delim big">|</span></li>
					<li><span class="amenu"><a href="articles.php?letter=A">Articles</a></span><span class="issuespan_delim big">|</span></li>
					<li><span class="amenu"><a href="authors.php?letter=A">Authors</a></span><span class="issuespan_delim big">|</span></li>
					<li><span class="amenu"><a href="../search.php">Search</a></span><span class="issuespan_delim big">|</span></li>
				</ul>
			</div>
			<div class="bulletin_col1">
				<ul>
<?php

include("connect.php");

$db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
$rs = mysql_select_db($database,$db) or die("No Database");

$month_name = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December","0"=>"Special");

$query = "select distinct volume,year from article_bulletin order by volume";
$result = mysql_query($query);

$num_rows = mysql_num_rows($result);

$row_count = 18;
$count = 0;
$col = 1;

if($num_rows>0)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		$row=mysql_fetch_assoc($result);

		$volume=$row['volume'];
		$year=$row['year'];
		
		$count++;
		if($count > $row_count)
		{
			$col++;
			echo "</ul></div>\n
			<div class=\"bulletin_col$col\"><ul>";
			$count = 1;
		}
		
		echo "<li><span class=\"yearspan\">$year (Volume ".intval($volume).")</span><br /><span class=\"issuespan\">";
		$query1 = "select distinct part,month from article_bulletin where volume='$volume' order by part";
		$result1 = mysql_query($query1);

		$num_rows1 = mysql_num_rows($result1);
		
		$flag = 0;
		if($num_rows1>0)
		{
			for($i1=1;$i1<=$num_rows1;$i1++)
			{
				$row1=mysql_fetch_assoc($result1);

				$part=$row1['part'];
				$month=$row1['month'];
				
                $dpart = $part;
                $dpart = preg_replace("/^0/", "", $dpart);
                $dpart = preg_replace("/\-0/", "-", $dpart);
                $dpart = preg_replace("/99/", "Sp", $dpart);
                
				if($flag == 0)
				{
					echo "<a title=\"".$month_name{intval($month)}."\" href=\"toc.php?vol=$volume&part=$part\">$dpart</a>";
					$flag = 1;
				}
				else
				{
					echo "<span class=\"issuespan_delim\">|</span><a href=\"toc.php?vol=$volume&part=$part\">$dpart</a>";
				}
			}
		}
		echo "</span></li>";
	}
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
