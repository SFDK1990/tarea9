<html>
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,500;1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#texto").keyup(function(){
        $("#sugerencias").load("cargarContactos.php?q=" + $("#texto").val());
        });
    });
</script>

</head>
 <body>
<!-- Links para los autores y los libros -->
<nav>
    <h1>
        <span id="link_autores"> <a href="http://localhost/Tarea8/Tarea8/cliente.php?action=get_lista_autores">Autores</a></span>
        <span id="link_autores"> <a href="http://localhost/Tarea8/Tarea8/cliente.php?action=get_lista_libros">Libros</a></span>
    </h1>
</nav>
<?php
// Si se ha hecho una peticion que busca informacion de un autor "get_datos_autor" a traves de su "id"...
if (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_datos_autor") {
    //Se realiza la peticion a la api que nos devuelve el JSON con la información de los autores
    $app_info = file_get_contents('http://localhost/Tarea8/Tarea8/api.php?action=get_datos_autor&id=' . $_GET["id"]);
    // Se decodifica el fichero JSON y se convierte a array
    $app_info = json_decode($app_info, true);
    ?>  
        <div id="contenedor">
            <div id="contenedor_autor">
                <p >
                    <td>Nombre: </td><td><span class="datos_autor"><?php echo $app_info["datos"]["nombre"] ?></span></td>
                </p>
                <p>
                    <td>Apellidos: </td><td><span class="datos_autor"> <?php echo $app_info["datos"]["apellidos"] ?></span></td>
                </p>
                <p>
                    <td>Lugar de nacimiento: </td><td><span class="datos_autor"> <?php echo $app_info["datos"]["nacionalidad"] ?></span></td>
                </p>
            </div>
            <div class="contenedor_libros">
                <ul>
                    <!-- Mostramos los libros del autor -->
                    <?php foreach($app_info["libros"] as $libro): ?>
                        <li id="libros">
                            <a href="<?php echo  "http://localhost/Tarea8/Tarea8/cliente.php?action=get_datos_libro&id=" . $libro["id"]  ?>">
                            <?php echo $libro["titulo"]; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>	
            </div>
        </div>
        <br/>
    <?php

}elseif(isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_datos_libro"){
    //Se realiza la peticion a la api que nos devuelve el JSON con la información de los autores
    $app_info_libros = file_get_contents('http://localhost/Tarea8/Tarea8/api.php?action=get_datos_libros&id=' . $_GET["id"]);
    $app_info = file_get_contents('http://localhost/Tarea8/Tarea8/api.php?action=get_datos_autor&id=' . $_GET["id"]);
    // Se decodifica el fichero JSON y se convierte a array
    $app_info = json_decode($app_info, true);       
    $app_info_libros = json_decode($app_info_libros, true);
    ?>
        <div class="libros">
            <p>
                <td > Titulo: </td><td><span class="datos_autor"><?php echo $app_info_libros["libros"]["titulo"] ?></span> </td>
            </p>
            <p>
                <td>Fecha de publicacion: </td><td> <span class="datos_autor"><?php echo $app_info_libros["libros"]["f_publicacion"] ?></span></td>
            </p>
            <p>
               <td>Autor: </td><a href="http://localhost/Tarea8/Tarea8/cliente.php?action=get_lista_libros"><td> <span class="datos_autor"><?php echo $app_info_libros["libros"]["nombre"]." ".$app_info_libros["libros"]["apellidos"] ?></span></td>
            </p>
        </div>
        <br />
    <?php


}elseif(isset($_GET["action"])&& $_GET["action"] == "get_lista_libros"){//este if nos dara la lista de todos los libros que tenemos en la BD
    
    // Pedimos al la api que nos devuelva una lista de libros. La respuesta se da en formato JSON
     $lista_libros = file_get_contents('http://localhost/Tarea8/Tarea8/api.php?action=get_lista_libros');
     
    // Convertimos el fichero JSON en array
     $lista_libros = json_decode($lista_libros, true);
        ?>
            <div class="contenedor_libros_totales contenedor_libros">
                <ul>
                <!-- Mostramos una entrada por cada autor -->
                <?php foreach($lista_libros as $libro): ?>
                    <li id="lista_libros">
                        <!-- Enlazamos cada nombre de autor con su informacion (primer if) -->
                        <a href="<?php echo "http://localhost/Tarea8/Tarea8/cliente.php?action=get_datos_libro&id=" . $libro["id"]  ?>">
                        <?php echo $libro["titulo"] . " " . $libro["f_publicacion"] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
               </ul>    

            </div>
    <?php
}else{ //sino muestra la lista de autores
        // Pedimos al la api que nos devuelva una lista de autores. La respuesta se da en formato JSON
        $lista_autores = file_get_contents('http://localhost/Tarea8/Tarea8/api.php?action=get_lista_autores');
        // Convertimos el fichero JSON en array
        $lista_autores = json_decode($lista_autores, true);
    ?>
        <div id="lista_autores">
            <h2>Lista de autores</h2>
            <ul>
            <!-- Mostramos una entrada por cada autor -->
            <?php foreach($lista_autores as $autores): ?>
                <li id="autor">
                    <!-- Enlazamos cada nombre de autor con su informacion (primer if) -->
                    <a href="<?php echo "http://localhost/Tarea8/Tarea8/cliente.php?action=get_datos_autor&id=" . $autores["id"]  ?>">
                    <?php echo $autores["nombre"] . " " . $autores["apellidos"] ?>
                    </a>
                </li>
                
            <?php endforeach; ?>
            </ul>
            <form>
Titulos: <input type="text" id="texto">
<p><strong>Sugerencias:</strong> <span id="sugerencias" style="color: #0080FF;"></span></p>
</form>
        </div>
    <?php
} ?>
<footer>
    <h4><span id="nombre">Daniel Asencio Scattolo </br>Tarea 7 DWES</span></h4>
</footer>
 </body>
</html>
