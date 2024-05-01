<?php
//Inclue le fichier 'connexion.php' au fichier actuelle
require_once 'connexion.php';
 
class DialogueBD {
   
    public function getTousLesEmployes() {
        try {
            // Obtenez la connexion à la base de données
            $conn = Connexion::getConnexion();
           
            // Requête SQL pour sélectionner tous les employés de la table "employe"
            $sql = "SELECT Matricule, NomEmpl, PrenomEmpl FROM employe ORDER BY Matricule";
           
            // Préparez la requête SQL
            $sth = $conn->prepare($sql);
           
            // Exécutez la requête SQL
            $sth->execute();
           
            // Récupérez tous les employés sous forme de tableau
            $tabEmployes = $sth->fetchAll(PDO::FETCH_ASSOC);
           
            // Retournez le tableau d'employés
            return $tabEmployes;
        } catch (PDOException $e) {
            // En cas d'erreur, Affichage du message d'erreur
            $erreur = $e->getMessage();
            echo "Erreur: " . $erreur;
            // Retournez null pour indiquer qu'il y a eu une erreur
            return null;
        }
    }
    
    public function getEmployesParService($service) {

        try {
        $conn = Connexion::getConnexion();
        $sql = "SELECT * FROM employe WHERE ServEmpl=?";
        $sql = $sql." ORDER BY NomEmpl";
        $sth = $conn->prepare($sql);
        $sth->execute(array($service));
        $tabEmployesService = $sth->fetchAll(PDO::FETCH_ASSOC); 
        return $tabEmployesService;
        } catch (PDOException $e) {
        $erreur = $e->getMessage();
        }
    }
}
 
 
 
?>