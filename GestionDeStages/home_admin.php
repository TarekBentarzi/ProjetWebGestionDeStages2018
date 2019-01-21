<?php

require("auth/EtreAuthentifie.php");
include('header.php');
include("db_config.php");

/*si l'utilisateur n'utilise pas la page au bout de 30 minutes ,deco automatique*/
if(!$_COOKIE['PHPSESSID']){
    setcookie('PHPSESSID', session_id(), (time()+2678400));
}else{
    session_regenerate_id();
    setcookie('PHPSESSID', session_id(), (time()+2678400));
}
?>
<script type="text/javascript">
     function soumettre()
     {
     document.forms['formulaire'].submit();
     }
</script>
<div class="formul">
<label>Selectionnez l'année a consulter</label>
<p> <form name="formulaire" method="POST" action="home_admin.php">
                    <select name="newDate" class="form-control"  onchange="soumettre()">
<?php
$reponse = $db->query('SELECT DISTINCT YEAR(dateDebut) FROM stages ORDER BY YEAR(dateDebut) ASC') ; 
    $donnees=$reponse->fetch();
    $_SESSION['garde']=$_POST['newDate'];
                       ?>  <option value="0">choisissez une date</option> <?php
            while($donnees){
                
               ?> <option value="<?php echo $donnees['YEAR(dateDebut)']; ?>"  <?php if(isset($_POST['newDate']) && $_POST['newDate'] == $donnees['YEAR(dateDebut)'] ) echo 'selected="selected"';?>> <?php echo $donnees['YEAR(dateDebut)']; ?></option>
                        <?php
                $donnees=$reponse->fetch();
            }
                        
 
while ($donnees = $reponse->fetch()) {?>
 
    <option value="<?php echo $donnees['YEAR(dateDebut)']; ?>" <?php if(isset($_POST['newDate']) && $_POST['newDate'] == $donnees['YEAR(dateDebut)'] ) echo 'selected="selected"';?>> <?php echo $donnees['YEAR(dateDebut)']; ?></option>
                 
                <?php   
                }  
 
                ?>          
                 
                    </select>
</form>
</div>


<?php


$id=$idm->getRole();


/*si bon role*/
if ($_SESSION["role"]=='admin')
{
  //le reste de ta page



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
            <h1>Nombre d'étudiants par tuteur pedagogique</h1>
<div class="table-responsive">

<table class="table table-hover table-bordered">


<thead>

<th>uid</th>

<th>Nom tuteurP actif</th>
    
<th>Prenom tuteurP actif</th>
    
<th>Nombre d'etudiants en charge</th>
    

</thead>



<tbody>
                        <?php 
                     
                    if(isset($_POST['newDate'])){
                        $newDate=$_POST['newDate'];
                     }else{
                         $newDate=2018;
                     }
                         
                       $sql = "SELECT uid,nom,prenom FROM users INNER JOIN stages ON users.uid=tuteurP WHERE actif=1 AND role <> 'admin' AND YEAR(dateDebut)=?";
    
                         $q=$db->prepare($sql);
                        $q->execute(array($newDate));
                        $row = $q->fetch(PDO::FETCH_ASSOC);
                        if($row){
                            
                            while($row){
                                $compte=$db->query("SELECT tuteurP, COUNT(*) AS nbre_apparition FROM stages WHERE tuteurP=".$row['uid']."");
                                $tab = $compte->fetch(PDO::FETCH_ASSOC);
                                echo '<tr>';
                           echo '<tr>';
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo'<td>' . $row['uid'] . '</td><p>';
                                
                            echo'<td>' . $row['nom'] . '</td><p>';
                                
                            echo'<td>' . $row['prenom'] . '</td><p>';
                                
                            echo'<td>' . $tab['nbre_apparition'] . '</td><p>';
                                
                            
                     echo '<td>';
                              
                                
                                 echo '<td>';
                
                            echo '</td><p>';
                            echo '</tr><p>';
        
                                   $row=$q->fetch();
                            }
                        }
                        
                        while($row=$q->fetch()){
                       
                    echo '<tr>';
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo'<td>' . $row['sid'] . '</td><p>';
                     echo '<td>';
                            echo'<td>' . $row['nom'] . '</td><p>';
                                
                            echo'<td>' . $row['prenom'] . '</td><p>';
                            
                        
                               
                                
                            echo '</td><p>';
                            echo '</tr><p>';
        
                                               
                        ;}
                         
                        ?>   
    
</tbody>
<p>

</table>


</div>
</div>
    
         <div class="container col-md-8" style="border-radius:10px">
            <h1>Nombre d'étudiants par tuteur:</h1>
<div class="table-responsive">

<table class="table table-hover table-bordered">


<thead>

<th>uid</th>

<th>Nom tuteurP actif</th>

<th>Prenom tuteurP actif</th>
    
<th>Nombre d'etudiants dont il est principal pour la soutenance</th>
    
<th>Nombre d'etudiants dont il est secondaire pour la soutenance</th>
    

</thead>



<tbody>
                        <?php 
                     
                         
                       $sql ="SELECT uid,nom,prenom FROM users INNER JOIN stages ON users.uid=tuteurP WHERE role <> 'admin' AND YEAR(dateDebut)=?";
    
                     $q=$db->prepare($sql);
                        $q->execute(array($newDate));
                        $row = $q->fetch(PDO::FETCH_ASSOC);
                        if($row){
                            
                            while($row){
                                $compte=$db->query("SELECT tuteur1, COUNT(*) AS nbre_apparition FROM soutenances WHERE tuteur1=".$row['uid']."");
                                $tab = $compte->fetch(PDO::FETCH_ASSOC);
                                $compte2=$db->query("SELECT tuteur2, COUNT(*) AS nbre_apparition2 FROM soutenances WHERE tuteur2=".$row['uid']."");
                                $tab2 = $compte2->fetch(PDO::FETCH_ASSOC);
                                echo '<tr>';
                           echo '<tr>';
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo'<td>' . $row['uid'] . '</td><p>';
                                
                            echo'<td>' . $row['nom'] . '</td><p>';
                                
                            echo'<td>' . $row['prenom'] . '</td><p>';
                                
                            echo'<td>' . $tab['nbre_apparition'] . '</td><p>';
                            
                            echo'<td>' . $tab2['nbre_apparition2'] . '</td><p>';
                            
                     echo '<td>';
                              
                                
                                 echo '<td>';
                
                            echo '</td><p>';
                            echo '</tr><p>';
        
                                   $row=$q->fetch();
                            }
                        }
                        
                        while($row=$q->fetch()){
                    echo '<tr>';
                           echo '<tr>';
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo'<td>' . $row['uid'] . '</td><p>';
                                
                            echo'<td>' . $row['nom'] . '</td><p>';
                                
                            echo'<td>' . $row['prenom'] . '</td><p>';
                                
                            echo'<td>' . $tab['nbre_apparition'] . '</td><p>';
                            
                            echo'<td>' . $tab2['nbre_apparition2'] . '</td><p>';
                            
                     echo '<td>';
                              
                                
                                 echo '<td>';
                
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

<?php }else{
    
    redirect("login_form.php");
}
