<?php

require __DIR__.'/vendor/autoload.php';

use \App\Validacao\CPF;

$resul = CPF::validar('364.420.810-79');

echo var_dump($resul);



//$cpf = new CPF();