
<?php

include("header.php");
session_start();


if(!empty($_GET['id'])){
 if ($_SESSION['token'] == $_GET['token']) {

                // Vérification terminée
                // On peut supprimer l'utilisateur

        
?>

<link rel="stylesheet" href="style.css" type="text/css" media="screen" />


<html>

<header> </header>
 
    
    <?php
   $ddbut=date("Y-m-d", strtotime($_POST['dateDebut']));
   $dfin=date("Y-m-d", strtotime($_POST['dateFin']));
  $_SESSION['nom'] =$_POST['nom'];
    $_SESSION['prenom'] =$_POST['prenom'];
    $_SESSION['mailEtudiant'] = $_POST['mailEtudiant'];
$_SESSION['numTelEtudiant'] =  $_POST['numTelEtudiant'];
$_SESSION['titreStage'] =  $_POST['titreStage'];
    $_SESSION['details'] =  $_POST['details'];
 $_SESSION['nomEntreprise'] = $_POST['nomEntreprise'];
    $_SESSION['nomTE'] =$_POST['nomTE'];
    $_SESSION['mailTE'] =$_POST['mailTE'];
$_SESSION['dateDebut'] =$ddbut;
    $_SESSION['dateFin'] =$dfin;
    $_SESSION['nomTP']=NULL;
    ?>
    



    <div class="container" style="border-radius: 10px">
        <div class="well">
                    <form action="confirmation_form.php" method="post">

            <div class="row">
                <div class="col-mid-10">
                    <div class="form-group">
                    <h3>Confirmez vous ces informations:</h3>
                    </div>
                 </div>  
            </div>
            
          <div class="row">
                <div class="col-mid-10">
                    <div class="form-group">     
   <h4> <?php
 echo   "nom : ".$_SESSION['nom']."<br>";
  echo  "prenom : ".$_SESSION['prenom']."<br>";
     ?> </h4></div> 
              </div>
            </div>
            
           <div class="row">
                <div class="col-mid-10">
                    <div class="form-group"> 
    <h4> <?php
            
        echo  "email : ".$_SESSION['mailEtudiant']."<br>";
        echo  "numero de telephone : ".$_SESSION['numTelEtudiant']."<br>";
                        
                        ?></h4> </div></div></div>
                        
            <div class="row">
                <div class="col-mid-10">
                    <div class="form-group">
                      <h4>  <?php
        echo  "Intitulé de votre stage : ".$_SESSION['titreStage']."<br>";
        echo  "Details concernant votre stage : ".$_SESSION['details']."<br>";
                          ?></h4> </div></div></div>
            
              <div class="row">
                <div class="col-mid-10">
                    <div class="form-group">
                   <h4>   <?php
        echo  "Nom de l'entreprise du stage : ".$_SESSION['nomEntreprise']."<br>";
        echo   "nom tuteur d'entreprise : ".$_SESSION['nomTE']."<br>";
        echo   "mail tuteur d'entreprise : ".$_SESSION['mailTE']."<br>";
                       ?> </h4></div></div></div>
            
            <div class="row">
                <div class="col-mid-10">
                    <div class="form-group">
                    <h4> <?php
        echo   "date de debut du stage : ".$_SESSION['dateDebut']."<br>";
        echo   "date de fin du stage : ".$_SESSION['dateFin']."<br>";
        ?></h4> </div></div></div>
    
    <input type="submit" value="confirmer">
        
    
        </form>
        <form action="etudiant.php" method="post">
            
                <div class="row">
                <div class="col-mid-10">
                    <div class="form-group">
    <input type="submit" value="annuler">
                    </div>
                    
                </div>
            
            </div>
    </form>
    </div>
 
    </div>
    
    
    

<body class="backHome">
    
    
    
    </body>



<?php
    
    include("footer.php");
 }}else{
    header('Location: index.php');
}
?>

</html>