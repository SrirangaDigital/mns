<?php
	session_start();
	$url ="";
	if(isset($_GET['volume']) && $_GET['volume'] != ''){$volume = $_GET['volume']; $url = "volume=".$volume;}
	if(isset($_GET['part']) && $_GET['part'] != ''){$part = $_GET['part']; $url .= "&part=".$part;}
	if(isset($_GET['page']) && $_GET['page'] != ''){$page = $_GET['page']; $url .= "&pagenum=".$page;}
	if(isset($_GET['text']) && $_GET['text'] != ''){$text = $_GET['text']; $url .= "&searchText=".$text;}
	if(isset($_GET['vtype']) && $_GET['vtype'] != ''){$vtype = $_GET['vtype']; $url .= "&vtype=".$vtype;}
	header("Location: bookreader/templates/book.php?".$url);
	//~ 
	//~ print_r(json_encode($_SESSION['sd'][$vtype.$volume.$part]));
?>
