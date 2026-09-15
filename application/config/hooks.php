<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$hook['display_override'][] = array(
	'class'    => 'Security_hooks',
	'function' => 'inject_csrf_fields',
	'filename' => 'Security_hooks.php',
	'filepath' => 'hooks',
);

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/
