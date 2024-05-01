<?php
// PARTIE DONNES 
// inclusion de la méthode de dialogue avec la BD
require_once '../persistance/dialogueBD.php';
try {
    $undlg = new DialogueBD();
    $mesEmployes = $undlg->getTousLesEmployes();
} catch (Exception $e) {
    $erreur = $e->getMessage();
}


 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Employés</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

</head>
<style>
    .deco{
        list-style: none;
    }
</style>
<body class="bg-secondary dp-flex text-center row">
   
    <?php
        if (isset($msgErreur)){
            echo "Erreur : $erreur";
        }
    ?>
    <h1 class="text-light p-3">Liste des Employés</h1>
    <div class="container bg-light rounded col-10 col-md-6 col-lg-4 p-4">
    <div class="row d-flex justify-content-around">
        <ul class="deco " >
            <?php
            $nbemployes = 0;
            $compteur =0 ;
            if ($mesEmployes !== null) {
                echo '<div style="margin: 0 auto; width: fit-content;">';
                echo "<table>";
                echo "<tr><th>Matricule </th><th>Nom    </th><th>Prénom </th></tr>";
            
                foreach ($mesEmployes as $ligne) {
                    $matricule = $ligne['Matricule'];   
                    $nom = $ligne['NomEmpl'];
                    $prenom = $ligne['PrenomEmpl'];
                    echo "<tr><td>$matricule</td><td>$nom</td><td>$prenom</td></tr>";
                    $compteur++;
                }
            
                echo "</table>";
                echo '</div>';
            }
            else {
            echo "Aucun employé trouvé.";
        }
        echo"<br><br>Nombre total d'employés : ", $compteur;
        ?>
    <div>
    <a href="../ajouteur/insert.html" class="btn btn-primary mt-2">Ajouter un employé</a>
    <a href="../presentation/afficheEmploye.php" class="btn btn-primary mt-2">Plus de Renseignements</a>
    <a href="../index.php" class="btn btn-warning mt-2">Retour au menu</a>
    
    </div>
    </ul>
    </div>
   
 
</body>
</html>