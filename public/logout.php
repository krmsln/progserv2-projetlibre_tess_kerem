<?php
require_once __DIR__ . '/../src/autoload.php';

SessionManager::logout();

header('Location: index.php');
exit;
