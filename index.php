<?php
define('ROOT', '/Web_RestAPI');
define('SESSION_EXPIRED_DAY', 60 * 60 * 24);
define('SERVER_PATH', __DIR__ . '/src');
session_set_cookie_params(SESSION_EXPIRED_DAY);
session_start();

require_once __DIR__ . '/vendor/autoload.php';

require_once SERVER_PATH . '/routes/web.php';
