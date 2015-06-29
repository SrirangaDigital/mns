<?php
	$jpgBulletin = 'find ../../../Volumes/bulletin/jpg/1/ -mmin +10 -type f -name "*.jpg" -exec rm {} \;';
	exec($jpgBulletin);
	$jpgBlb = 'find ../../../Volumes/blb/jpg/1/ -mmin +10 -type f -name "*.jpg" -exec rm {} \;';
	exec($jpgBlb);
	$tifBulletin = 'find ../../../Volumes/bulletin/tif/ -mmin +10 -type f -name "*.tif" -exec rm {} \;';
	exec($tifBulletin);
	$tifBlb = 'find ../../../Volumes/blb/tif/ -mmin +10 -type f -name "*.tif" -exec rm {} \;';
	exec($tifBlb);
	$pdf = 'find ../../../ReadWrite/ -mmin +5 -type f -name "*.pdf" -exec rm {} \;';
	exec($pdf);
?>
