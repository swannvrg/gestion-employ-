<?php
require_once '../persistance/connexion.php';
$connexion = Connexion::getConnexion();

// Définir la valeur de $service en fonction de la valeur du menu déroulant
if(isset($_POST['service'])) {
    $serviceValue = $_POST['service'];
    if($serviceValue === 's01') {
        $service = "Fabrication";
    } elseif($serviceValue === 's02') {
        $service = "Emballage";
    } elseif($serviceValue === 's03') {
        $service = "Commercial";
    } elseif($serviceValue === 's04') {
        $service = "Administration";
    } else {
        $service = ""; // Si aucune correspondance trouvée, laisser vide
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Affichage d'un employé</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

</head>
<style>
    .deco{
        list-style: none;
    }
</style>
<body class="bg-secondary dp-flex text-center row">
    <?php
        if (isset($msgErreur)) {
            echo "Erreur : $msgErreur";
        }
    ?>
    <h1 class="text-light p-3">Liste des employés sur le service <?php echo isset($service) ? $service : ''; ?></h1>
    <div class="container bg-light rounded col-10 col-lg-6 p-4">
        <?php
            // Requête SQL pour récupérer les données du service
            if(isset($service)) {
                $sql = "SELECT * FROM employe WHERE ServEmpl = :service";
                $stmt = $connexion->prepare($sql);
                $stmt->bindParam(':service', $serviceValue);
                $stmt->execute();
                $employes = $stmt->fetchAll();
            }
        ?>
        <div class="row d-flex justify-content-around">
            <ul class="deco ">
                <?php
                if(isset($employes) && !empty($employes)) { // si le tableau n'est pas vide, on peut afficher les informations
                    echo "<h3>Employés du service ".$service."</h3>"; 
                    echo '<div style="margin: 0 auto; width: fit-content;">';
                    echo "<table>";
                    echo "<tr><th>Nom </th><th>Prénom   </th><th> Matricule</th></tr>";

                    foreach($employes as $employe) { 
                        $nom = $employe['NomEmpl'];
                        $prenom = $employe['PrenomEmpl'];
                        $matricule = $employe['Matricule'];
                        echo "<tr><td>$nom</td><td>$prenom</td><td>$matricule</td></tr>"; // ligne du tableau avec les informations de l'employé
                    }

                    echo "</table>";
                    echo '</div>';
                } else if(isset($service)) { // si l'id n'existe pas
                    echo "Il n'y a pas d'employé attribué, le service $service est actuellement vide";
                }
                ?>

            <br>
                <a class="btn btn-primary mt-2" href="../presentation/formEmplService.html">Rechercher d'autres services</a>
                <a class="btn btn-warning mt-2" href="../index.php">Retour au menu</a>
            </ul>
        </div>
    </div>
</body>
</html>
