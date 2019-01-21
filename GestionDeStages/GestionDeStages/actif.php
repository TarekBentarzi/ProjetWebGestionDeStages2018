<?php
require("auth/EtreAuthentifie.php");
include("db_config.php");
$db = new PDO($dsn,$username,$password);

if ($_SESSION["role"]=='admin')
{
  //le reste de ta page

 //on appelle notre fichier de config 
$id = null; 
if (!empty($_GET['id'])) { 
    $id = $_REQUEST['id']; } 
    if (null == $id) {
    header("location:admin.php"); 
    } 
    else { 
    //on lance la connection et la requete 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) .
    $sql = "UPDATE users SET actif=1 WHERE uid =?";
    $q = $db->prepare($sql);
    $q->execute(array($id));
    header("location:admin.php");     
    }






?>
<?php
     }else{
      $error = 'mauvais identifiant ou mot de passe';
header("Location: login_form.php?erreur=" . $error);  
}