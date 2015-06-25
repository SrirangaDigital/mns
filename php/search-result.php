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
					<li><span class="amenu bigger">Search Results</span><span class="issuespan_delim bigger"><span class="bigger">|</span></span></li>
				</ul>
			</div>
			<div class="archive">
				<ul>
<?php

include("blb/connect.php");

$db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
$rs = mysql_select_db($database,$db) or die("No Database");

$month_name = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

$check=$_POST['check'];
$author=$_POST['author'];
$text=$_POST['text'];
$title=$_POST['title'];
$year1=$_POST['year1'];
$year2=$_POST['year2'];

$author = preg_replace("/[,\-]+/", " ", $author);
$author = preg_replace("/[\t]+/", " ", $author);
$author = preg_replace("/[ ]+/", " ", $author);
$author = preg_replace("/^ +/", "", $author);
$author = preg_replace("/ +$/", "", $author);
$author = preg_replace("/  /", " ", $author);
$author = preg_replace("/  /", " ", $author);

$title = preg_replace("/[,\-]+/", " ", $title);
$title = preg_replace("/[\t]+/", " ", $title);
$title = preg_replace("/[ ]+/", " ", $title);
$title = preg_replace("/^ +/", "", $title);
$title = preg_replace("/ +$/", "", $title);
$title = preg_replace("/  /", " ", $title);
$title = preg_replace("/  /", " ", $title);

$text = preg_replace("/[,\-]+/", " ", $text);
$text = preg_replace("/[\t]+/", " ", $text);
$text = preg_replace("/[ ]+/", " ", $text);
$text = preg_replace("/^ +/", "", $text);
$text = preg_replace("/ +$/", "", $text);
$text = preg_replace("/  /", " ", $text);
$text = preg_replace("/  /", " ", $text);

$text2 = $text;
if($title=='')
{
	$title='[a-z]*';
}
if($author=='')
{
	$author='[a-z]*';
}
if($year1=='')
{
	$year1='1978';
}
if($year2=='')
{
	$year2=date('Y');
}

if($year1 > $year2)
{
	$temp = $year1;
	$year1 = $year2;
	$year2 = $temp;
}

$authorFilter = '';
$titleFilter = '';
$textFilter = '';
$textSearchBox = '';

$authors = preg_split("/ /", $author);
$titles = preg_split("/ /", $title);
$texts = preg_split("/ /", $text);

for($ic=0;$ic<sizeof($authors);$ic++)
{
	$authorFilter .= "and authorname REGEXP '" . $authors[$ic] . "' ";
}
for($ic=0;$ic<sizeof($titles);$ic++)
{
	$titleFilter .= "and title REGEXP '" . $titles[$ic] . "' ";
}
for($ic=0;$ic<sizeof($texts);$ic++)
{
	$textFilter .= "+" . $texts[$ic] . "* ";
	$textSearchBox .= "|" . $texts[$ic];
}



$authorFilter = preg_replace("/^and /", "", $authorFilter);
$titleFilter = preg_replace("/^and /", "", $titleFilter);
$titleFilter = preg_replace("/ $/", "", $titleFilter);
$textSearchBox = preg_replace("/^\|/", "", $textSearchBox);
$textSearchBox = preg_replace("/\"/", "", $textSearchBox);
$textSearchBox = preg_replace("/\+/", "|", $textSearchBox);

if($text=='')
{
	$iquery{"blb"}="(SELECT * FROM
				(SELECT * FROM
					(SELECT * FROM article_blb WHERE $authorFilter) AS tb1
				WHERE $titleFilter) AS tb2
			WHERE year between $year1 and $year2 ORDER BY volume, part, page)";
    $iquery{"bul"}="(SELECT * FROM
				(SELECT * FROM
					(SELECT * FROM article_bulletin WHERE $authorFilter) AS tb1
				WHERE $titleFilter) AS tb2
			WHERE year between $year1 and $year2 ORDER BY volume, part, page)";
    
    $query = '';
    $mtf = '';
    for($ic=0;$ic<sizeof($check);$ic++)
    {
        if($check[$ic] != '')
        {
            $query = $query . " UNION ALL " . $iquery{$check[$ic]};
        }
    }
    $query = preg_replace("/^ UNION ALL /", "", $query);
}
elseif($text!='')
{
    $text = trim($text);
    if(preg_match("/^\"/", $text))
    {
        $stext = preg_replace("/\"/", "", $text);
        $dtext = $stext;
        $stext = '"' . $stext . '"';
    }
    elseif(preg_match("/\+/", $text))
    {
        $stext = preg_replace("/\+/", " +", $text);
        $dtext = preg_replace("/\+/", "|", $text);
        $stext = '+' . $stext;
    }
    elseif(preg_match("/\|/", $text))
    {
        $stext = preg_replace("/\|/", " ", $text);
        $dtext = $text;
    }
    else
    {
        $stext = $text;
        $dtext = $stext = preg_replace("/ /", "|", $text);
    }
    
    $stext = addslashes($stext);
    
    $iquery{"blb"}="(SELECT * FROM
                        (SELECT * FROM
                            (SELECT * FROM
                                (SELECT * FROM
                                    (SELECT *, MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) AS relevance FROM searchtable_blb WHERE MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) ORDER BY relevance DESC)
                                AS tb10 WHERE $authorFilter)
                            AS tb20 WHERE $titleFilter)
                        AS tb30 WHERE year between '$year1' and '$year2')
                    AS tb40 WHERE cur_page NOT REGEXP '[a-z]')";

    $iquery{"bul"}="(SELECT * FROM
                        (SELECT * FROM
                            (SELECT * FROM
                                (SELECT * FROM
                                    (SELECT *, MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) AS relevance FROM searchtable_bulletin WHERE MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) ORDER BY relevance DESC)
                                AS tb10 WHERE $authorFilter)
                            AS tb20 WHERE $titleFilter)
                        AS tb30 WHERE year between '$year1' and '$year2')
                    AS tb40 WHERE cur_page NOT REGEXP '[a-z]')";
                    
    $query = '';
    $mtf = '';
    for($ic=0;$ic<sizeof($check);$ic++)
    {
        if($check[$ic] != '')
        {
            $query = $query . " UNION ALL " . $iquery{$check[$ic]};
        }
    }
    $query = preg_replace("/^ UNION ALL /", "", $query);
}

