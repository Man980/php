<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "urh";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Traitement des requêtes POST pour ajouter, modifier, supprimer
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_inscription'])) {
        // Vérifier si une inscription avec les mêmes informations existe déjà
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $datNaissance = $_POST['datNaissance'];

        $sql_check = "SELECT * FROM inscriptionstudent WHERE nom='$nom' AND prenom='$prenom' AND datNaissance='$datNaissance'";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            echo "Erreur: Un étudiant avec les mêmes informations est déjà inscrit.";
        } else {
            // Ajouter une nouvelle inscription
            $sexe = $_POST['sexe'];
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
    }
}


// Requête pour obtenir toutes les inscriptions
$sql = "SELECT * FROM inscriptionstudent";
$result = $conn->query($sql);

?>


<?php

if (isset($_POST['delete_inscription'])) {
    // Récupérer l'identifiant de l'inscription à supprimer
    $codeInscription = $_POST['codeInscription'];

    // Requête SQL pour supprimer l'inscription
    $sql = "DELETE FROM inscriptionstudent WHERE codeInscription = $codeInscription";

    if ($conn->query($sql) === TRUE) {
        echo "Inscription supprimée avec succès";
    } else {
        echo "Erreur: " . $conn->error;
    }
}


$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM inscriptionstudent WHERE 
            nom LIKE '%$search%' OR 
            prenom LIKE '%$search%' OR 
            classe LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM inscriptionstudent";
}

$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Gestion des Inscriptions</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="d-flex justify-content-between">
        <h2>Tableau de Bord - Gestion des Inscriptions</h2>
        <button class="btn btn-primary" onclick="location.href='index.php'">Retour à l'accueil</button>
    </div>

    <!-- Barre de recherche 
    <input type="text" class="form-control" placeholder="Rechercher par nom ou code" id="searchInput" onkeyup="searchTable()">
    <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" id="searchButton">Rechercher</button>
    </div>
    -->
    <div class="input-group mb-3">
        <form method="GET" action="" class="form-inline mb-3">
            <input type="text" name="search" class="form-control mr-sm-2" placeholder="Rechercher un étudiant" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-outline-success">Rechercher</button>
        </form>
    </div>


    
    <!-- Formulaire d'ajout/modification -->
    <form method="POST" action="" class="mb-5">
        <input type="hidden" name="codeInscription" id="codeInscription">
        <div class="form-row">
            <div class="col">
                <input type="text" name="nom" id="nom" class="form-control" placeholder="Nom" required>
            </div>
            <div class="col">
                <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Prénom" required>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="col">
                <select name="sexe" id="sexe" class="form-control" required>
                    <option value="M">Masculin</option>
                    <option value="F">Féminin</option>
                </select>
            </div>
            <div class="col">
                <input type="date" name="datNaissance" id="datNaissance" class="form-control" required>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="col">
                <input type="text" name="classe" id="classe" class="form-control" placeholder="Classe" required>
            </div>
            <div class="col">
                <input type="number" name="fraisInscription" id="fraisInscription" class="form-control" placeholder="Frais d'inscription" required>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="col">
                <input type="date" name="dateInscription" id="dateInscription" class="form-control" required>
            </div>
        </div>
        <button type="submit" name="add_inscription" class="btn btn-success mt-3">Ajouter / Mettre à jour</button>
    </form>

    <!-- Table de liste des inscriptions -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Code Inscription</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Sexe</th>
                    <th>Date de Naissance</th>
                    <th>Classe</th>
                    <th>Frais d'Inscription</th>
                    <th>Date d'Inscription</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['codeInscription']; ?></td>
                            <td><?php echo $row['nom']; ?></td>
                            <td><?php echo $row['prenom']; ?></td>
                            <td><?php echo $row['sexe']; ?></td>
                            <td><?php echo $row['datNaissance']; ?></td>
                            <td><?php echo $row['classe']; ?></td>
                            <td><?php echo $row['fraisInscription']; ?></td>
                            <td><?php echo $row['dateInscription']; ?></td>
                            <td>
                                <button type="button" class="btn btn-warning" onclick="editRow(this)">Modifier</button>
                                <form method="POST" action="" class="d-inline">
                                    <input type="hidden" name="codeInscription" value="<?php echo $row['codeInscription']; ?>">
                                    <button type="submit" name="delete_inscription" class="btn btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Aucune inscription trouvée</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Fonction de recherche pour filtrer les résultats dans le tableau
function searchTable() {
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("tableBody");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        tr[i].style.display = "none"; // Masquer toutes les lignes initialement
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = ""; // Afficher les lignes qui correspondent
                    break;
                }
            }
        }
    }
}

// Fonction pour remplir le formulaire avec les données existantes lors de la modification
function editRow(button) {
    var row = button.parentElement.parentElement;
    var cells = row.getElementsByTagName("td");

    document.getElementById("codeInscription").value = cells[0].innerText;
    document.getElementById("nom").value = cells[1].innerText;
    document.getElementById("prenom").value = cells[2].innerText;
    document.getElementById("sexe").value = cells[3].innerText;
    document.getElementById("datNaissance").value = cells[4].innerText;
    document.getElementById("classe").value = cells[5].innerText;
    document.getElementById("fraisInscription").value = cells[6].innerText;
    document.getElementById("dateInscription").value = cells[7].innerText;
}
</script>

</body>
</html>
