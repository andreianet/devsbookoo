<?php

require 'config.php';
/**
 * Zero a session e return para login
 */
$_SESSION['token'] = '';
header("Location : ".$base);
exit;

