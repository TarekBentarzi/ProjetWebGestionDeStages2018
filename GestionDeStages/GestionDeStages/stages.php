<!DOCTYPE html>

<?php

require("auth/EtreAuthentifie.php");
include('header.php');
include("db_config.php");
$db = new PDO($dsn,$username,$password);

if ($_SESSION["role"]=='admin')
{
  //le reste de ta page
    
   ?>  
    
    
   <script type="text/javascript">
     function soumettre()
     {
     document.forms['formulaire'].submit();
     }
</script>

    
    
    
    
    
<?php 
    
    
    
    
    
    
    
    

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
<div class="container col-md-8 offset-md-0" style="border-radius:10px">
<div class="table-responsive">

<table class="table table-hover table-bordered">


<thead>
    
<th>sid</th>
    
<th>eid</th>

<th>titre</th>

<th>description</th>

<th>entreprise</th>


<th>tuteurE</th>


<th>emailTE</th>

<th>tuteurP</th>

 <th>dateDebut</th>
    
    
<th>dateFin</th>


</thead>



<tbody>
                        <?php 
                       
                       $statement = "SELECT * FROM stages WHERE YEAR(dateDebut)=? ORDER BY eid";
    
                       $q=$db->prepare($statement);
                        $q->execute(array($_SESSION['garde']));
                        $row = $q->fetch(PDO::FETCH_ASSOC);
                    if($row){
                        
                            while($row){
                            echo '<tr>';
                            echo'<td>' . $row['sid'] . '</td><p>';
                            echo'<td>' . $row['eid'] . '</td><p>';
                            echo'<td>' . $row['titre'] . '</td><p>';
                            echo'<td>' . $row['description'] . '</td><p>';
                            echo'<td>' . $row['entreprise'] . '</td><p>';
                            echo'<td>' . $row['tuteurE'] . '</td><p>';
                            echo'<td>' . $row['emailTE'] . '</td><p>';
                            echo'<td>' . $row['tuteurP'] . '</td><p>';
                            echo'<td>' . $row['dateDebut'] . '</td><p>';
                            echo'<td>' . $row['dateFin'] . '</td><p>';
                            echo '<td>';
                            echo '<a class="btn btn-danger" href="delStage.php?id=' . $row['sid'] . ' ">Supprimer stage</a>';// un autre td pour le bouton de suppression
                            echo '</td><p>';
                            echo '</tr><p>';
        
                                   $row=$q->fetch();
                            }
                        }
                      
                        
                        while($row=$q->fetch()){
                    
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo'<td>' . $row['sid'] . '</td><p>';
                            echo'<td>' . $row['eid'] . '</td><p>';
                            echo'<td>' . $row['titre'] . '</td><p>';
                            echo'<td>' . $row['description'] . '</td><p>';
                            echo'<td>' . $row['entreprise'] . '</td><p>';
                            echo'<td>' . $row['tuteurE'] . '</td><p>';
                            echo'<td>' . $row['emailTE'] . '</td><p>';
                            echo'<td>' . $row['tuteurP'] . '</td><p>';
                            echo'<td>' . $row['dateDebut'] . '</td><p>';
                            echo'<td>' . $row['dateFin'] . '</td><p>';
                            echo '<td>';
                            echo '<a class="btn btn-danger" href="delStage.php?id=' . $row['sid'] . ' ">Supprimer stage</a>';// un autre td pour le bouton de suppression
                            echo '</td><p>';
                            echo '</tr><p>';
        
                                               
                        ;}
                         $q->closeCursor();
                        ?>    
</tbody>
<p>

</table>


</div>
</div>
</div>
</body>

<?php include("footer.php");  }else{
      $error = 'mauvais identifiant ou mot de passe';
header("Location: login_form.php?erreur=" . $error);  
}