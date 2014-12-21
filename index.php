<?php

require 'core/core.php';

$system = new core;
$system->router();

require 'template/index.php';