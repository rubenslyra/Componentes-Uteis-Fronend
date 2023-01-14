<?php

require __DIR__.'/vendor/autoload.php';

use \App\Validacao\CNPJ;

$resul = CNPJ::validar('52.280.866/0001-05');

echo var_dump($resul);

