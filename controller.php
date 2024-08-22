<?php
include 'db_connect.php';

// Ajouter une inscription
if (isset($_POST['add_inscription'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $sexe = $_POST['sexe'];
    $datNaissance = $_POST['datNaissance'];
    $classe = $_POST['classe'];
    $fraisInscription = $_POST['fraisInscription'];
    $dateInscription = $_POST['dateInscription'];

    $sql = "INSERT INTO inscriptionstudent (nom, prenom, sexe, datNaissance, classe, fraisInscription, dateInscription)
            VALUES ('$nom', '$prenom', '$sexe', '$datNaissance', '$classe', '$fraisInscription', '$dateInscription')";

    if ($conn->query($sql) === TRUE) {
        echo "Nouvelle inscription ajoutée avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

// Modifier une inscription
if (isset($_POST['update_inscription'])) {
    $codeInscription = $_POST['codeInscription'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $sexe = $_POST['sexe'];
    $datNaissance = $_POST['datNaissance'];
    $classe = $_POST['classe'];
    $fraisInscription = $_POST['fraisInscription'];
    $dateInscription = $_POST['dateInscription'];

    $sql = "UPDATE Inscription SET nom='$nom', prenom='$prenom', sexe='$sexe', datNaissance='$datNaissance', classe='$classe', fraisInscription='$fraisInscription', dateInscription='$dateInscription'
            WHERE codeInscription='$codeInscription'";

    if ($conn->query($sql) === TRUE) {
        echo "Inscription mise à jour avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

// Supprimer une inscription
if (isset($_POST['delete_inscription'])) {
    $codeInscription = $_POST['codeInscription'];

    $sql = "DELETE FROM Inscription WHERE codeInscription='$codeInscription'";

    if ($conn->query($sql) === TRUE) {
        echo "Inscription supprimée avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

// Rechercher une inscription
if (isset($_POST['search_inscription'])) {
    $search = $_POST['search'];

    $sql = "SELECT * FROM Inscription WHERE nom LIKE '%$search%' OR prenom LIKE '%$search%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "Nom: " . $row["nom"]. " - Prénom: " . $row["prenom"]. " - Classe: " . $row["classe"]. "<br>";
        }
    } else {
        echo "Aucun résultat trouvé";
    }
}
?>
