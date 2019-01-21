
<?php
 session_start();
include("header.php");
   
    //protection du formulaire
    
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
  $_SESSION['token'] = $var; // clé aléatoire de 25 caractères créée a partir de la fonction
?>

<html>


<head>
    <link href="bootstrap.css" typer="text/css" rel="stylesheet"/>
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
    
    
                <form method="post" action="recap?id=12&token=<?php echo $_SESSION['token'];?>">
      <div class="vertical-menu col-md-2">
  <a href="Etudiant.php" class="active">Accueil</a>
  <a href="noteEtudiant.php">Consulter vos notes de soutenances</a>
  <a href="listeSout.php">Liste des soutenances</a>
  
</div>
    
 
<script type="text/javascript">
    $(document).ready(function() {
        $('.datepick').datepicker({ dateFormat: "yy-mm-dd"});
    });
</script>  

 <div class="container col-md-10 offset-md-1" style="border-radius: 10px">
     
        <div class="well">
            <div class="row">
                <div class="col-md-offset-0 col-md-10">
                <h3>Formulaire de stage 2018 :</h3>
                </div>
            </div>
            
          
                  <div class="row">
                      
                     <div class="col-md-4">
                          <div class="form-group">    
                              <h4>Votre nom:</h4> <input  type="text" name="nom" placeholder="Nom" required value="<?= $data['nom']??""?>"/>
                          </div>
                      </div>      
                       
                      <div class="col-md-3">
                          <div class="form-group">
                              <h4>Votre prenom:</h4><input  type="text" name="prenom" placeholder="Prenom" required value="<?= $data['prenom']??""?>"/>
                           </div>   
                      </div>
                  </div>
                     
                    <div class="row">
                        
                        <div class="col-md-4">
                            <div class="form-group">
                            <h4>Votre email:</h4> <input  type="email" name="mailEtudiant" placeholder="email" required value="<?= $data['mailEtudiant']??""?>"/>
                            </div>
                        </div>
                        
                         <div class="col-md-4">
                            <div class="form-group">
                                <h4 class="num"></h4>Votre numero de telephone :<input  type="tel" name="numTelEtudiant" placeholder="numero de tel" required value="<?= $data['numTelEtudiant']??""?>"/>
                            </div> 
                        </div>
                   </div>
                     <div class="row">
                         <div class="col-md-4">
                                <div class="form-group">
                                <h4>Intitulé de votre stage:</h4><input  type="text" name="titreStage" placeholder="titre" required value="<?= $data['titreStage']??""?>"/>
                                 </div>
                         </div>
                    </div>
     
                       <div class="row">
                         <div class="col-md-4">
                                <div class="form-group">
                                <h4>Nom de l'entreprise du stage:</h4><input  type="text" name="nomEntreprise" placeholder="Entreprise" required value="<?= $data['nomEntreprise']??""?>"/>
                                </div>
                         </div>
                                    
                          <div class="col-md-4">
                                <div class="form-group">          
                                <h4>Nom du tuteur d'entreprise:</h4><input  type="text" name="nomTE" placeholder="Tuteur d'entreprise" required value="<?= $data['nomTE']??""?>"/>
                                </div>
                          </div>
                              
                            <div class="col-md-4">
                                <div class="form-group">   
                                    <h4>Email tuteur d'entreprise:</h4><input  type="email" name="mailTE" placeholder="email tuteur d'entreprise" required value="<?= $data['mailTE']??""?>"/>
                                </div>
                           </div>
                          </div> 
                           
                        <div class="row">
                           <div class="col-md-4">
                                <div class="form-group">
                                <h4>Date de debut du stage:</h4><input  type="text" class="datepick" name="dateDebut" placeholder="date de debut" required value="<?= $data['dateDebut']??""?>"/>
                                </div>
                           </div>
                      
                            <div class="col-md-4">
                                <div class="form-group">
                                <h4>Date de fin du stage:</h4><input  type="text" class="datepick" name="dateFin" placeholder="date de fin" required value="<?= $data['dateFin']??""?>"/>
                                </div>
                            </div>
                         </div>
                           <div class="row">
                         <div class="col-md-4">
                                <div class="form-group">
                                <h4>Details concernant votre stage:</h4><textarea class="details" rows="10" cols="40" type="text" name="details" placeholder="stage" required value="<?= $data['stage']??""?>"></textarea>
                                </div>
                         </div>
                       </div>
           
    
                        <h4><input type="submit" value="valider"></h4>
                        

          </div>
    </div>
    
                </form>

    
    
<body class="backHome">


</body>




</html>
<?php
include("footer.php");
?> 