<?php

require("auth/EtreAuthentifie.php");
include('header.php');
include("db_config.php");
$db = new PDO($dsn,$username,$password);


$user=$idm->getUid();
$login=$idm->getIdentity();

$id = null; 
if (!empty($_GET['id'])) { 
    $id = $_REQUEST['id']; } 

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
    
     
    
<?php 
    
    
    
if(isset($_POST['note']) && isset ($_POST['commentaire'])){
    
    $compt = $db->prepare("SELECT COUNT(*) As nb FROM notes WHERE sid = ?"); // Préparation de la requète qui va compter combien de fois la valeur de la liste[0] est présente dans la base
    $compt->execute(array($id));
    $donnees = $compt->fetch();
    
    if($donnees['nb'] == 0) {
    
       
                    $noteError='';
                    $commentError='';
                    $note = htmlentities(trim($_POST['note']));
                    $comment=htmlentities(trim($_POST['commentaire']));
                    echo "".$_POST['note'];
                    echo "".$_POST['commentaire'];
                 //on appelle notre fichier de config 

                    if (empty($note)) { $noteError = 'Veuillez entrer une note'; }
                    if (empty($note)) { $commentError = 'Veuillez entrer une commentaire'; }


                    //on lance la connection et la requete 
                    $sql =$db->prepare("INSERT INTO notes(sid,note,commentaire) VALUES (:sid,:note,:commentaire)");
                    $sql->execute(array(
                                    'sid' => $id,
                                    'note' => $note,
                                    'commentaire' => $comment,
                                  ));
                                         
                    //echo "la nouvelle note est ".$note;
          ?>
            <div id="dialog" title="Erreur">
            <p>la nouvelle note est :<?php echo "".$note ?></p>
            </div> 
             <?php
    }else{

         ?>
            <div id="dialog" title="Erreur">
            <p>erreur cette etudiant a deja une note pour la modifiée veuillez consulter le tableau du bas</p>
            </div> 
             <?php
    }
 
 
}
    
if(isset($_POST['mod'])){
    $modError='';
    $mod = htmlentities(trim($_POST['mod']));
    echo "".$mod;
    $valid = true; 
    if (empty($mod)) { $modError = 'Veuillez entrer une note';$valid=false; }
    if($valid){
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) .
    $modnote ="UPDATE notes SET note=? WHERE sid=?";
    $q = $db->prepare($modnote);
    $q->execute(array($mod,$id));
    
    //echo "note changée";
    ?>
            <div id="dialog" title="">
            <p>note changée!</p>
            </div> 
             <?php
}else{
     ?>
            <div id="dialog" title="Erreur">
            <p>formulaire de note vide</p>
            </div> 
             <?php
    }
    
}
if(isset($_POST['modCom'])){
    $modComError='';
    $modCom = htmlentities(trim($_POST['modCom']));
    echo "commentaire modifié ".$modCom;
    $valid = true; 
    if (empty($modCom)) { $modComError = 'Veuillez entrer une note';$valid=false; }
    if($valid){
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) .
    $modComment ="UPDATE notes SET commentaire=? WHERE sid=?";
    $q = $db->prepare($modComment);
    $q->execute(array($modCom,$id));
    
             ?>
            <div id="dialog" title="">
            <p>commentaire changé!</p>
            </div> 
             <?php
}else{
     ?>
            <div id="dialog" title="Erreur">
            <p>formulaire de commentaire vide</p>
            </div> 
             <?php
    
}
}


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
            <h3>Soutenances terminées dans lesquels vous etes le responsable:</h3>
<div class="table-responsive">

<table class="table table-hover table-bordered">


<thead>

<th>stid</th>

<th>sid</th>

<th>tuteur1</th>
    
<th>tuteur2</th>
    
<th>salle</th>
    
<th>date</th>

<th>note et commentaire</th>
    

</thead>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#dialog" ).dialog();
  } );
  </script>
        


