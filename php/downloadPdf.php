<?php
	
	$titleid = $_GET['titleid'];
	$vtype = $_GET['vtype'];
	if($vtype == 'blb')
	{
		if(isset($_GET['titleid']) && $_GET['titleid'] != "")
		{
			include($vtype."/connect.php");
			$db = mysql_connect('localhost',$user,$password) or die("Not connected to database");
			$rs = mysql_select_db($database,$db) or die("No Database");
			mysql_query("set names utf8");
				
			$query = "select * from article_".$type." where titleid =  '$titleid'";
			$result = mysql_query($query);
			$row = mysql_fetch_assoc($result);
			$volume = $row['volume'];
			$part = $row['part'];
			$page = $row['page'];
			$page_end = $row['page_end'];
			$pdfList = "";
			$str = '';
			
			$query1 = "select * from ocr_".$vtype." where volume = '$volume' and part = '$part' and cur_page between '$page' and '$page_end'";
			$result1 = mysql_query($query1) or die(mysql_error());
			$numOfRows1 = mysql_num_rows($result1);
			$pdfList='';
			echo "suresh ".$numOfRows1."<br>".$query1;
			for($j = 0; $j < $numOfRows1; $j++)
			{
				$row1 = mysql_fetch_assoc($result1);
				$pdfList .=  "../Volumes/".$vtype."/pdf/".$volume."/".$part."/".$row1["cur_page"].".pdf ";
			}
			$outFilename = '../ReadWrite/' . $vtype . '_' . $volume . '_' . $part . '_' . $page . '-'.$page_end. '.pdf';
		}
	}
	elseif($vtype == 'bulletin' || $vtype == 'special')
	{
		include($vtype."/connect.php");
		$db = mysql_connect('localhost',$user,$password) or die("Not connected to database");
		$rs = mysql_select_db($database,$db) or die("No Database");
		mysql_query("set names utf8");
			
		$query = "select * from article_".$type." where titleid =  '$titleid'";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		$volume = $row['volume'];
		$part = $row['part'];
		$pdfList = "../Volumes/".$vtype."/pdf/".$volume."/".$part."/index.pdf";
		$outFilename = '../ReadWrite/' . $vtype . '_' . $volume . '_' . $part . '.pdf';
	}
	system ('pdftk '.$pdfList.' cat output ' . $outFilename);
	@header("Location: $outFilename");
?>
