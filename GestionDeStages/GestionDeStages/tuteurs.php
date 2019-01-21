<?php


/*SELECT etudiants.nom,etudiants.prenom,users.nom,users.prenom FROM etudiants INNER JOIN stages ON etudiants.eid=stages.eid INNER JOIN users ON stages.tuteurP=users.uid;*/

?>

<!DOCTYPE html>

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
 
//donner un tuteur pedagigique a un etudiant
//Verification que le numero du tuteur est valide
if(isset($_POST['numTut'])){
    
  $compt = $db->prepare("SELECT COUNT(*) As nbtype FROM users WHERE uid = ? AND role <> 'admin'"); // Préparation de la requète qui va compter combien de fois la valeur de la liste[0] est présente dans la base
    $compt->execute(array($_POST['numTut']));
    $donnees = $compt->fetch();
     
            if($donnees['nbtype'] > 0) {  // si le compteur répond une valeur supérieur a 0 , ALORS la valeur est déjà présente dans la table.
             
                    $tuteurPError='';
                    $tuteurP = htmlentities(trim($_POST['numTut']));
                    //echo "".$_POST['numTut'];
             
                 //on appelle notre fichier de config 

                    if (empty($tuteurP)) { $tuteurPError = 'Veuillez entrer un id de tuteurP'; }


                    //on lance la connection et la requete 
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) .
                    $sql = "UPDATE stages SET tuteurP=? WHERE sid=?";
                    $q = $db->prepare($sql);
                    $q->execute(array($tuteurP,$id));
                   // header("location:admin.php");    
                 ?>
            <div id="dialog" title="">
            <p>le tuteur : <?php echo "".$_POST['numTut'] ?> a été attribuer a l'etudiant.</p>
            </div> 
             <?php
            }
            else {     // SINON !! la valeur renvoyé par le compteur est forcement égal à 0, alors on peut ajouter l'information dans la base de donnée.
     
           //echo "erreur l'dentifiant du tuteur n'existe pas";
                ?>
            <div id="dialog" title="Erreur">
            <p>l'identifiant du tuteur n'existe pas</p>
            </div> 
             <?php
                }
    
    
}


//modification tuteur Pedagogique
if(isset($_POST['modTut'])){
    //ATTENTION NE PAS PRENDRE EN COMPTE LES ADMIN ET LES ACTIF 0
    $exist = $db->prepare("SELECT COUNT(*) As nbtype FROM users WHERE uid = ?"); // Préparation de la requète qui va compter combien de fois la valeur de la liste[0] est présente dans la base
    $exist->execute(array($_POST['modTut']));
    $donnees = $exist->fetch();
    
            if($donnees['nbtype'] > 0) {  // si le compteur répond une valeur supérieur a 0 , ALORS la valeur est déjà présente dans la table.
            
                    $tuteurPError='';
                    $modTutP = htmlentities(trim($_POST['modTut']));
                
                   ?>
            <div id="dialog" title="">
            <p>le tuteur : <?php echo "".$_POST['modTut'] ?> a été attribuer a l'etudiant.</p>
            </div> 
             <?php
                
                 //on appelle notre fichier de config 

                    if (empty($modTutP)) { $tuteurPError = 'Veuillez entrer un id de tuteurP'; }


                    //on lance la connection et la requete 
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) .
                    $mod = "UPDATE stages SET tuteurP=? WHERE eid=?";
                    $q = $db->prepare($mod);
                    $q->execute(array($modTutP,$id));
                   // header("location:admin.php");    
             
            }
            else {     // SINON !! la valeur renvoyé par le compteur est forcement égal à 0, alors on peut ajouter l'information dans la base de donnée.
     
                 ?>
            <div id="dialog" title="Erreur">
            <p>erreur l'dentifiant du tuteur n'existe pas pas de modification</p>
            </div> 
             <?php
                } 
    
}


   












?>
<body class="backHome">
<div class="row">
   <div class="vertical-menu col-md-2">
  <a href="home_admin.php" class="active">Accueil</a>
  <a href="admin.php">Utilisateurs</a>
  <a href="stages.php">Stages</a>
  <a href="tuteurs.php">Tuteurs pedagogiques</a>
  <a href="soutenances.php">Soutenances</a>
  <a href="gest_adm.php">Gestionnaires admin</a>
  <a href="<?= $pathFor['logout'] ?>">Logout</a>
  
</div>
     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#dialog" ).dialog();
  } );
  </script>
<div class="container col-md-8 offset-md-0" style="border-radius:10px">
    
    <h1>Etudiants avec tuteur pedagogique</h1>
<div class="table-responsive">

<table class="table table-hover table-bordered">


<thead>

<th>numero etudiant</th>
    
<th>nom etudiant</th>
    
<th>prenom etudiant</th>

<th>nom tuteurP</th>

<th>prenom tuteurP</th>

</thead>



