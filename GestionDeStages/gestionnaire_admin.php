<?php
session_start();
include("header.php");
include("db_config.php");
$db = new PDO($dsn,$username,$password);

 if(isset($_POST["newToken"])&&isset($_POST["newMail"])){ //on initialise nos messages d'erreurs; 
      $newTokenError='';  
      $newMailError=''; 
     // on recupère nos valeurs 
     $newToken = htmlentities(trim(password_hash($_POST['newToken'],PASSWORD_BCRYPT)));
     $newMail = htmlentities(trim($_POST["newMail"]));
     // on vérifie nos champs 
     $valid = true;  if(empty($newToken)){ $newPassError ='entrez un token'; $valid= false; }
     if(empty($newMail)){ $newMailError ='entrez un mail'; $valid= false; }
     // si les données sont présentes et bonnes, on se connecte à la base 
     if ($valid) {
         try{
             $compt = $db->prepare("SELECT COUNT(*) As nbtype FROM gestionnaires WHERE token=?"); // Préparation de la requète qui va compter combien de fois la valeur de la liste[0] est présente dans la base
    $compt->execute(array($_POST['newToken']));
    $donnees = $compt->fetch();
         }catch (\PDOException $t) {
    http_response_code(500);
    echo "Erreur de serveur.".$t;
    exit();
         }
         $sql=$db->prepare("SELECT email FROM gestionnaires WHERE token=?");
         $sql->execute(array($_POST['newToken']));
         $info = $sql->fetch();
     
            if($donnees['nbtype'] > 0 && $info['email']==$newMail) {
                $_SESSION['newToken']=$_POST['newToken'];
               
                      $var=$_SESSION['newToken'];
                echo "<script type='text/javascript'>document.location.replace('gestionnaire?id=12&token=$var');</script>";
            }else{
                echo "erreur de mail ou token";
            }
     }else{
         echo "formulaire vide";
     }
   
    }


?>


<body class="backHome">
    <div class="gest">
<form method="post" action="gestionnaire_admin.php">

<br />
    <div class="control-group<?php echo !empty($newMail)?'error':'';?>">
                    <label class="control-label">veuillez saisir votre email</label>
<div class="controls">
                            <input type="text" name="newMail" placeholder="email"value="">
                            <?php if(!empty($newTokenError)):?>
                            <span class="help-inline"><?php echo $newMailError ;?></span>
                            <?php endif;?>
</div>
    </div>          

<br />
<div class="control-group<?php echo !empty($newToken)?'error':'';?>">
                    <label class="control-label">veuillez saisir votre token</label>

<br />
<div class="controls">
                            <input type="text" name="newToken" placeholder="token"value="">
                            <?php if(!empty($newTokenError)):?>
                            <span class="help-inline"><?php echo $newTokenError ;?></span>
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
    


        </form></div>
 </body>