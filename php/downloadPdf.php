<?php

	exec('find ../ReadWrite/ -mmin +10 -type f -name "*.pdf" -exec rm {} \;');
	$downloadURL = '../index.php';
	$titleid = $_GET['titleid'];
	$vtype = $_GET['vtype'];
	if($vtype == 'blb')
	{
		if(isset($_GET['titleid']) && $_GET['titleid'] != "")
		{
			include($vtype."/connect.php");
			
			$vars = explode('_', $titleid);
			$volume = $vars[1];
			$part = $vars[2];
			$page = $vars[3];
			$page_end = $vars[4];
			$pdfList = '';
			
			$query1 = "select cur_page from ocr_" . $vtype . " where volume = '$volume' and part = '$part' and cur_page between '$page' and '$page_end'";
			$result1 = $mysqli->query($query1);
			
			while($row = $result1->fetch_assoc())
			{
				$pdfList .= '../Volumes/' . $vtype . '/pdf/' . $volume . '/' . $part . '/' . $row["cur_page"] . '.pdf ';
			}
			
			$downloadURL = '../ReadWrite/Blackbuck_' . $volume . '_' . $part . '_' . $page . '-'.$page_end. '.pdf';
			system ('pdftk ' . $pdfList . ' cat output ' . $downloadURL);
		}
	}
	elseif($vtype == 'bulletin')
	{
		$vars = explode('_', $titleid);
		$volume = $vars[1];
		$part = $vars[2];
		
		$resourceURL = '../Volumes/' . $vtype . '/pdf/' . $volume . '/' . $part . '/index.pdf';
		$downloadURL = '../ReadWrite/Bulletin_' . $volume . '_' . $part . '.pdf';
		@copy($resourceURL, $downloadURL);
	}
	@header("Location: $downloadURL");
?>
