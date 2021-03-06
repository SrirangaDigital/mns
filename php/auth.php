<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" lang= "en" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" type="text/css" href="style/style.css" media ="screen" />
	<link rel="stylesheet" type="text/css" href="style/reset.css" media ="screen" />
	<link rel="icon" type="image/png" href="images/favicon.png">
	<title>Blackbuck</title>
</head>	

<body>
<div class="topheader">
	<div class="topheader_page">
		<img  class="logo" src="images/img.png" />
		<span class="credit">Madras Naturalists&apos; Society</span>
	</div>
</div>
<div class="page">
	<div id="header">
		<img class="title" src="images/logo_white.png" />
		<div id="menu">
			<ul>
				<li><a href="../index.php">Home</a></li>
				<li><a href="about.php">About</a></li>
				<li><a href="blb/volumes.php">Blackbuck</a></li>
				<li><a href="bulletin/volumes.php">Bulletin</a></li>
				<li><a href="special-publications.php">Special Publications</a></li>
				<li><a href="search.php">Search</a></li>
			</ul>
		</div>
	</div>
	<div class="mainpage">
		<div class="archive_volume">
			<div class="col_amenu">
				<ul>
					<li><span class="amenu bigger">Articles by</span><span class="issuespan_delim bigger"><span class="bigger">|</span></span></li>
				</ul>
			</div>
<?php

include("blb/connect.php");

$authid=$_GET['authid'];
$authorname=$_GET['author'];

$month_name = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

echo "<div class=\"archive_title\"><span class=\"author\">$authorname</span> in Blackbuck and the Bulletin</div><div class=\"archive\"><ul>";

$query = "(select * from article_blb where authid like '%$authid%') UNION ALL (select * from article_bulletin where authid like '%$authid%') order by volume, part, page";
$result = $mysqli->query($query);

$num_rows = $result->num_rows;

if($num_rows>0)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		$row = $result->fetch_assoc();

		$titleid = $row['titleid'];
		$title = $row['title'];
		$page = $row['page'];
		$volume = $row['volume'];
		$part = $row['part'];
		$year = $row['year'];
		$month = $row['month'];
        
        $dpart = $part;
        $dpart = preg_replace("/^0/", "", $dpart);
        $dpart = preg_replace("/\-0/", "-", $dpart);
		$dpart = preg_replace('/\-/', '–', $dpart);
		$dpart = (preg_match('/\–/', $dpart)) ? "Nos. $dpart" : "No. $dpart";

        $dvolume = $volume;
        $dvolume = preg_replace("/^0+/", "", $dvolume);
        $dvolume = preg_replace("/\-0+/", "-", $dvolume);
        
        $types = preg_split("/\_/", $titleid);
        $dtype = $types[0];
        
        if ($dtype == 'blb')
        {
            $dtype = 'Blackbuck';
            $vtype = 'blb';
        }
        elseif ($dtype == 'bul')
        {
            $dtype = 'Bulletin';
            $vtype = 'bulletin';
        }
        else
        {
            $dtype = '';
            $vtype = '';
        }
        
		echo "<li class=\"btml\">";
        echo "<p class=\"".$type."_motif\"><span class=\"issuespan_delim big\">|</span>".$dtype."</p>";
        echo "<span class=\"titlespan\"><a target=\"_blank\" href=\"bookReader.php?part=$part&amp;volume=$volume&amp;page=$page&amp;vtype=$vtype\">$title</a></span>";
        echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
        if($vtype == "blb")
        {
            echo "<span class=\"yearspan\"><a href=\"$vtype/toc.php?vol=$volume&part=$part\">Volume $dvolume&nbsp;&nbsp;$dpart&nbsp;(" . $month_name{intval($month)} . " $year)</a></span>";
        }
        elseif($vtype == "bulletin")
        {
            echo "<span class=\"yearspan\"><a href=\"$vtype/toc.php?vol=$volume&part=$part\">".$month_name{intval($month)}."&nbsp;$year&nbsp;&nbsp;(Volume $dvolume&nbsp;$dpart)</a></span>";
        }
		echo "<br /><span class=\"downloadspan\"><a href=\"downloadPdf.php?titleid=$titleid&amp;vtype=$vtype\" target=\"_blank\">Download pdf</a></span>";
		echo "</li>\n";        
	}
}
?>
				</ul>
			</div>	
		</div>
	</div>
	<div id="footer"><img src="images/twig.png"/><br /><p>&copy; 2015 Madras Naturalists&apos; Society</p></div>
</div>				
</body>
</html>
