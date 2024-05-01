<?php
require_once '../persistance/connexion.php';
$connexion = Connexion::getConnexion();
session_start();
$matricule = $_SESSION['Matricule'];

        if(isset($_POST['nom']) && !empty($_POST['nom'])) { 
            $nomModif = $_POST['nom'];
            $sqlModifNom = "UPDATE employe SET NomEmpl=:nom WHERE Matricule = $matricule";
            $sql = $connexion->prepare($sqlModifNom);
            $sql->bindParam(':nom', $nomModif);
            $sql->execute();
        }

        if(isset($_POST['prenom']) && !empty($_POST['prenom'])) {
            $prenomModif = $_POST['prenom'];
            $sqlModifPrenom = "UPDATE employe SET PrenomEmpl=:prenom WHERE Matricule = $matricule";
            $sql = $connexion->prepare($sqlModifPrenom);
            $sql->bindParam(':prenom', $prenomModif);
            $sql->execute();
        }

        if(isset($_POST['code']) && !empty($_POST['code'])){
            $codeModif = $_POST['code'];
            $sqlModifCode = "UPDATE employe SET CodeCadre=:code WHERE Matricule = $matricule";
            $sql = $connexion->prepare($sqlModifCode);
            $sql->bindParam(':code', $codeModif);
            $sql->execute();
        }
        if(isset($_POST['service']) && !empty($_POST['service'])){
            $serviceModif = $_POST['service'];
            $sqlModifService = "UPDATE employe SET ServEmpl=:service WHERE Matricule = $matricule";
            $sql = $connexion->prepare($sqlModifService);
            $sql->bindParam(':service', $serviceModif);
            $sql->execute();
        }
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
    <h1 class="text-light p-3"> Modification  réussi ! </h1>
    <div class="container bg-light rounded col-6 p-4">
         <div>
            <p>La modification de l'employé à été réalisé avec succés</p>
        </div>
        <div>
            <a href="../modification/modif.html" class="btn btn-primary mt-2">Modifier un  autre employé</a>

            <a href="../presentation/listeEmployes.php" class="btn btn-primary  mt-2">Liste des employés</a>
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