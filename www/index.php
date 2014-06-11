<?php

require_once ('../vendor/Raptor/common/autoload.php');
require_once ('../vendor/Raptor/common/config.php');

use Raptor\shortcut\RaptorShortcut as R;
use Raptor\controller\Controller;

/* @var $ctrl Controller */
$ctrl = R::service ("controller");
$ctrl->process ();