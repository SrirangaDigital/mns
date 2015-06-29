<?php
	$jpgBulletin = 'find ../../../Volumes/bulletin/jpg/1/ -mmin +10 -type f -name "*.jpg" -exec rm {} \;';
	exec($jpgBulletin);
	$jpgBlb = 'find ../../../Volumes/blb/jpg/1/ -mmin +10 -type f -name "*.jpg" -exec rm {} \;';
	exec($jpgBlb);
	$jpgSpecial = 'find ../../../Volumes/special/jpg/1/ -mmin +10 -type f -name "*.jpg" -exec rm {} \;';
	exec($jpgSpecial);
	$tifBulletin = 'find ../../../Volumes/bulletin/tif/ -mmin +10 -type f -name "*.tif" -exec rm {} \;';
	exec($tifBulletin);
	$tifBlb = 'find ../../../Volumes/blb/tif/ -mmin +10 -type f -name "*.tif" -exec rm {} \;';
	exec($tifBlb);
	$tifSpecial = 'find ../../../Volumes/special/tif/ -mmin +10 -type f -name "*.tif" -exec rm {} \;';
	exec($tifSpecial);
	
?>
