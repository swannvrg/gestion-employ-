<?php
session_start();
require_once '../persistance/connexion.php';

$connexion = Connexion::getConnexion();
$matricule = $_SESSION['Matricule'];

$sqlSuppr = "DELETE FROM employe WHERE  matricule=$matricule";
$sql = $connexion->prepare($sqlSuppr);
$sql->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-secondary dp-flex text-center row">
<?php
        if ($sql->execute()) {
    ?>
    <h1 class="text-light p-3"> Suppression  réussi ! </h1>
    <div class="container bg-light rounded col-10 col-lg-6 p-4">
         <div>
            <p>La suppression de l'employé à été réalisé avec succés</p>
        </div>
        <div>
            <a href="../suppression/suppr.php" class="btn btn-primary mt-2">Supprimer un  autre employé</a>

            <a href="../presentation/listeEmployes.php" class="btn btn-primary mt-2">Liste des employés</a>
            <a href="../index.php" class="btn btn-warning mt-2">Retour au menu</a>
        </div>
    </div>
    <?php
    }else {
    ?>
    <h1>Erreur</h1>
    <?php
    }
    ?>
        
</body>
</html>