<?php 

require("auth/EtreAuthentifie.php");
include('header.php');
include("db_config.php");
$db = new PDO($dsn,$username,$password);

if ($_SESSION["role"]=='admin')
{
  //le reste de ta page


$role=$idm->getRole();

if($role!="admin"){
    
    redirect('login_form.php');
}


$id = null; 
if (!empty($_GET['id'])) { 
    $id = $_REQUEST['id']; } 
    if (null == $id) {
    header("location:admin.php"); 
    }else{
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $sql = "DELETE FROM gestionnaires  WHERE gid = ?";
        $q = $db->prepare($sql);
        $q->execute(array($id));
        
        header("Location: gest_adm.php");
    
}

?>
<?php  }else{
      $error = 'mauvais identifiant ou mot de passe';
header("Location: login_form.php?erreur=" . $error);  
}