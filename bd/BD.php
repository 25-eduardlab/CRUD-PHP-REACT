<?php
$pdo = null;
$host = "localhost"; // Definimos el host
$user = "root"; // Definimos el usuario
$password = ""; // Definimos la contraseña
$bd = "tutoriales"; // Definimos la base de datos

function conectar(){
    try{
        // Usamos el scope global para acceder a las variables globales
        global $pdo, $host, $user, $password, $bd;
        
        // Creamos una nueva conexión PDO
        $pdo = new PDO("mysql:host=$host;dbname=$bd", $user, $password);
        // Establecemos el modo de error de PDO a excepción
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Imprimimos el mensaje de error y terminamos el script
        print "Error!: no se pudo conectar a la bd $bd <br/>";
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}
function desconectar() {
    $GLOBALS['pdo'] = null;
}

function metodoGet($query){
    try{
        conectar();
        $sentencia=$GLOBALS['pdo']->prepare($query);
        $sentencia->setFetchMode(PDO::FETCH_ASSOC);
        $sentencia->execute();
        desconectar();
        return $sentencia;

    }catch(Exception $e){
        die("Error: ". $e);
    }
}

function metodoPost($query, $queryAutoIncrement){
    try{
        conectar();
        $sentencia=$GLOBALS['pdo']->prepare($query);
        $sentencia->execute();
        $idAutoIncrement= metodoGet($queryAutoIncrement)->fetch(PDO::FETCH_ASSOC);
        $resultado=array_merge($idAutoIncrement, $_POST);
        $sentencia->closeCursor();
        desconectar();
        return $resultado;

    }catch(Exception $e){
        die("Error: ". $e);
    }
}

function metodoPut($query){
    try{
        conectar();
        $sentencia=$GLOBALS['pdo']->prepare($query);
        $sentencia->execute();
        $resultado=array_merge($_GET, $_POST);
        $sentencia->closeCursor();
        desconectar();
        return $resultado;

    }catch(Exception $e){
        die("Error: ". $e);
    }
}

function metodoDelete($query){
    try{
        conectar();
        $sentencia=$GLOBALS['pdo']->prepare($query);
        $sentencia->execute();
        $sentencia->closeCursor();
        desconectar();
        return $_GET['id'];

    }catch(Exception $e){
        die("Error: ". $e);
    }
}


?> 
