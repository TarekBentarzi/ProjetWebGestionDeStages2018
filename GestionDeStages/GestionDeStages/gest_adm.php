<!DOCTYPE html>

<?php

require("auth/EtreAuthentifie.php");
include('header.php');
include("db_config.php");
$db = new PDO($dsn,$username,$password);

if ($_SESSION["role"]=='admin')
{
  //le reste de ta page



//Modification mdp
$role=$idm->getRole();

if($role!="admin"){
    
    redirect('login_form.php');
}

?>
<body class="backHome">
<div class="row">
   <div class="vertical-menu col-md-2">
  <a href="home_admin.php" class="active">Acueil</a>
  <a href="admin.php">Utilisateurs</a>
  <a href="stages.php">Stages</a>
  <a href="tuteurs.php">Tuteurs pedagogiques</a>
  <a href="soutenances.php">Soutenances</a>
  <a href="gest_adm.php">Gestionnaires admin</a>
  <a href="<?= $pathFor['logout'] ?>">Logout</a>
  
</div>
<div class="container col-md-8 offset-md-0" style="border-radius:10px">
<div class="table-responsive">
<a href="add_gest.php" class="btn btn-success">Ajouter un gestionnaire</a>
<table class="table table-hover table-bordered">



    
<thead>
    
<th>gid</th>

    
<th>nom</th>


<th>prenom</th>



<th>email</th>


<th>token</th>





</thead>






<tbody>
                         <?php 

                       $statement = $db->query('SELECT * FROM gestionnaires ORDER BY gid');
    
                        $row = $statement->fetch(PDO::FETCH_ASSOC);
                         
                          if($row){
                        
                            while($row){
                            echo '<tr>';
                            echo'<td>' . $row['gid'] . '</td><p>';
                            echo'<td>' . $row['nom'] . '</td><p>';
                            echo'<td>' . $row['prenom'] . '</td><p>';
                            echo'<td>' . $row['email'] . '</td><p>';
                            echo'<td>' . $row['token'] . '</td><p>';
                            echo '<td>';
                            echo '<a class="btn btn-danger" href="del_gest.php?id=' . $row['gid'] . ' ">Supprimer ce gestionnaire</a>';// un autre td pour le bouton de suppression
                            echo '<a class="btn btn-success" href="reinit_token.php?id=' . $row['gid'] . ' ">Reinitialiser token</a>';// un autre td pour le bouton de suppression
                            echo '</td><p>';
                            echo '</tr><p>';
        
                                   $row=$statement->fetch();
                            }
                        }
                        
                        while($row=$statement->fetch()){
                    
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo'<td>' . $row['gid'] . '</td>';
                            echo'<td>' . $row['nom'] . '</td>';
                            echo'<td>' . $row['prenom'] . '</td>';
                            echo'<td>' . $row['email'] . '</td>';
                            echo'<td>' . $row['token'] . '</td>';
                            echo '<td>';
                             echo '<a class="btn btn-danger" href="del_gest.php?id=' . $row['gid'] . ' ">Supprimer ce gestionnaire</a>';// un autre td pour le bouton de suppression
                            echo '<a class="btn btn-success" href="reinit_token.php?id=' . $row['gid'] . ' ">Reinitialiser token</a>';// un autre td pour le bouton de suppression
                            echo '</td>';
                            echo '<td>';
                            
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

<?php include("footer.php"); }else{
      $error = 'mauvais identifiant ou mot de passe';
header("Location: login_form.php?erreur=" . $error);  
}