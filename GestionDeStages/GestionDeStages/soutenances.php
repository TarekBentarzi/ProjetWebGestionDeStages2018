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

echo "".$id;
    
    
  ?>  
    
    
   <script type="text/javascript">
     function soumettre()
     {
     document.forms['formulaire'].submit();
     }
</script>


   
    
<?php
//donner un tuteur pedagigique a un etudiant
//Verification que le numero du tuteur est valide
if(isset($_POST['modDate'])){
    
                    $dateError='';
                    $date = htmlentities(trim(date("Y-m-d", strtotime($_POST['modDate']))));
                 //on appelle notre fichier de config 

                   $valid=true; if (empty($_POST['modDate'])) { $dateError = 'Veuillez entrer une date'; $valid=false;}

                    if($valid){
                    //on lance la connection et la requete 
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) .
                    $sql = "UPDATE soutenances SET date=? WHERE sid=?";
                    $q = $db->prepare($sql);
                    $q->execute(array($date,$id));
                   // header("location:admin.php");    
                       ?>
            <div id="dialog" title="">
            <p>la nouvelle date est  : <?php echo "".$_POST['modDate'] ?></p>
            </div> 
             <?php
                    }else{
                        ?>
            <div id="dialog" title="Erreur">
            <p>formulaire de date vide</p>
            </div> 
             <?php
                    }
    
    
}

if(isset($_POST['modSalle'])){
            
                    $salleError='';
                    $salle = htmlentities(trim($_POST['modSalle']));
                    echo "".$_POST['modSalle'];
                 //on appelle notre fichier de config 

                   $valid=true; if (empty($_POST['modSalle'])) { $salleError = 'Veuillez entrer une salle'; $valid=false;}

                    if($valid){
                    //on lance la connection et la requete 
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) .
                    $sql = "UPDATE soutenances SET salle=? WHERE sid=?";
                    $q = $db->prepare($sql);
                    $q->execute(array($salle,$id));
                   // header("location:admin.php");    
                             ?>
            <div id="dialog" title="">
            <p>la nouvelle salle est  : <?php echo "".$_POST['modSalle'] ?></p>
            </div> 
             <?php
                    }else{
                        ?>
            <div id="dialog" title="Erreur">
            <p>formulaire de salle vide</p>
            </div> 
             <?php
                    }
    
    
}

if(isset($_POST['dateSout']) && isset($_POST['salleSout']) && isset($_POST['tutSec'])){
    
    
      $compt = $db->prepare("SELECT COUNT(*) As nbtype FROM users WHERE uid = ?"); // Préparation de la requète qui va compter combien de fois la valeur de la liste[0] est présente dans la base
    $compt->execute(array($_POST['tutSec']));
    $donnees = $compt->fetch();
    
    if($donnees['nbtype'] > 0) {
    
    
                    
                    $tuteurP="SELECT tuteurP FROM stages WHERE sid=?";
                    $q=$db->prepare($tuteurP);
                    $q->execute(array($id));
                    $row = $q->fetch(PDO::FETCH_ASSOC);
                    
                    echo "".$row['tuteurP'];
                    

                    ;
                    $dateError='';
                    $salleError='';
                    $tutSError='';
                    $tutP=htmlentities(trim($row['tuteurP']));
                    $date=htmlentities(trim($_POST['dateSout']));
                    echo "".$date;
                    $salle = htmlentities(trim($_POST['salleSout']));
                    $tutS=htmlentities(trim($_POST['tutSec']));
                    
                 //on appelle notre fichier de config 

                    if (empty($date)) { $dateError = 'Veuillez entrer une date'; }
                    if (empty($tutS)) { $tutSError = 'Veuillez entrer un tuteur'; }
                    if (empty($salle)) { $salleError = 'Veuillez entrer une salle'; }
                    //on lance la connection et la requete 
                    
                    $sql = $db->prepare("INSERT INTO soutenances (sid,tuteur1,tuteur2,date,salle) VALUES (:sid,:tuteur1,:tuteur2,:date,:salle)");
                    $sql->execute(array(
                                    'sid' => $id,
                                    'tuteur1' => $tutP,
                                    'tuteur2' => $tutS,
                                    'date' => $date,
                                    'salle' => $salle,
                                  ));
                                           // header("location:admin.php");    
    
}else{
        echo "Ce tuteur est inexistant";
    }
}











?>
<body class="backHome">
<div class="row">
   <div class="vertical-menu col-md-2">
  <a href="home_admin.php" class="active">Home</a>
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
    
<script type="text/javascript">
    DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss");
    $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh::ii'});
</script>    
<div class="container col-md-8 offset-md-0" style="border-radius:10px">
    <h1>Etudiants ayant deja une date/salle de soutenance</h1>
<div class="table-responsive">

<table class="table table-hover table-bordered">


<thead>
    
<th>stid</th>
    
<th>sid</th>

<th>tuteur1</th>

<th>tuteur2</th>

<th>date</th>

