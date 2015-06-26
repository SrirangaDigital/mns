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
				<li><a class="active" href="search.php">Search</a></li>
			</ul>
		</div>
	</div>
	<div class="mainpage">
		<div class="archive_volume">
			<div class="col_amenu">
				<ul>
					<li><span class="amenu bigger">Search</span><span class="issuespan_delim bigger"><span class="bigger">|</span></span></li>
				</ul>
			</div>
    		<div class="archive_search">
				<table>
					<form method="POST" action="search-result.php">
					<tr>
						<td class="left"><span class="titlespan">In</span></td>
						<td class="right">
                            <input name="check[]" type="checkbox" id="checkfield1" checked="checked" value="blb"/>
                            <span class="titlespan" >&nbsp;Black Buck&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input name="check[]" type="checkbox" id="checkfield2" checked="checked" value="bul"/>
                            <span class="titlespan" >&nbsp;Bulletin&nbsp;</span>
                        </td>
					</tr>
					<tr>
						<td class="left"><span class="titlespan">Author</span></td>
						<td class="right"><input name="author" type="text" class="titlespan" id="textfield1" /></td>
					</tr>
					<tr>
						<td class="left"><span class="titlespan">Title</span></td>
						<td class="right"><input name="title" type="text" class="titlespan" id="textfield2" /></td>
					</tr>
					<tr>
						<td class="left"><span class="titlespan">Full Text</span></td>
						<td class="right"><input name="text" type="text" class="titlespan" id="textfield3" /></td>
					</tr>   
					<tr>
						<td class="left">
							<span class="titlespan">Period</span>
						</td>
						<td class="right">
							<select name="year1" class="titlespan">
								<option value=""></option>
<?php
for($i=1978;$i<=2011;$i++)
{
	echo "<option value=\"$i\">$i</option>";
}
?>
							</select>
							<span class="titlespan" >&nbsp;to&nbsp;</span>
							<select name="year2" class="titlespan">
								<option value=""></option>
<?php
for($i=1978;$i<=2011;$i++)
{
	echo "<option value=\"$i\">$i</option>";
}
?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="left">&nbsp;</td>
						<td class="right">
							<input name="button1" type="submit" class="press" id="button" value="Search"/>
							<input name="button2" type="reset" class="press" id="button" value="Reset"/>
						</td>
					</tr>
					</form>
				</table>
			</div>
		</div>
	</div>
	<div id="footer"><img src="images/twig.png"/><br /><p>&copy; 2015 Madras Naturalists&apos; Society</p></div>
</div>				
</body>
</html>
