<?php
session_start();
include('header.php');
include("db_config.php");

$db = new PDO($dsn,$username,$password);
 if(!empty($_GET['id'])){
 if ($_SESSION['newToken'] == $_GET['token']) {
    ?>

<body class="backHome">
    <script type="text/javascript">
     function soumettre()
     {
     document.forms['formulaire'].submit();
     }
</script>
    <div class="formul">
<label>Selectionnez l'année a consulter</label>
<p> <form name="formulaire" method="POST" action="gestionnaire?id=12&token=<?php echo $_SESSION['newToken'];?>">
                    <select name="newDate" class="form-control"  onchange="soumettre()">
<?php
$reponse = $db->query('SELECT DISTINCT YEAR(date) FROM soutenances ORDER BY YEAR(date) ASC') ; 
    $donnees=$reponse->fetch();
                       ?>  <option value="0" selected>choisissez une date</option> <?php
            while($donnees){
                
               ?> <option value="<?php echo $donnees['YEAR(date)']; ?>"> <?php echo $donnees['YEAR(date)']; ?></option>
                        <?php
                $donnees=$reponse->fetch();
            }
                        
 
while ($donnees = $reponse->fetch()) {?>
 
    <option value="<?php echo $donnees['YEAR(date)']; ?>"> <?php echo $donnees['YEAR(date)']; ?></option>
                 
                <?php   
                }  
 
                ?>          
                 
                    </select>
</form>
</div>
<div class="container col-md-8 offset-md-0" style="border-radius:10px">
    <h1>Notes Etudiants</h1>
<div class="table-responsive">

<table class="table table-hover table-bordered">


<thead>

    
<th>nom</th>

<th>prenom</th>

<th>note</th>

<th>date</th>


</thead>



<tbody>
                        <?php 
                       if(isset($_POST['newDate'])){
                           $newDate=$_POST['newDate'];
                           
                       }else{
                           $newDate=2018;
                       }
     
                       $statement ="SELECT nom,prenom,note,date FROM etudiants INNER JOIN stages ON etudiants.eid=stages.eid INNER JOIN soutenances ON stages.sid=soutenances.sid INNER JOIN notes ON soutenances.sid=notes.sid WHERE YEAR(date)=?";
                          $q=$db->prepare($statement);
                        $q->execute(array($newDate));
                        $row = $q->fetch(PDO::FETCH_ASSOC);
                        
                        if($row){
                            while($row){
                                
                             echo '<tr>';
                         
                            echo'<td>' . $row['nom'] . '</td><p>';
                            echo'<td>' . $row['prenom'] . '</td><p>';
                            echo'<td>' . $row['note'] . '</td><p>';
                            echo'<td>' . $row['date'] . '</td><p>';
              
                            echo '<td>';
                            // un autre td pour le bouton de suppression
                            echo '</td><p>';
                            echo '</tr><p>';
                                $row=$q->fetch();
                            }
                            
                        }
                        while($row=$q->fetch()){
                    
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                      
                            echo'<td>' . $row['nom'] . '</td><p>';
                            echo'<td>' . $row['prenom'] . '</td><p>';
                            echo'<td>' . $row['note'] . '</td><p>';
                            echo'<td>' . $row['date'] . '</td><p>';
                            echo '<td>';
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



</body>




<?php
 }
 }else{
     header('Location: index.php');
 }
?>