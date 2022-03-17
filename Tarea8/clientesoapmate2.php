<?php
require_once '../vendor/autoload.php';
$cliente = new Laminas\Soap\Client('http://localhost/Laminas/tarea7-main/servidorsoapmate.php?wsdl');
$result = $cliente->call('suma', [['op1' => 6, 'op2' => 3]]);
echo $result->sumaResult;
echo "Respuesta:<br>" . $cliente->getLastResponse() . "<br>";