<?php

require_once ('../vendor/Raptor/common/path.php');
require_once ('../vendor/Raptor/common/autoload.php');
require_once ('../vendor/Raptor/common/config.php');

use Raptor\shortcut\RaptorShortcut as R;

$ctrl = R::service ("controller");
$ctrl->process ();