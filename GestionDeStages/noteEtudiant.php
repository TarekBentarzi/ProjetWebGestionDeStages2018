 <?php include('header.php');

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
 <body class="backHome">
        <div class="row">
 <div class="vertical-menu col-md-2">
  <a href="Etudiant.php" class="active">Accueil</a>
  <a href="noteEtudiant.php">Consulter vos notes de soutenances</a>
  <a href="listeSout.php">Liste des soutenances</a>
  
</div>


<br />
<div class="container" style="border-radius:10px">
    

<br />
<div class="row">

<br />
<h3>Consulter vos informations de soutenances</h3>
<p>

</div>
<p>

<br />
<form method="post" action="notesEtudiants?id=12&token=<?php echo $_SESSION['token'];?>">

<br />

                

<br />
<div class="control-group<?php echo !empty($sidError)?'error':'';?>">
                    <label class="control-label">Saisissez votre sid :</label>

<br />
<div class="controls">
                            <input type="number" name="sid" placeholder="votre sid" value="">
                            <?php if(!empty($sidError)):?>
                            <span class="help-inline"><?php echo $sidError ;?></span>
                            <?php endif;?>
</div>
<p>

</div>
<p>
<div class="control-group<?php echo !empty($mailError)?'error':'';?>">
                    <label class="control-label">Saisissez votre mail :</label>

<br />
<div class="controls">
                            <input type="email" name="mail" placeholder="votre mail" value="">
                            <?php if(!empty($mailError)):?>
                            <span class="help-inline"><?php echo $mailError ;?></span>
                            <?php endif;?>
</div>
<p>

</div>

<br />


    <br />
<div class="form-actions">
                 <input type="submit" class="btn btn-success" name="submit" value="submit">
                 <a class="btn" href="etudiant.php">Retour</a>
</div>
<p>
    


            </form>
<p>
            
            
            
</div>
<p>
</div>
        
    </body>
