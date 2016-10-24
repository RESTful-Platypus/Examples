<?php
include('vendor/autoload.php');

$platypus = new \Platypus\Platypus;

// PHPinfo
$platypus->add('\Resources\Info\PHP');

// MPD
$platypus->add('\Resources\Music\Current');
$platypus->add('\Resources\Music\Next');
$platypus->add('\Resources\Music\Song');
$platypus->add('\Resources\Music\Songs');
$platypus->add('\Resources\Music\Status');

// CLI
$platypus->add('\Resources\Stats\CPU');
$platypus->add('\Resources\Stats\RAM');

// User-"management"
$platypus->add('\Resources\Users\User');
$platypus->add('\Resources\Users\Users');

echo $platypus->go();
