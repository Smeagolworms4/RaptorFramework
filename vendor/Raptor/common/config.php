<?php

use Raptor\shortcut\RaptorShortcut as R;
use Raptor\config\Config;

/* @var $config Config */
$config = R::service ('config');
$config->loadWorkspaceConfig ();
