

<?php

require("auth/EtreAuthentifie.php");
include('header.php');
include("db_config.php");
$db = new PDO($dsn,$username,$password);

$user=$idm->getUid();
$login=$idm->getIdentity();


if ($_SESSION["role"]=='user')
{

 if($_SERVER["REQUEST_METHOD"]== "POST" && !empty($_POST)){ //on initialise nos messages d'erreurs; 
      $newPassError='';
      $oldPassError='';
     // on recupère nos valeurs 
     $newPass = htmlentities(trim(password_hash($_POST['newPass'],PASSWORD_BCRYPT)));
     $oldPass = htmlentities(trim($_POST['oldPass']));
     // on vérifie nos champs 
     $valid = true;  if(empty($newPass)){ $newPassError ='Veuillez saisir un mot de passe'; $valid= false; }
     $valid = true;  if(empty($oldPass)){ $oldPassError ='Veuillez saisir l\'encien mot de passe'; $valid= false; }
     // si les données sont présentes et bonnes, on se connecte à la base 
     if ($valid) {
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) .
                    $sqlold = "SELECT mdp FROM users WHERE login=?";
                    $qold = $db->prepare($sqlold);
                    $qold->execute(array($login));
                    $row = $qold->fetch(PDO::FETCH_ASSOC);
         if(password_verify($oldPass,$row['mdp'])==true){
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) .
                    $sql = "UPDATE users SET mdp=? WHERE login=?";
                    $q = $db->prepare($sql);
                    $q->execute(array($newPass,$login));
  
             ?>
            <div id="dialog" title="">
            <p>mot de passe modifié avec succés!</p>
            </div> 
             <?php
         }else{
              ?>
            <div id="dialog" title="Erreur">
            <p>echec encien mot de passe incorrect,si vous avez oublier votre mot de passe veuillez contacter l'admin</p>
            </div> 
             <?php
         }
     }
   
    }



?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Crud</title>
        	<link href="css/bootstrap.min.css" rel="stylesheet">
        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-wp-preserve="%3Cscript%20src%3D%22js%2Fbootstrap.js%22%3E%3C%2Fscript%3E" data-mce-resize="false" data-mce-placeholder="1" class="mce-object" width="20" height="20" alt="<script>" title="<script>" />
        
        
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#dialog" ).dialog();
  } );
  </script>
        
        
        
    </head>
    <body class="backHome">
        <div class="row">
<div class="vertical-menu col-md-2">
  <a href="ResponsableEtTuteurs.php" class="active">Accueil</a>
  <a href="NotesSout.php">modifier notes/commentaires soutenances</a>
  <a href="modifMdp.php">Modifier votre mot de passe</a>
  <a href="<?= $pathFor['logout'] ?>">Logout</a>
  
</div>


<br />
<div class="container" style="border-radius:10px">
    

<br />
<div class="row">

<br />
<h3>Modifier votre mot de passe :</h3>
<p>

</div>
<p>

<br />
<form method="post" action="modifMdp.php">

<br />
<div class="control-group<?php echo !empty($oldPassError)?'error':'';?>">
                    <label class="control-label">encien mot de passe</label>

<br />
<div class="controls">
                            <input type="text" name="oldPass" placeholder="encien mot de passe"value="">
                            <?php if(!empty($oldPassError)):?>
                            <span class="help-inline"><?php echo $oldPassError ;?></span>
                            <?php endif;?>
</div>
<p>

</div>
                

<br />
<div class="control-group<?php echo !empty($newPassError)?'error':'';?>">
                    <label class="control-label">nouveau mot de passe</label>

<br />
<div class="controls">
                            <input type="text" name="newPass" placeholder="nouveau mot de passe"value="">
                            <?php if(!empty($newPassError)):?>
                            <span class="help-inline"><?php echo $newPassError ;?></span>
                            <?php endif;?>
</div>
<p>

</div>
<p>


<br />


    <br />
<div class="form-actions">
                 <input type="submit" class="btn btn-success" name="submit" value="submit">
</div>
<p>
    


            </form>
<p>
            
            
            
</div>
<p>
</div>
        
    </body>
</html>

<?php }else{
    
    redirect('login_form.php');
}