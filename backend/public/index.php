<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../src/App/bootstrap.php';
(require __DIR__ . '/../src/Routes/web.php')($app);

$app->run();
