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


 if($_SERVER["REQUEST_METHOD"]== "POST" && !empty($_POST)){ //on initialise nos messages d'erreurs; 
     $nameError = ''; $firstnameError=''; $emailError='';
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
     
     // on recupère nos valeurs 
     $name = htmlentities(trim($_POST['nom'])); $firstname=htmlentities(trim($_POST['prenom'])); $email = htmlentities(trim($_POST['email']));
     
     // on vérifie nos champs 
     $valid = true; if (empty($name)) { $nameError = 'Please enter Name'; $valid = false; }else if (!preg_match("/^[a-zA-Z ]*$/",$name)) { $nameError = "Only letters and white space allowed"; } if(empty($firstname)){ $firstnameError ='Please enter firstname'; $valid= false; }else if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) { $firstnameError = "Only letters and white space allowed"; } if (empty($email)) { $emailError = 'Please enter a email '; $valid = false; }
     // si les données sont présentes et bonnes, on se connecte à la base 
     if ($valid) { 
         $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $db->prepare("INSERT INTO gestionnaires (nom,prenom,email,token) VALUES(:nom, :prenom, :email, :token)");
            $sql->execute(array(
            'nom' => $name,
	        'prenom' => $firstname,
            'email' => $email,
            'token' => $var,
          
          ));
  
     
     }
     echo "gestionnaire ajouté";
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
<h3>Ajouter un gestionnaire</h3>
<p>

</div>
<p>

<br />
<form method="post" action="add_gest.php">

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
                    <label class="control-label">Prenom</label>

<br />
<div class="controls">
                            <input type="text" name="prenom" placeholder="prenom"value="<?php echo !empty($firstname)?$firstname:''; ?>">
                            <?php if(!empty($firstnameError)):?>
                            <span class="help-inline"><?php echo $firstnameError ;?></span>
                            <?php endif;?>
</div>
<p>

</div>
<p>


<br />
<div class="control-group<?php echo !empty($emailError)?'error':'';?>">
                    <label class="control-label">Mail</label>

<br />
<div class="controls">
                            <input type="text" name="email" placeholder="email" value="<?php echo !empty($email)?$email:''; ?>">
                            <?php if(!empty($emailError)):?>
                            <span class="help-inline"><?php echo $emailError ;?></span>
                            <?php endif;?>
</div>
<p>

</div>
<p>

                 

<br />


    <br />
<div class="form-actions">
                 <input type="submit" class="btn btn-success" name="submit" value="submit">
                 <a class="btn" href="gest_adm.php">Retour</a>
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