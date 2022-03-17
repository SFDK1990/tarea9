<?php
require_once '../vendor/autoload.php';
$cliente = new Laminas\Soap\Client('http://localhost/Laminas/tarea7-main/servidorsoapmate.php?wsdl');
$result = $cliente->call('potencia', [['base' => 2, 'exponente' => 3]]);
echo $result->potenciaResult;
echo "Respuesta:<br>" . $cliente->getLastResponse() . "<br>";