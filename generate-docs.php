<?php

require 'vendor/autoload.php';

use OpenApi\Generator;

// Сканируем директории src/Rzd и controllers
$openapi = Generator::scan(['./src/Rzd', './controllers']);

// Сохраняем результат в файл swagger.json
file_put_contents('./docs/swagger.json', $openapi->toJson());

echo "Swagger документация успешно сгенерирована в docs/swagger.json\n";
?>