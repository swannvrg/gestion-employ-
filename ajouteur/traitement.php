<?php
// Récupération des données employés
$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$matricule = $_POST["matricule"];
$code = $_POST['code'];
$service = $_POST['service'];

// Inclusion du fichier de connexion
require_once '../persistance/connexion.php';
$connexion = Connexion::getConnexion();

// Vérification si le matricule ou le code cadre est déjà attribué
$sqlCheck = "SELECT Matricule, CodeCadre FROM employe WHERE Matricule = :matricule OR CodeCadre = :code";
$stmtCheck = $connexion->prepare($sqlCheck);
$stmtCheck->bindParam(':matricule', $matricule);
$stmtCheck->bindParam(':code', $code);
$stmtCheck->execute();
$existingEmployee = $stmtCheck->fetch();

if ($existingEmployee) {
    $messageErreur = "Le matricule ou le code cadre est déjà attribué. <br> Vous allez être redirigé vers l'ajout d'employé";
    // Redirection vers la page d'ajout d'employé
    header("refresh:3;url=./insert.html");
} else {
    // Requête d'insertion des données dans la base de données
    $sqlInsert = "INSERT INTO employe(Matricule, NomEmpl, PrenomEmpl, CodeCadre, ServEmpl) VALUES(:matricule, :nom, :prenom, :code, :serv)";
    $stmt = $connexion->prepare($sqlInsert);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(":matricule", $matricule);
    $stmt->bindParam(":code", $code);
    $stmt->bindParam(":serv", $service);

    // Exécution de la requête d'insertion
    if ($stmt->execute()) {
        $messageSuccess = "Enregistrement réussi !";
    } else {
        $messageErreur = "Erreur lors de l'enregistrement de l'employé.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrement</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-secondary dp-flex text-center row">
    <?php if (isset($messageSuccess)) { ?>
        <h1 class="text-light p-3"><?php echo $messageSuccess; ?></h1>
        <div class="container bg-light rounded col-6 p-4">
            <div>
                <p>L'enregistrement de l'employé <?php echo $prenom," ", $nom; ?> a été réalisé avec succès</p>
            </div>
            <div>
                <a href="../ajouteur/insert.html" class="btn btn-primary mt-2">Ajouter un employé</a>
                <a href="../presentation/listeEmployes.php" class="btn btn-primary mt-2">Liste des employés</a>
                <a href="../index.php" class="btn btn-warning mt-2">Retour au menu</a>
            </div>
        </div>
    <?php } elseif (isset($messageErreur)) { ?>
        <h1 class="text-light p-3"><?php echo $messageErreur; ?></h1>
    <?php } ?>
</body>
</html>
