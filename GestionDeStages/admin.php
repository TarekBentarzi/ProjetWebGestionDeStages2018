<!DOCTYPE html>

<?php

require("auth/EtreAuthentifie.php");
include('header.php');
include("db_config.php");
$db = new PDO($dsn,$username,$password);

//Modification mdp
if ($_SESSION["role"]=='admin')
{
  //le reste de ta page

$id = null; 
if (!empty($_GET['id'])) { 
    $id = $_REQUEST['id']; } 


if(isset($_POST['passUser'])){
           
                    $passError='';
                  $pass = htmlentities(trim(password_hash($_POST['passUser'],PASSWORD_BCRYPT)));
                   
                 //on appelle notre fichier de config 
$valid=true;
                    if (empty($_POST['passUser'])) { $passError = 'Veuilliez entrer un mot de passe'; $valid=false;}

                   if($valid){
                    //on lance la connection et la requete 
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) .
                    $sql = "UPDATE users SET mdp=? WHERE uid=?";
                    $q = $db->prepare($sql);
                    $q->execute(array($pass,$id));
                   // header("location:admin.php");
             ?>
            <div id="dialog" title="Erreur">
            <p>le mot de passe de l'utilisateur : <?php echo "".$id ?> a été modifier avec succée. nouveau mot de passe : <?php echo "".$_POST['passUser']?></p>
            </div> 
             <?php
                  //  echo 'le mot de passe de l\'utilisateur : '.$id.' a été modifier avec succée. nouveau mot de passe : //'.$_POST['passUser'];
                   }else{
                      ?>
            <div id="dialog" title="Erreur">
            <p>formulaire de mdp vide</p>
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
<div class="container col-md-10" style="border-radius:10px">
<div class="table-responsive">
<a href="add.php" class="btn btn-success">Ajouter un utilisateur</a>
<table class="table table-hover table-bordered">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#dialog" ).dialog();
  } );
  </script>

    
<thead>
    
<th>uid</th>

    
<th>nom</th>


<th>prenom</th>



<th>login</th>


<th>mdp</th>




<th>role</th>




<th>actif</th>



</thead>






<tbody>
                         <?php 

                       $statement = $db->query('SELECT * FROM users WHERE role <> "admin" ORDER BY uid');
    
                        $row = $statement->fetch(PDO::FETCH_ASSOC);
    
                        if($row){
                            
                            while($row){
                            
                              echo '<tr>';
                            echo'<td>' . $row['uid'] . '</td>';
                            echo'<td>' . $row['nom'] . '</td>';
                            echo'<td>' . $row['prenom'] . '</td>';
                            echo'<td>' . $row['login'] . '</td>';
                            echo'<td>' . $row['mdp'] . '</td>';
                            echo'<td>' . $row['role'] . '</td>';
                            echo'<td>' . $row['actif'] . '</td>';
                            echo '<td>';
                            echo '<form action="admin.php?id='.$row['uid'].'" method="post">
                                <input type="text" name="passUser" placeholder="modifier mdp" />
                                <input type="submit" value="modifier mdp" 
                                     name="Submit" id="frm1_submit" />
                            </form>';// un autre td pour le bouton d'edition
                            echo '</td>';
                            echo '<td>';
                            echo '<a class="btn btn-success" href="actif.php?id=' . $row['uid'] . '">Activer</a>';// un autre td pour le bouton d'update
                            echo '</td>';
                            echo'<td>';
                            echo '<a class="btn btn-danger" href="inactif.php?id=' . $row['uid'] . ' ">Desactiver</a>';// un autre td pour le bouton de suppression
                            echo '</td>';
                            echo '</tr>';
                                   $row=$statement->fetch();
                            }
                        }
    
    
                        
                        while($row=$statement->fetch()){
                    
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo'<td>' . $row['uid'] . '</td>';
                            echo'<td>' . $row['nom'] . '</td>';
                            echo'<td>' . $row['prenom'] . '</td>';
                            echo'<td>' . $row['login'] . '</td>';
                            echo'<td>' . $row['mdp'] . '</td>';
                            echo'<td>' . $row['role'] . '</td>';
                            echo'<td>' . $row['actif'] . '</td>';
                            echo '<td>';
                            echo '<form action="admin.php?id='.$row['uid'].'" method="post">
                                <input type="text" name="passUser" placeholder="modifier mdp" />
                                <input type="submit" value="modifier mdp" 
                                     name="Submit" id="frm1_submit" />
                            </form>';// un autre td pour le bouton d'edition
                            echo '</td>';
                            echo '<td>';
                            echo '<a class="btn btn-success" href="actif.php?id=' . $row['uid'] . '">Activer</a>';// un autre td pour le bouton d'update
                            echo '</td>';
                            echo'<td>';
                            echo '<a class="btn btn-danger" href="inactif.php?id=' . $row['uid'] . ' ">Desactiver</a>';// un autre td pour le bouton de suppression
                            echo '</td>';
                            echo '</tr>';
        
                                               
                        ;}
                         $statement->closeCursor();
                        ?>    
 
</tbody>
<p>

</table>


</div>
</div>
</div>
</body>

<?php  }else{
      $error = 'mauvais identifiant ou mot de passe';
header("Location: login_form.php?erreur=" . $error);  
}
    include("footer.php");
