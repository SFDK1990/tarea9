<?php
// Esta API tiene dos posibilidades; Mostrar una lista de autores o mostrar la información de un autor específico.

//Hacemos la conexion a la BD

/**
 * @param string $servidor Nombre del servidor donde hacemos la conexion
 * @param string $usuario Usuario administrador de la BBDD
 * @param string $password Contrasena con la cual nos conectamos a la BBDD
 * @param string $bd Nombre de la BBDD
 * 
 * @return object $conexion Conexion con la BBDD 
 */
function get_conexion(){
 $servidor = "localhost";
 $usuario = "daniel";
 $password = "1234";
 $bd = "libros";
 $conexion = new mysqli($servidor, $usuario, $password, $bd);
 if ($conexion->connect_error)
 {
 die("Connection failed: " . $conexion->connect_error);
 }
 else
 {
 $conexion->set_charset("utf8");
 return $conexion;
 }
} 

/**
 * @param string $sql Query que se le hace a la BBDDD
 * @param string $lista_autores Prueba la conexion con la query realizada
 * 
 * @return mixed $resultado
 * @return null
 */
function get_lista_autores(){
    //Esta información se cargará de la base de datos
    $sql = "SELECT * FROM autor";
    $lista_autores = get_conexion()->query($sql);
    if ($lista_autores->num_rows > 0 && !get_conexion()->error){
      $resultado = $lista_autores->fetch_all(MYSQLI_ASSOC);
      return $resultado;
    }else{
      return null;
    }
}

/**
 * @param string $sql Query que se le hace a la BBDDD
 * @param string $lista_libros Prueba la conexion con la query realizada
 * 
 * @return mixed $resultado
 * @return null
 */
function get_lista_libros(){
  // Cojemos la conexion con la BBDD y hacemos la query
  $sql = "SELECT * FROM libro";
  $lista_libros = get_conexion()->query($sql);
  if ($lista_libros->num_rows > 0 && !get_conexion()->error){
    $resultado = $lista_libros->fetch_all(MYSQLI_ASSOC);
    return $resultado;
  }else{
    return null;
  }
}
/**
* @param string $sql Query que se le hace a la BBDDD
* @param mixed $resulsetAutor Prueba la conexion con la query realizada
* @param mixed $resulsetLibro Prueba la conexion con la query realizada
* 
* @return mixed $info_autor
*/
function get_datos_autor($id){
  
  //Esta información se cargará de la base de datos 
  
  $sql ="SELECT * FROM autor WHERE id = '$id'";
  $sql1 ="SELECT * FROM libro WHERE id_autor = '$id'";
  $resulsetAutor = get_conexion()->query($sql);
  $resulsetLibro = get_conexion()->query($sql1);

  switch ($id){
    //IMPORTANTE: Este bloque switch simula dos consultas de la base de datos, 
		// la de autor será un join de las dos tablas
    case 0:
            $info_autor["datos"] = $resulsetAutor->fetch_array(MYSQLI_ASSOC);
            $info_autor["libros"] = $resulsetLibro->fetch_all(MYSQLI_ASSOC);
            break;
        
    case 1:
            $info_autor["datos"] = $resulsetAutor->fetch_array(MYSQLI_ASSOC);
            $info_autor["libros"] = $resulsetLibro->fetch_all(MYSQLI_ASSOC);
            break;
    case 2:
            $info_libro["datos"] = $resulsetLibro->fetch_array(MYSQLI_ASSOC);
            $info_autor["libros"] = $resulsetLibro->fetch_all(MYSQLI_ASSOC);
            break;
            
    case 3:
            $info_autor["datos"] = $resulsetLibro->fetch_all(MYSQLI_ASSOC);
            $info_libro["libros"] = $resulsetLibro->fetch_array(MYSQLI_ASSOC);
            break;
    
    case 4:
            $info_autor["datos"] = $resulsetAutor->fetch_array(MYSQLI_ASSOC);
            $info_autor["libros"] = $resulsetLibro->fetch_all(MYSQLI_ASSOC);
            break;
              
    case 5:
            $info_autor["datos"] = $resulsetAutor->fetch_array(MYSQLI_ASSOC);
            $info_autor["libros"] = $resulsetLibro->fetch_all(MYSQLI_ASSOC);  
            break;
              
    case 6:
            $info_autor["datos"] = $resulsetAutor->fetch_array(MYSQLI_ASSOC);
            $info_autor["libros"] = $resulsetLibro->fetch_all(MYSQLI_ASSOC);
            break;
        }
        return $info_autor;
}

/**
* @param string $sql Query que se le hace a la BBDDD
* @param mixed $resulsetLibro Prueba la conexion con la query realizada
* 
* @return mixed $info_autor
*/
function get_datos_libros($id){
  
  //Esta información se cargará de la base de datos 
  $sql1 ="SELECT * FROM libro l INNER JOIN autor a ON l.id_autor=a.id WHERE l.id = '$id' ";
  $resulsetLibro = get_conexion()->query($sql1);

  switch ($id){
    //IMPORTANTE: Este bloque switch simula dos consultas de la base de datos, 
		// la de libros será un join de las dos tablas
    case 0:
        $info_libro["libros"] = $resulsetLibro->fetch_array(MYSQLI_ASSOC);
        break;
        
    case 1:
        $info_libro["libros"] = $resulsetLibro->fetch_array(MYSQLI_ASSOC);
        break;
          
    case 2:
        $info_libro["libros"] = $resulsetLibro->fetch_array(MYSQLI_ASSOC);
        break;

    case 3:
        $info_libro["libros"] = $resulsetLibro->fetch_array(MYSQLI_ASSOC);
        break;

    case 4:
        $info_libro["libros"] = $resulsetLibro->fetch_array(MYSQLI_ASSOC);
        break;
          
    case 5:
        $info_libro["libros"] = $resulsetLibro->fetch_array(MYSQLI_ASSOC);
        break;
          
    case 6:
        $info_libro["libros"] = $resulsetLibro->fetch_array(MYSQLI_ASSOC);
        break;
        }
        return $info_libro;
}


$posibles_URL = array("get_lista_autores", "get_datos_autor","get_lista_libros", "get_datos_libros");

$valor = "Ha ocurrido un error";

if (isset($_GET["action"]) && in_array($_GET["action"], $posibles_URL))
{
  switch ($_GET["action"])
  {
    case "get_lista_autores":
      $valor = get_lista_autores();
      break;
    case "get_lista_libros":
        $valor = get_lista_libros();
        break;
    case "get_datos_autor":
        if (isset($_GET["id"]))
        $valor = get_datos_autor($_GET["id"]);
        else
        $valor = "Argumento no encontrado";
        break;
    case "get_datos_libros":
        if (isset($_GET["id"]))
          $valor = get_datos_libros($_GET["id"]);
        else
          $valor = "Argumento no encontrado";
        break;

      }
    }
    
    //devolvemos los datos serializados en JSON
    exit(json_encode($valor));
    ?>
