<?php

include('header.php');
include("db_config.php");

$db = new PDO($dsn,$username,$password);

?>


 <div class="vertical-menu col-md-2">
  <a href="Etudiant.php" class="active">Accueil</a>
  <a href="noteEtudiant.php">Consulter vos notes de soutenances</a>
  <a href="listeSout.php">Liste des soutenances</a>
  
</div>

<body class="backHome">
<div class="container col-md-10" style="border-radius:10px">
    <h1>Etudiants ayant deja une date/salle de soutenance</h1>
<div class="table-responsive">

<table class="table table-hover table-bordered">


<thead>
    
<th>nom</th>
    
<th>prenom</th>

<th>nom tuteur principal</th>

<th>prenom tuteur principal</th>

<th>salle</th>

<th>date</th>


</thead>



<tbody>
                        <?php 

                         
                       $statement = $db->query('SELECT etudiants.nom AS nomEtudiant,etudiants.prenom AS prenomEtudiant,users.nom AS nomTuteur1,users.prenom AS prenomTuteur1,salle,date FROM etudiants INNER JOIN stages ON etudiants.eid=stages.eid INNER JOIN soutenances ON stages.sid=soutenances.sid INNER JOIN users ON soutenances.tuteur1=users.uid WHERE YEAR(date)=YEAR(NOW()) ORDER BY etudiants.nom');
    
                        $row = $statement->fetch(PDO::FETCH_ASSOC);
                        
                        if($row){
                            while($row){
                                
                             echo '<tr>';
                            echo'<td>' . $row['nomEtudiant'] . '</td><p>';
                            echo'<td>' . $row['prenomEtudiant'] . '</td><p>';
                            echo'<td>' . $row['nomTuteur1'] . '</td><p>';
                            echo'<td>' . $row['prenomTuteur1'] . '</td><p>';
                            echo'<td>' . $row['salle'] . '</td><p>';
                            echo'<td>' . $row['date'] . '</td><p>';
                            echo '<td>';
                            // un autre td pour le bouton de suppression
                            echo '</td><p>';
                            echo '</tr><p>';
                                $row=$statement->fetch();
                            }
                            
                        }
                        while($row=$statement->fetch()){
                    
                             //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo'<td>' . $row['nomEtudiant'] . '</td><p>';
                            echo'<td>' . $row['prenomEtudiant'] . '</td><p>';
                            echo'<td>' . $row['nomUser'] . '</td><p>';
                            echo'<td>' . $row['prenomUser'] . '</td><p>';
                            echo'<td>' . $row['salle'] . '</td><p>';
                            echo'<td>' . $row['date'] . '</td><p>';
                            echo '<td>';
                            // un autre td pour le bouton de suppression
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
    </body>