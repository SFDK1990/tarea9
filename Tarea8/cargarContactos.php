<?php
$salida = "";

if (isset($_GET["q"]))
{
$nombre = $_GET["q"];

$mysqli = new mysqli("localhost", "daniel", "1234", "libros");
if (!$mysqli->connect_error)
{
$mysqli->set_charset("utf8");

$sql2 = "SELECT * FROM libro l INNER JOIN autor a ON l.id_autor=a.id WHERE nombre LIKE '%$nombre%' ";

if (($resultado = $mysqli->query($sql2)) && (!$mysqli->error))
{

//Trabajar con datos
while ($fila = $resultado->fetch_array())
{
//Procesar result set como asociativo
$salida = $salida . "<br>". $fila["nombre"]." ".$fila["apellidos"]." -> ".$fila["titulo"];
}

$resultado->free();
$mysqli->close();
//echo json_encode($final);
}
}
//Dejar la funcion vacia
if($nombre == ""){
  $salida = "";
};

}

echo $salida;
?>