$result = mysql_query($query);

$num_results = mysql_num_rows($result);

if ($num_results > 0)
{
	echo "<div class=\"titlespan\">$num_results result(s)</div><br />";
}
$titleid[0]=0;
$count = 1;
$id = "0";
if($num_results > 0)
{
	for($i=1;$i<=$num_results;$i++)
	{
		$row1 = mysql_fetch_assoc($result);

		$title = $row1['title'];
		$authorname = $row1['authorname'];
		$authid = $row1['authid'];
		$volume = $row1['volume'];
		$part = $row1['part'];
		$year = $row1['year'];
		$month = $row1['month'];
		$titleid = $row1['titleid'];
		$page = $row1['page'];
		$page_end=$row1['page_end'];
        
        $dpart = $part;
        $dpart = preg_replace("/^0+/", "", $dpart);
        $dpart = preg_replace("/\-0+/", "-", $dpart);
        $dpart = preg_replace('/\-/', '–', $dpart);
		$dpart = (preg_match('/\–/', $dpart)) ? "Nos. $dpart" : "No. $dpart";

        $dvolume = $volume;
        $dvolume = preg_replace("/^0+/", "", $dvolume);
        $dvolume = preg_replace("/\-0+/", "-", $dvolume);

		if($text != '')
		{
			$cur_page = $row1['cur_page'];
		}
		
		$title1=addslashes($title);
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
        
		if ($id != $titleid)
		{
			if($id == 0)
			{
				echo "<li class=\"btml\">";
			}
			else
			{
				echo "</li>\n<li class=\"btml\">";
			}
            echo "<p class=\"".$type."_motif\"><span class=\"issuespan_delim big\">|</span>".$dtype."</p>";
            
            echo "<span class=\"titlespan\"><a target=\"_blank\" href=\"../Volumes/$vtype/$volume/$part/index.djvu?djvuopts&page=$page.djvu&zoom=page\">$title</a></span>";
            
            if($vtype == "blb")
            {
                echo "&nbsp;&nbsp;|&nbsp;&nbsp;<span class=\"yearspan\"><a href=\"$vtype/toc.php?vol=$volume&part=$part\">Volume $dvolume&nbsp;&nbsp;$dpart&nbsp;(" . $month_name{intval($month)} . " $year)</a></span>";
            }
            elseif($vtype == "bulletin")
            {
                echo "&nbsp;&nbsp;|&nbsp;&nbsp;<span class=\"yearspan\"><a href=\"$vtype/toc.php?vol=$volume&part=$part\">".$month_name{intval($month)}."&nbsp;$year&nbsp;&nbsp;(Volume $dvolume&nbsp;$dpart)</a></span>";
            }
            
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
						
						echo "<span class=\"authorspan\"><a href=\"auth.php?authid=$aid&author=$authorname\">$authorname</a></span>";
					}
				}
			}

			if($text != '')
			{
				echo "<br /><span class=\"issuespan\">result(s) found at page no(s). </span>";
				echo "<span class=\"titlespan\"><a target=\"_blank\" href=\"../Volumes/$vtype/$volume/$part/index.djvu?djvuopts&page=$cur_page.djvu&zoom=page&find=$dtext/r\" target=\"_blank\">".intval($cur_page)."</a>&nbsp;&nbsp;&nbsp;</span>";
				$id = $titleid;
			}
		}
		else
		{
			if($text != '')
			{
				echo "<span class=\"titlespan\"><a target=\"_blank\" href=\"../Volumes/$vtype/$volume/$part/index.djvu?djvuopts&page=$cur_page.djvu&zoom=page&find=$dtext/r\" target=\"_blank\">".intval($cur_page)."</a>&nbsp;&nbsp;&nbsp;</span>";
				$id = $titleid;
			}
		}
	}
}
else
{
	echo"<span class=\"titlespan\">No results</span><br />";
	echo"<span class=\"authorspan\"><a href=\"search.php\">Go back and search again</a></span>";
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