<tbody>
                        <?php 

                         
                       $statement = $db->query('SELECT etudiants.eid AS eid,etudiants.nom AS nom,etudiants.prenom AS prenom,users.nom AS nomU,users.prenom AS prenomU FROM etudiants INNER JOIN stages ON etudiants.eid=stages.eid INNER JOIN users ON stages.tuteurP=users.uid ');
                        $row = $statement->fetch(PDO::FETCH_ASSOC);
     
     
                    if($row){
                        
                            while($row){
                                echo '<tr>';
                            echo'<td>' . $row['eid'] . '</td><p>';
                            echo'<td>' . $row['nom'] . '</td><p>';
                            echo'<td>' . $row['prenom'] . '</td><p>';
                            echo'<td>' . $row['nomU'] . '</td><p>';
                            echo'<td>' . $row['prenomU'] . '</td><p>';
                            echo '<td>';
                            echo '<form action="tuteurs.php?id='.$row['eid'].'" method="post">
                                <input type="number" placeholder="ID du nouveau tuteurP" name="modTut" />
                                <input type="submit" value="modifier tuteurP" 
                                     name="Submit" id="frm1_submit" /></form>';
                            echo '<a class="btn btn-danger" href="delTutP.php?id=' . $row['eid'] . ' ">Supprimer le tuteurP</a>';
                            echo '</td><p>';
                            echo '</tr><p>';
        
                                   $row=$statement->fetch();
                            }
                    }
                   
                        while($row=$statement->fetch()){
                    
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo'<td>' . $row['eid'] . '</td><p>';
                            echo'<td>' . $row['nom'] . '</td><p>';
                            echo'<td>' . $row['prenom'] . '</td><p>';
                            echo'<td>' . $row['nomU'] . '</td><p>';
                            echo'<td>' . $row['prenomU'] . '</td><p>';
                            echo '<td>';
                            echo '<form action="tuteurs.php?id='.$row['eid'].'" method="post">
                                <input type="number" placeholder="ID du nouveau tuteurP" name="modTut" />
                                <input type="submit" value="modifier tuteurP" 
                                     name="Submit" id="frm1_submit" /></form>';
                            echo '<a class="btn btn-danger" href="delTutP.php?id=' . $row['eid'] . ' ">Supprimer le tuteurP</a>';
                            echo '</td><p>';
                            echo '</tr><p>';
        
                                               
                        ;}
                         $statement->closeCursor();
                        ?>    
</tbody>
<p>

</table>


</div>
</div>
        <div class="container col-md-8" style="border-radius:10px">
            <h1>Etudiants sans tuteur pedagogique</h1>
<div class="table-responsive">

<table class="table table-hover table-bordered">


<thead>

<th>sid</th>
    
<th>nom etudiant sans tuteurP</th>
    
<th>prenom etudiant sans tuteurP</th>

</thead>



<tbody>
                        <?php 

                         
                       $sql = $db->query('SELECT sid,nom,prenom FROM etudiants LEFT OUTER JOIN stages ON etudiants.eid=stages.eid WHERE tuteurP IS NULL');
    
                        $row = $sql->fetch(PDO::FETCH_ASSOC);
                        if($row){
                            while($row){
                                echo '<tr>';
                           echo '<tr>';
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo'<td>' . $row['sid'] . '</td><p>';
                            echo'<td>' . $row['nom'] . '</td><p>';
                            echo'<td>' . $row['prenom'] . '</td><p>';
                     echo '<td>';
                              echo '<form action="tuteurs.php?id='.$row['sid'].'" method="post">
                                <input type="number" name="numTut" />
                                <input type="submit" value="ajouter tuteurP" 
                                     name="Submit" id="frm1_submit" />
                            </form>';//AJOUTER TUTEUR
                            echo '</td><p>';
                            echo '</tr><p>';
        
                                   $row=$statement->fetch();
                            }
                        }
                        
                        while($row=$sql->fetch()){
                    echo '<tr>';
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo'<td>' . $row['sid'] . '</td><p>';
                            echo'<td>' . $row['nom'] . '</td><p>';
                            echo'<td>' . $row['prenom'] . '</td><p>';
                     echo '<td>';
                              echo '<form action="tuteurs.php?id='.$row['sid'].'" method="post">
                                <input type="number" name="numTut" />
                                <input type="submit" value="ajouter tuteurP" 
                                     name="Submit" id="frm1_submit" />
                            </form>';//AJOUTER TUTEUR
                            echo '</td><p>';
                            echo '</tr><p>';
        
                                               
                        ;}
                         
                        ?>   
    
</tbody>
<p>

</table>


</div>
</div>

    
    
</div>
</body>

<?php include("footer.php");
$sql->closeCursor(); 
    
 }else{
      $error = 'mauvais identifiant ou mot de passe';
header("Location: login_form.php?erreur=" . $error);  
}