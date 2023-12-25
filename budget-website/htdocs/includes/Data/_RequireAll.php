<?php

// Require all files in the directory
$files = glob(dirname(__FILE__) .  '/*.php');

foreach ($files as $file) {
    require_once($file);
}
