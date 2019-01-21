<?php
require("auth/EtreAuthentifie.php");
include('header.php');
include("db_config.php");
$db = new PDO($dsn,$username,$password);

if ($_SESSION["role"]=='admin')
{
  //le reste de ta page


 if($_SERVER["REQUEST_METHOD"]== "POST" && !empty($_POST)){ //on initialise nos messages d'erreurs; 
     $nameError = ''; $firstnameError=''; $loginError=''; $mdpError =''; $roleError =''; 
     // on recupère nos valeurs 
     $name = htmlentities(trim($_POST['nom'])); $firstname=htmlentities(trim($_POST['prenom'])); $login = htmlentities(trim($_POST['login'])); $mdp=htmlentities(trim(password_hash($_POST['mdp'],PASSWORD_BCRYPT))); $role = htmlentities(trim($_POST['role']));  
     
     // on vérifie nos champs 
     $valid = true; if (empty($name)) { $nameError = 'Please enter Name'; $valid = false; }else if (!preg_match("/^[a-zA-Z ]*$/",$name)) { $nameError = "Only letters and white space allowed"; } if(empty($firstname)){ $firstnameError ='Please enter firstname'; $valid= false; }else if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) { $firstnameError = "Only letters and white space allowed"; } if (empty($login)) { $loginError = 'Please enter a login '; $valid = false; } if (empty($mdp)) { $mdpError = 'Please enter your mdp'; $valid = false; } if (empty($role)) { $role = 'Please enter role'; $valid = false; } 
     // si les données sont présentes et bonnes, on se connecte à la base 
     if ($valid) { 
         $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $db->prepare("INSERT INTO users (nom,prenom,login,mdp, role) VALUES(:nom, :prenom, :login, :mdp , :role )");
            $sql->execute(array(
            'nom' => $name,
	        'prenom' => $firstname,
            'login' => $login,
            'mdp' => $mdp,
            'role' => $role,
          ));
  
     
     }
     echo "utilisateur ajouté";
    }



?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Crud</title>
        	<link href="css/bootstrap.min.css" rel="stylesheet">
        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-wp-preserve="%3Cscript%20src%3D%22js%2Fbootstrap.js%22%3E%3C%2Fscript%3E" data-mce-resize="false" data-mce-placeholder="1" class="mce-object" width="20" height="20" alt="<script>" title="<script>" />
        
    </head>
    <body class="backHome">
        <div class="row">
 <div class="vertical-menu col-md-2">
  <a href="home_admin.php" class="active">Home</a>
  <a href="admin.php">Utilisateurs</a>
  <a href="stages.php">Stages</a>
  <a href="tuteurs.php">Tuteurs pedagogiques</a>
  <a href="soutenances.php">Soutenances</a>
    <a href="gest_adm.php">Gestionnaires admin</a>
  <a href="<?= $pathFor['logout'] ?>">Logout</a>
  
</div>


<br />
<div class="container">
    

<br />
<div class="row">

<br />
<h3>Ajouter un utilisateur</h3>
<p>

</div>
<p>

<br />
<form method="post" action="add.php">

<br />
<div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Nom</label>

<br />
<div class="controls">
                            <input name="nom" type="text"  placeholder="nom" value="<?php echo !empty($name)?$name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
</div>
<p>

</div>
<p>

                

<br />
<div class="control-group<?php echo !empty($firstnameError)?'error':'';?>">
                    <label class="control-label">prenom</label>

<br />
<div class="controls">
                            <input type="text" name="prenom" value="<?php echo !empty($firstname)?$firstname:''; ?>">
                            <?php if(!empty($firstnameError)):?>
                            <span class="help-inline"><?php echo $firstnameError ;?></span>
                            <?php endif;?>
</div>
<p>

</div>
<p>


<br />
<div class="control-group<?php echo !empty($loginError)?'error':'';?>">
                    <label class="control-label">login</label>

<br />
<div class="controls">
                            <input type="text" name="login" value="<?php echo !empty($login)?$login:''; ?>">
                            <?php if(!empty($loginError)):?>
                            <span class="help-inline"><?php echo $loginError ;?></span>
                            <?php endif;?>
</div>
<p>

</div>
<p>

                 

<br />
<div class="control-group <?php echo !empty($mdpError)?'error':'';?>">
                        <label class="control-label">Mdp</label>

<br />
<div class="controls">
                            <input name="mdp" type="text" placeholder="mot de passe" value="">
                            <?php if (!empty($mdpError)): ?>
                                <span class="help-inline"><?php echo $mdpError;?></span>
                            <?php endif;?>
</div>
<p>

</div>
<p>


<br />
<div class="control-group<?php echo !empty($roleError)?'error':'';?>">
                 <select name="role">

<option value="user">Utilisateur</option>

<option value="admin">Administrateur</option>


</select>
                     <?php if (!empty($roleError)): ?>
                                <span class="help-inline"><?php echo $roleError;?></span>
                            <?php endif;?>
</div>


    <br />
<div class="form-actions">
                 <input type="submit" class="btn btn-success" name="submit" value="submit">
                 <a class="btn" href="admin.php">Retour</a>
</div>
<p>
    


            </form>
<p>
            
            
            
</div>
<p>
</div>
        
    </body>
</html>

<?php  }else{
      $error = 'mauvais identifiant ou mot de passe';
header("Location: login_form.php?erreur=" . $error);  
}