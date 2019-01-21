<?php

require("auth/EtreAuthentifie.php");
include("db_config.php");
$db = new PDO($dsn,$username,$password);

  
    function random($var){
        $string = "";
        $chaine = "a0b1c2d3e4f5g6h7i8j9klmnpqrstuvwxy123456789ABCDEFGHIJ";
        srand((double)microtime()*1000000);
        for($i=0; $i<$var; $i++){
            $string .= $chaine[rand()%strlen($chaine)];
        }
        return $string;
    }
  $var=random(53);
 // clé aléatoire de 25 caractères créée a partir de la fonction
$id=null;
if (!empty($_GET['id'])) { 
    $id = $_REQUEST['id']; } 
    if (null == $id) {
    header("location:admin.php"); 
    }else{

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) .
                    $sql = "UPDATE gestionnaires SET token=? WHERE gid=?";
                    $q = $db->prepare($sql);
                    $q->execute(array($var,$id));
        header("Location: gest_adm.php");
    }

?>