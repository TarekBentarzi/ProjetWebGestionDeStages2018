 <?php include('header.php');
include("db_config.php");

$db = new PDO($dsn,$username,$password);



if($_SERVER["REQUEST_METHOD"]== "POST" && !empty($_POST)){ //on initialise nos messages d'erreurs; 
      $sidError='';  
     // on recupère nos valeurs 
     $sid = htmlentities(trim($_POST['sid']));
    $mail = htmlentities(trim($_POST['mail']));
     // on vérifie nos champs 
     $valid = true;  if(empty($sid)){ $sidError ='Entrez un sid'; $valid= false; }
    if(empty($mail)){ $mailError ='Entrez un mail'; $valid= false; }
    $sql="SELECT email FROM etudiants INNER JOIN stages ON stages.eid=etudiants.eid WHERE sid=?";
    $q=$db->prepare($sql);
    $q->execute(array($_POST['sid']));
    $row = $q->fetch(PDO::FETCH_ASSOC);
     // si les données sont présentes et bonnes, on se connecte à la base
    if($row['email']==$_POST['mail']){
     if ($valid) { 
      
       ?>  
         <div class="container col-md-8 offset-md-3" style="border-radius:10px">
    <h1>Vos informations de soutenance :</h1>
<div class="table-responsive">

<table class="table table-hover table-bordered">

<thead>
    <th>sid</th>

<th>nom tuteur principal</th>

<th>nom tuteur secondaire</th>

<th>date</th>

<th>salle</th>



</thead>



<tbody>
                        <?php 
                      $tuteur2 = "SELECT sid,nom FROM soutenances INNER JOIN users ON users.uid=soutenances.tuteur2 WHERE sid=?";
                    $l=$db->prepare($tuteur2);
                    $l->execute(array($sid));
                    $row2 = $l->fetch(PDO::FETCH_ASSOC);
                         
                     $sql = "SELECT sid,nom,tuteur2,date,salle FROM soutenances INNER JOIN users ON users.uid=soutenances.tuteur1 WHERE sid=?";
                    $q=$db->prepare($sql);
                    $q->execute(array($sid));
                    $row = $q->fetch(PDO::FETCH_ASSOC);
                        if($row){
                            
                            while($row){
                            
                                echo '<tr>';
                           echo '<tr>';
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                                echo'<td>' . $row['sid'] . '</td><p>';
                            echo'<td>' . $row['nom'] . '</td><p>';
                                
                            echo'<td>' . $row2['nom'] . '</td><p>';
                            echo'<td>' . $row['date'] . '</td><p>';
                            echo'<td>' . $row['salle'] . '</td><p>';

                            echo '</td><p>';
                            echo '</tr><p>';
        
                                   $row=$q->fetch();
                                   
                            }
                        }
      
?>
                 
</tbody>
<p>

</table>


</div>
</div> 
 <div class="container col-md-8 offset-md-3" style="border-radius:10px">
    <h1>Vos resultats :</h1>
<div class="table-responsive">

<table class="table table-hover table-bordered">
<thead>
    <th>sid</th>
<th>note</th>
    
<th>commentaire</th>


</thead>



<tbody>
                        <?php 
                        
                         
                     $sql = "SELECT notes.sid,note,commentaire FROM notes INNER JOIN soutenances ON notes.sid=soutenances.sid WHERE notes.sid=?";
                    $q=$db->prepare($sql);
                    $q->execute(array($sid));
                    $row = $q->fetch(PDO::FETCH_ASSOC);
                        if($row){
                            
                            while($row){
                            
                                echo '<tr>';
                           echo '<tr>';
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                                echo'<td>' . $row['sid'] . '</td><p>';
                            echo'<td>' . $row['note'] . '</td><p>';
                                
                            echo'<td>' . $row['commentaire'] . '</td><p>';

                            echo '</td><p>';
                            echo '</tr><p>';
        
                                   $row=$q->fetch();
                                   
                            }
                        }
                        
  
     echo "infos du sid ".$sid; 
     }}else{
        echo "erreur mail ou sid";
    }
   
    }?>
                 
</tbody>
<p>

</table>

 <a href="noteEtudiant.php">retour</a>  
</div>
</div>    
                    

 <body class="backHome">
        <div class="row">
 <div class="vertical-menu col-md-2">
  <a href="Etudiant.php" class="active">Accueil</a>
  <a href="noteEtudiant.php">Consulter vos notes de soutenances</a>
  <a href="listeSout.php">Liste des soutenances</a>
  
</div>