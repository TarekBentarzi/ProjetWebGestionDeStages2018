<?php

require("auth/EtreAuthentifie.php");
include('header.php');
include("db_config.php");
$db = new PDO($dsn,$username,$password);

if(!$_COOKIE['PHPSESSID']){
    setcookie('PHPSESSID', session_id(), (time()+2678400));
}else{
    session_regenerate_id();
    setcookie('PHPSESSID', session_id(), (time()+2678400));
}


$user=$idm->getUid();
$login=$idm->getIdentity();

echo "bienvenue ".$login." ";
if ($_SESSION["role"]=='user')
{
                        $actif="SELECT actif FROM users WHERE uid=?";
                        $q=$db->prepare($actif);
                        $q->execute(array($user));
                        $act=$q->fetch(PDO::FETCH_ASSOC);
                        if ($act['actif']==1){
                            echo "vous avez un compte actif";
                        }else{
                            echo "compte inactif";
                        }
$on=$act['actif'];
    
    
    
    
     ?>  
    
    
   <script type="text/javascript">
     function soumettre()
     {
     document.forms['formulaire'].submit();
     }
</script>

<div class="formul">
<label>Selectionnez l'année a consulter</label>
<p> <form name="formulaire" method="POST" action="ResponsableEtTuteurs.php">
                    <select name="newDate" class="form-control"  onchange="soumettre()">
<?php
$reponse = $db->query('SELECT DISTINCT YEAR(dateDebut) FROM stages ORDER BY YEAR(dateDebut) ASC') ; 
    $donnees=$reponse->fetch();
    $_SESSION['gardeT']=$_POST['newDate'];
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
     
    
    
    
    
    
    

?>

<body class="backHome">
    <div class="row">
<div class="vertical-menu col-md-2">
  <a href="ResponsableEtTuteurs.php" class="active">Accueil</a>
  <a href="NotesSout.php">modifier notes/commentaires soutenances</a>
  <a href="modifMdp.php">Modifier votre mot de passe</a>
  <a href="<?= $pathFor['logout'] ?>">Logout</a>
  
</div>

             <div class="container col-md-8 offset-md-0" style="border-radius:10px">
            <h3>Etudiants pris en charge en tant que tuteur pedagogique:</h3>
<div class="table-responsive">

<table class="table table-hover table-bordered">


<thead>

<th>eid</th>

<th>Nom etudiant</th>
    
<th>Prenom etudiant</th>
    

</thead>



<tbody>
    
    
                        <?php 
        if(isset($_POST['newDate'])){
            
            $newDate=$_POST['newDate'];
        }else{
            $newDate=2018;
        }
        
                        if($on==1){   
                      
                       $sql = "SELECT eid,nom,prenom FROM etudiants WHERE eid IN (SELECT eid FROM stages WHERE YEAR(dateDebut)=? AND tuteurP IN (SELECT uid FROM users WHERE login=?))";
                        $q=$db->prepare($sql);
                        $q->execute(array($newDate,$login));
                        $row = $q->fetch(PDO::FETCH_ASSOC);
                        if($row ){
                            
                            while($row){
                                echo '<tr>';
                           echo '<tr>';
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo'<td>' . $row['eid'] . '</td><p>';
                                
                            echo'<td>' . $row['nom'] . '</td><p>';
                                
                            echo'<td>' . $row['prenom'] . '</td><p>';
                                
                                
                            
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
            <h3>Etudiants pris en charge en tant que tuteur principal pour la soutenance:</h3>
<div class="table-responsive">

<table class="table table-hover table-bordered">


<thead>

<th>eid</th>

<th>Nom etudiant</th>
    
<th>Prenom etudiant</th>
    

</thead>



<tbody>
                        <?php 

                         
                        $sql ="SELECT eid,nom,prenom FROM etudiants WHERE eid IN (SELECT eid FROM stages WHERE YEAR(dateDebut)=? AND  sid IN (SELECT sid FROM soutenances WHERE tuteur1=?))";
                        $q=$db->prepare($sql);
                        $q->execute(array($newDate,$user));
                        $row = $q->fetch(PDO::FETCH_ASSOC);
                        if($row){
                            
                            while($row){
                                echo '<tr>';
                           echo '<tr>';
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo'<td>' . $row['eid'] . '</td><p>';
                                
                            echo'<td>' . $row['nom'] . '</td><p>';
                                
                            echo'<td>' . $row['prenom'] . '</td><p>';
                                
                                
                            
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
    
<div class="container col-md-8" style="border-radius:10px margin-left:10px">
            <h3>Etudiants pris en charge en tant que tuteur secondaire pour la soutenance:</h3>
<div class="table-responsive">

<table class="table table-hover table-bordered">


<thead>

<th>eid</th>

<th>Nom etudiant</th>
    
<th>Prenom etudiant</th>
    

</thead>



<tbody>
                        <?php 

                        $sql = "SELECT eid,nom,prenom FROM etudiants WHERE eid IN (SELECT eid FROM stages WHERE YEAR(dateDebut)=? AND  sid IN (SELECT sid FROM soutenances WHERE tuteur2=?))";
                        $q=$db->prepare($sql);
                        $q->execute(array($newDate,$user));
                        $row = $q->fetch(PDO::FETCH_ASSOC);
                        
                        if($row){
                            
                            while($row){
                                echo '<tr>';
                           echo '<tr>';
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo'<td>' . $row['eid'] . '</td><p>';
                                
                            echo'<td>' . $row['nom'] . '</td><p>';
                                
                            echo'<td>' . $row['prenom'] . '</td><p>';
                                
                                
                            
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
                        }
                        ?>   
    
</tbody>
<p>

</table>


</div>
</div>
    </div>
    </body>

<?php  } else{
    
    redirect("login_form.php");
                            
                        }
    ?>