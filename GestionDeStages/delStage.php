<?php 

require("auth/EtreAuthentifie.php");
include('header.php');
include("db_config.php");
$db = new PDO($dsn,$username,$password);

if ($_SESSION["role"]=='admin')
{
  //le reste de ta page



$id = null; 
if (!empty($_GET['id'])) { 
    $id = $_REQUEST['id']; } 
    if (null == $id) {
    header("location:admin.php"); 
    }else{
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $sql = "DELETE FROM stages  WHERE sid = ?";
        $q = $db->prepare($sql);
        $q->execute(array($id));
        
        header("Location: stages.php");
    
}

?>
<?php
     }else{
      $error = 'mauvais identifiant ou mot de passe';
header("Location: login_form.php?erreur=" . $error);  
}