<th>salle</th>


</thead>



<tbody>
                        <?php 
                       
                         
                       $statement = "SELECT stid,soutenances.sid,tuteur1,tuteur2,salle,date FROM soutenances INNER JOIN stages ON soutenances.sid=stages.sid WHERE YEAR(dateDebut)=? ORDER BY date,tuteur1,tuteur2";
    
                        $q=$db->prepare($statement);
                        $q->execute(array($_SESSION['garde']));
                        $row = $q->fetch(PDO::FETCH_ASSOC);
                        
                        if($row){
                            while($row){
                                
                             echo '<tr>';
                            echo'<td>' . $row['stid'] . '</td><p>';
                            echo'<td>' . $row['sid'] . '</td><p>';
                            echo'<td>' . $row['tuteur1'] . '</td><p>';
                            echo'<td>' . $row['tuteur2'] . '</td><p>';
                            echo'<td>' . $row['date'] . '</td><p>';
                            echo'<td>' . $row['salle'] . '</td><p>';
                            echo '<td>';
                              echo '<form action="soutenances.php?id='.$row['sid'].'" method="post">
                                <input type="date" placeholder="modifier date" name="modDate" />
                                <input type="submit" value="valider nouvelle date" 
                                     name="Submit" id="frm1_submit" /></form>';
                            echo '<form action="soutenances.php?id='.$row['sid'].'" method="post">
                                <input type="text" placeholder="modifier salle" name="modSalle" />
                                <input type="submit" value="valider nouvelle salle" 
                                     name="Submit" id="frm1_submit" /></form>';
                            echo '<a class="btn btn-danger" href="delSout.php?id=' . $row['sid'] . ' ">Supprimer soutenance</a>';
                            // un autre td pour le bouton de suppression
                            echo '</td><p>';
                            echo '</tr><p>';
                                $row=$q->fetch();
                            }
                            
                        }
                        while($row=$q->fetch()){
                    
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo'<td>' . $row['stid'] . '</td><p>';
                            echo'<td>' . $row['sid'] . '</td><p>';
                            echo'<td>' . $row['tuteur1'] . '</td><p>';
                            echo'<td>' . $row['tuteur2'] . '</td><p>';
                            echo'<td>' . $row['date'] . '</td><p>';
                            echo'<td>' . $row['salle'] . '</td><p>';
                            echo '<td>';
                            echo '<form action="soutenances.php?id='.$row['sid'].'" method="post">
                                <input type="date" placeholder="modifier date" name="modDate" />
                                <input type="submit" value="valider nouvelle date" 
                                     name="Submit" id="frm1_submit" /></form>';
                            echo '<form action="soutenances.php?id='.$row['sid'].'" method="post">
                                <input type="text" placeholder="modifier salle" name="modSalle" />
                                <input type="submit" value="valider nouvelle salle" 
                                     name="Submit" id="frm1_submit" /></form>';
                            echo '<a class="btn btn-danger" href="delSout.php?id=' . $row['sid'] . ' ">Supprimer soutenance</a>';
                            // un autre td pour le bouton de suppression
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
    
    <div class="container col-md-8" style="border-radius:10px">
            <h1>Etudiants sans date/salle de soutenance</h1>
<div class="table-responsive">

<table class="table table-hover table-bordered">


<thead>

<th>sid</th>

<th>Date,salle et tuteur secondaire</th>
    

</thead>



<tbody>
                        <?php 

                         
                       $sql = "SELECT sid FROM stages WHERE YEAR(dateDebut)=? AND sid NOT IN (SELECT sid FROM soutenances)";
                        $q=$db->prepare($sql);
                        $q->execute(array($_SESSION['garde']));
                        $row = $q->fetch(PDO::FETCH_ASSOC);
                        if($row){
                            while($row){
                                echo '<tr>';
                           echo '<tr>';
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo'<td>' . $row['sid'] . '</td><p>';
                     echo '<td>';
                              echo '<form action="soutenances.php?id='.$row['sid'].'" method="post">
                                <input type="datetime" name="dateSout" placeholder="date format: y-m-d  h::m::s"/>
                                <input type="text" name="salleSout" placeholder="attribuer salle" />
                                <input type="number" name="tutSec" placeholder="attribuer tuteur secondaire" />
                                <input type="submit" value="ajouter date,salle,tuteur secondaire" 
                                     name="Submit" id="frm1_submit" />
                            </form>';//AJOUTER TUTEUR
                                
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
                               echo '<form action="soutenances.php?id='.$row['sid'].'" method="post">
                                <input type="datetime" name="dateSout" placeholder="attribuer date"/>
                                <input type="text" name="salleSout" placeholder="attribuer salle" />
                     <input type="number" name="tutSec" placeholder="attribuer tuteur secondaire" />
                                <input type="submit" value="ajouter date,salle,tuteur secondaire" 
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
     }else{
      $error = 'mauvais identifiant ou mot de passe';
header("Location: login_form.php?erreur=" . $error);  
}