

<?php
session_start();
include("header.php");
include("db_config.php");

$error = "";




$db = new PDO($dsn,$username,$password);



// Vérification si l'utilisateur existe
$SQL = "SELECT eid FROM etudiants WHERE nom=?";
$stmt = $db->prepare($SQL);
$res = $stmt->execute([$_SESSION['nom']]);

if ($res && $stmt->fetch()) {
    $error .= "Nom déjà existant";
}

foreach (['titreStage','details','nomEntreprise','nomTE','mailTE','dateDebut','dateFin'] as $stage){

    $dataStage[$stage]=$_SESSION[$stage];
}



foreach (['nom', 'prenom', 'mailEtudiant', 'numTelEtudiant'] as $etudiant) {
    $clearData[$etudiant] = $_SESSION[$etudiant];
}


try {
    $SQL = "INSERT INTO etudiants(nom,prenom,email,tel) VALUES (:nom,:prenom,:mailEtudiant,:numTelEtudiant)";
    $stmt = $db->prepare($SQL);
    $res = $stmt->execute($clearData);
    $id = $db->lastInsertId();
} catch (\PDOException $r) {
    http_response_code(500);
    echo "Erreur de serveur.".$r;
    exit();
}


try{
    
    $SQL = "INSERT INTO stages(eid,titre,description,entreprise,tuteurE,emailTE,tuteurP,dateDebut,dateFin) VALUES ($id,:titreStage,:details,:nomEntreprise,:nomTE,:mailTE,NULL,:dateDebut,:dateFin)";
    $stmt = $db->prepare($SQL);
    $res = $stmt->execute($dataStage);
        $g=$id;
    ?>

    <h4>
<?php
     echo "Utilisateur $clearData[nom] : ajouté avec succès.\n";
    ?></h4>
        <?php
}
catch (\PDOException $t) {
    http_response_code(500);
    echo "Erreur de serveur.".$t;
    exit();
}



$statement ="SELECT sid FROM stages WHERE eid=?";
  $q=$db->prepare($statement);
  $q->execute(array($g));
$row = $q->fetch(PDO::FETCH_ASSOC);
?>

   <h4>
<?php
echo "votre référence de dossier est : ".htmlentities($row['sid'])." veuillez l'utiliser pour consulter vos informations";



?></h4> 