<tbody>
                        <?php 
                       

                         if($on==1){
                       $sql = "SELECT * FROM soutenances WHERE sid IN (SELECT sid FROM soutenances WHERE YEAR(date)=? AND tuteur1=?)";
                        $q=$db->prepare($sql);
                        $q->execute(array($_SESSION['gardeT'],$user));
    
                        $row = $q->fetch(PDO::FETCH_ASSOC);
                        if($row){
                            
                            while($row){
                            
                                echo '<tr>';
                           echo '<tr>';
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo'<td>' . $row['stid'] . '</td><p>';
                                
                            echo'<td>' . $row['sid'] . '</td><p>';
                                
                            echo'<td>' . $row['tuteur1'] . '</td><p>';
                            
                            echo'<td>' . $row['tuteur2'] . '</td><p>';
                                
                            echo'<td>' . $row['salle'] . '</td><p>';
                                
                            echo'<td>' . $row['date'] . '</td><p>';
                            echo '<td>';
                              echo '<form action="NotesSout.php?id='.$row['sid'].'" method="post">
                                <input type="number" name="note" placeholder="note"/>
                                <input type="text" name="commentaire" placeholder="commentaire" />
                                <input type="submit" value="ajouter note et commentaire" 
                                     name="Submit" id="frm1_submit" />
                            </form>';
                                echo '</td>';
                            
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
                            echo'<td>' . $row['stid'] . '</td><p>';
                                
                            echo'<td>' . $row['sid'] . '</td><p>';
                                
                            echo'<td>' . $row['tuteur1'] . '</td><p>';
                            
                            echo'<td>' . $row['tuteur2'] . '</td><p>';
                                
                            echo'<td>' . $row['date'] . '</td><p>';
                                
                            echo'<td>' . $row['salle'] . '</td><p>';
                            
                     echo '<td>';
                               echo '<form action="NotesSout.php?id='.$row['sid'].'" method="post">
                                <input type="number" name="note" placeholder="note"/>
                                <input type="text" name="commentaire" placeholder="commentaire" />
                                <input type="submit" value="ajouter note et commentaire" 
                                     name="Submit" id="frm1_submit" />
                            </form>'; 
                         
                                echo '</td>';

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
    
<div class="container col-md-8" style="border-radius:10px">
            <h3>Etudiants deja notés:</h3>
<div class="table-responsive">

<table class="table table-hover table-bordered">


<thead>

<th>nid</th>

<th>sid</th>

<th>note</th>
    
<th>commentaire</th>
    
<th>modifié note ou commentaire</th>
    

</thead>



<tbody>
                        <?php 

                         
                       $sql = "SELECT * FROM notes WHERE sid IN (SELECT sid FROM soutenances WHERE YEAR(date)=? AND tuteur1=?)" ;
                        $q=$db->prepare($sql);
                        $q->execute(array($_SESSION['gardeT'],$user));
                        $row = $q->fetch(PDO::FETCH_ASSOC);
                        if($row){
                            
                            while($row){
                            
                                echo '<tr>';
                           echo '<tr>';
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo'<td>' . $row['nid'] . '</td><p>';
                                
                            echo'<td>' . $row['sid'] . '</td><p>';
                                
                            echo'<td>' . $row['note'] . '</td><p>';
                            
                            echo'<td>' . $row['commentaire'] . '</td><p>';
                           
                     echo '<td>';
                               echo '<form action="NotesSout.php?id='.$row['sid'].'" method="post">
                                <input type="number" placeholder="modifier note" name="mod" />
                                <input type="submit" value="modifié note" 
                                     name="Submit" id="frm1_submit" /></form>';
                             echo '</td>';
                            echo '<td>';
                             echo '<form action="NotesSout.php?id='.$row['sid'].'" method="post">
                                <input type="text" name="modCom" placeholder="modifié commentaire" />
                                <input type="submit" value="ajouter commentaire" 
                                     name="Submit" id="frm1_submit" />';
                                
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
                            echo'<td>' . $row['stid'] . '</td><p>';
                                
                            echo'<td>' . $row['sid'] . '</td><p>';
                                
                            echo'<td>' . $row['tuteur1'] . '</td><p>';
                            
                            echo'<td>' . $row['tuteur2'] . '</td><p>';
                                
                            echo'<td>' . $row['date'] . '</td><p>';
                                
                            echo'<td>' . $row['salle'] . '</td><p>';
                            
                     echo '<td>';
                              
                            echo '<form action="NotesSout.php?id='.$row['sid'].'" method="post">
                                <input type="number" placeholder="modifier note" name="mod" />
                                <input type="submit" value="modifié note" 
                                     name="Submit" id="frm1_submit" /></form>';
                             echo '</td>';
                            echo '<td>';
                             echo '<form action="NotesSout.php?id='.$row['sid'].'" method="post">
                                <input type="text" name="modCom" placeholder="modifié commentaire" />
                                <input type="submit" value="modifier commentaire" 
                                     name="Submit" id="frm1_submit" />';
                                echo '</td>';

                                 echo '<td>';
                
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

<?php } else{
    
    redirect("login_form.php");
                            
                        }