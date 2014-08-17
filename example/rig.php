<?php
require_once 'src/Jasonmm/Rig/RigDataSource.php';
require_once 'src/Jasonmm/Rig/FileDataSource.php';
require_once 'src/Jasonmm/Rig/RigIdentity.php';

$ds = new FileDataSource(
	array(
		'femaleNames' => 'fnames.idx',
		'maleNames' => 'mnames.idx',
		'lastNames' => 'lnames.idx',
		'locData' => 'locdata.idx',
		'street' => 'street.idx',
	)
);
$ident = new RigIdentity($ds);

print_r($ident);
echo "\n\n";

