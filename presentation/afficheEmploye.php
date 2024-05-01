<?php
require_once '../persistance/connexion.php';
$connexion = Connexion::getConnexion();
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
        <h1 class="text-light p-3">Renseignements sur l'employé : </h1>
        <div class="container bg-light rounded col-10 col-lg-6 ">
            <form action="" method="post" >
                <label class="p-2 pt-4" for="">Entrez le numéro de matricule de l'employé</label><br>
                <input type="number" name="matricule" class="mb-1">
                <input class="btn btn-primary" type="submit" value="Valider">
            </form>
            
            <?php
                //recup du matricule
                if($_SERVER['REQUEST_METHOD']==='POST'){
                    $matricule = $_POST['matricule'];
                }
                $db ;
                //requete sql pour recup données du matricule
                if(isset($matricule)){
                    $sql = "SELECT * FROM employe WHERE Matricule = :matricule";
                    $stmt = $connexion->prepare($sql);
                    $stmt->bindParam(':matricule', $matricule);
                    $stmt->execute();
                    $employe = $stmt->fetch();
                }
            ?>
            <div class="d-flex justify-content-center">
            <ul class="deco  text-start">
                <?php
                if(isset($employe) &&  !empty($employe)){  //si le tableau n'est pas vide on peut afficher les informations
                    echo "<li>Nom : " . $employe['NomEmpl'] . "</li>";
                    echo "<li>Prénom : " . $employe['PrenomEmpl'] . "</li>"; 
                    echo "<li>Matricule : " . $employe['Matricule'] . "</li>";
                    echo "<li>Code du cadre : " . $employe['CodeCadre'] . "</li>";
                    echo "<li>Code du service : " . $employe['ServEmpl'] . "</li>";
                }else if(isset($matricule)){//si l'id n'existe pas
                    echo"L'identifiant $matricule n'existe pas";
                }
                ?>
            </ul>
            </div>
            <div class="pb-4"> <a class="btn btn-warning mt-2 " href="../index.php">Retour au menu</a></div>
           
        </div>
    </body>
</html>