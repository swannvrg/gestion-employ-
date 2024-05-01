<?php
require_once '../persistance/connexion.php';
$connexion = Connexion::getConnexion();
session_start();
$disabled = (isset($employe) && !empty($employe)) ? '' : 'disabled';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>Supression</title>
</head>
<body class="bg-secondary dp-flex text-center row">
        <?php
            if (isset($msgErreur)) {
            echo "Erreur : $msgErreur";
            }
        ?>
        <h1 class="text-light p-3">Supression d'employé : </h1>
        <div class="container bg-light rounded col-10 col-lg-6 p-4 ">
            <form action="" method="post">
                <label class="p-2" for="">Entrez le numéro de matricule de l'employé que vous voulez supprimer</label><br>
                <input type="number" name="matricule" class="mb-1">
                <input class="btn btn-primary" type="submit" value="Valider">
                
            </form>
            
            <?php
                //recup du matricule
                if($_SERVER['REQUEST_METHOD']==='POST'){
                    $matricule = $_POST['matricule'];
                    $_SESSION['Matricule'] = $matricule;
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
            <div class="row m-3">
                <div class="col-10">
                <ul class="deco offset-3 text-start list-group">
    <?php
    if(isset($employe) && !empty($employe)) {  // si le tableau n'est pas vide on peut afficher les informations
        echo "<li class='list-group-item'>Nom : " . $employe['NomEmpl'] . "</li>";
        echo "<li class='list-group-item'>Prénom : " . $employe['PrenomEmpl'] . "</li>"; 
        echo "<li class='list-group-item'>Matricule : " . $employe['Matricule'] . "</li>";
        echo "<li class='list-group-item'>Code du cadre : " . $employe['CodeCadre'] . "</li>";
        echo "<li class='list-group-item'>Code du service : " . $employe['ServEmpl'] . "</li>";
        $disabled = ''; // bouton supprimer est actif
    } else if(isset($matricule)) { // si l'id n'existe pas
        echo "Le matricule $matricule n'existe pas";
        $disabled = 'disabled'; // bouton supprimer est désactivé
    }
    ?>
</ul>
</div>
</div>
<a class="btn btn-warning mt-2" href="../index.php">Retour au menu</a>
<button class="btn btn-danger mt-2" data-bs-toggle="modal" data-bs-target="#exampleModal" <?php echo $disabled; ?>>Supprimer l'employé</button>

            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"> <?php echo"Supression de l'employé n° " .$employe['Matricule'] ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php 
                        echo"Etes vous sur de vouloir supprimer définitivement l'employé ". $employe['NomEmpl'] ." ". $employe['PrenomEmpl']. " ?"
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="../suppression/traitement.php" method="post">
                        <button  type="submit" class="btn btn-danger">Confirmer</button>
                    </form>
                </div>
                </div>
            </div>
            </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>