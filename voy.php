<?php

use Rapid\Voyager\Voyager;

require_once __DIR__ . '/vendor/autoload.php';

# Configuration
$voy = Voyager::factory(__FILE__, __DIR__);
$voy->remote("https://variabot.ir/ChatBot/voy.php", 'SECURITY_KEYasdjasdadajsdklj9qjkac');

# Sources
$voy->sourceRoot();
// $voy->source('public', '../public_html');

$voy->exclude('voy.php');
$voy->exclude(['vendor', 'node_modules']);
$voy->exclude(['public/hot']);
$voy->exclude(['database/database.sqlite']);
$voy->exclude(['.git', '.idea']);

$voy->instead('.env', '.env.production');

$voy->start();
