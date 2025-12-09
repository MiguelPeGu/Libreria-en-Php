<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
session_start();
session_unset();
session_destroy();
header("Location: ../index.php");