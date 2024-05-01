<?php
require_once '../persistance/connexion.php';
$connexion = Connexion::getConnexion(); 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-secondary dp-flex text-center row">
    <?php 
        $matricule = $_POST["matricule"]; //recup du matricule
   
        if (isset($msgErreur)) {
            echo "Erreur : $msgErreur";
        }

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $matricule = $_POST['matricule'];
            $_SESSION['Matricule'] = $matricule;
        }
        
        if(isset($matricule)){//recupération des données  à modifier
            $sql = "SELECT * FROM employe WHERE Matricule = :matricule";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':matricule', $matricule);
            $stmt->execute();
            $employe = $stmt->fetch();
        }

        $prenom = $employe['PrenomEmpl'];
        $nom = $employe['NomEmpl'];
        $code = $employe['CodeCadre'];
        $service = $employe['ServEmpl'];

        // Convertir les valeurs postées en noms de service correspondants
        switch ($service) {
            case 's01':
                $service = 'Fabrication';
                break;
            case 's02':
                $service = 'Emballage';
                break;
            case 's03':
                $service = 'Commercial';
                break;
            case 's04':
                $service = 'Administration';
                break;
            default:
                $service = ''; // Valeur par défaut ou à traiter si nécessaire
                break;
        }
    ?>

    <h1 class='text-light p-3 mb-5'> Modification de l'employé <?php echo $prenom . " " . $nom ?></h1>
    <div class="pb-4">
    <div class="container bg-light rounded col-10 col-sm-6 col-lg-4 ">
        <h2 class="pt-3">Rentrez les données que vous voulez modifier</h2>
        <form action="../modification/enregistrement.php" method="post">
            <label for="name">Nom : <?php echo $nom ?>  </label><br> <input type="text"  id="nom" name="nom" ><br><br>
            <label for="prenom">Prenom :  <?php echo $prenom ?> </label><br> <input type="text" id="prenom" name="prenom" ><br><br>
            <label for="matricule">Matricule : <span style="color: red;"> Non modifiable </span></label><br><input type="number"id="matricule" name="matricule" value="<?php echo $matricule ?>" readonly><br><br>
            <label for="code">Code Cadre : <?php echo $code ?>  </label><br><input type="number" name="code" ><br><br>
               
            <ul class="" style="list-style: none;">
                <li>
                    <label for="service">Service Employé : <?php echo $service ?></label>
                    <select name="service" id="service">
                        <option value="s04">Administration</option>
                        <option value="s03">Commercial</option>
                        <option value="s02">Emballage</option>
                        <option value="s01">Fabrication</option>
                    </select>
                </li><br>
            </ul>
            <div class="pb-3">
                <button type="submit" class="btn btn-primary mt-2">Envoyer</button>
                <a href="../index.php" class="btn btn-warning mt-2">Retour au menu</a>
            </div>
        </form>
    </div>
    </div>
</body> 
</html>
