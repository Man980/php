<?php
session_start();
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
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
        // Récupérer les données du formulaire
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $datNaissance = $_POST['datNaissance'];
        $sexe = $_POST['sexe'];
        $classe = $_POST['classe'];
        $fraisInscription = $_POST['fraisInscription'];
        $dateInscription = $_POST['dateInscription'];
        $codeInscription0 = $_POST['codeInscription0'];
        $codeInscription = $_POST['codeInscription'];

        // Vérifier si une inscription existe déjà avec ce code d'inscription (mise à jour)
        if (!empty($codeInscription)) {
            // Vérifier si un autre enregistrement utilise déjà le même codeInscription0
            $checkQuery = "SELECT codeInscription FROM inscriptionstudent WHERE codeInscription0 = '$codeInscription0' AND codeInscription != '$codeInscription'";
            $checkResult = $conn->query($checkQuery);

            if ($checkResult->num_rows > 0) {
                echo "Erreur: Un autre enregistrement utilise déjà ce code d'inscription secondaire (codeInscription0).";
            } else {
                // Mettre à jour l'inscription existante
                $update = "UPDATE inscriptionstudent 
                           SET nom='$nom', prenom='$prenom', datNaissance='$datNaissance', sexe='$sexe', classe='$classe', fraisInscription='$fraisInscription', dateInscription='$dateInscription', codeInscription0='$codeInscription0' 
                           WHERE codeInscription='$codeInscription'";

                if ($conn->query($update) === TRUE) {
                    echo "Inscription mise à jour avec succès";
                } else {
                    echo "Erreur lors de la mise à jour : " . $conn->error;
                }
            }
        } else {
            // Générer un code d'inscription unique si c'est une nouvelle inscription
            $codeInscription = uniqid('INS-');

            // Ajouter une nouvelle inscription
            $sql = "INSERT INTO inscriptionstudent (codeInscription, nom, prenom, sexe, datNaissance, classe, fraisInscription, dateInscription, codeInscription0)
                    VALUES ('$codeInscription', '$nom', '$prenom', '$sexe', '$datNaissance', '$classe', '$fraisInscription', '$dateInscription', '$codeInscription0')";

            if ($conn->query($sql) === TRUE) {
                echo "Nouvelle inscription ajoutée avec succès";
            } else {
                echo "Erreur: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}


// Traitement de la suppression d'une inscription
if (isset($_POST['delete_inscription'])) {
    // Récupérer le code de l'inscription à supprimer
    $codeInscription = $_POST['codeInscription'];

    // Requête SQL pour supprimer l'inscription
    $sql = "DELETE FROM inscriptionstudent WHERE codeInscription = '$codeInscription'";

    if ($conn->query($sql) === TRUE) {
        echo "Inscription supprimée avec succès";
    } else {
        echo "Erreur: " . $conn->error;
    }
}

// Recherche
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM inscriptionstudent WHERE 
            nom LIKE '%$search%' OR 
            prenom LIKE '%$search%' OR 
            classe LIKE '%$search%' OR
            codeInscription LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM inscriptionstudent";
}

$result = $conn->query($sql);

$conn->close();
?>

<?php

include('header.php');
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
        <button class="btn btn-primary" onclick="location.href='paiement.php'">Paiement</button>
    </div>

    <!-- Barre de recherche -->
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

            <div class="col">
                <input type="text" name="codeInscription0" id="codeInscription0" placeholder="Code Inscription" class="form-control" required>
            </div>
        </div>
        
        
        <button type="submit" name="add_inscription" class="btn btn-success mt-3">Ajouter / Mettre à jour</button>
    </form>

    <!-- Table de liste des inscriptions -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th> ID </th>
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
                            <td><?php echo $row['codeInscription0']; ?></td>
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
                    tr[i].style.display = ""; // Afficher les lignes correspondantes
                    break;
                }
            }
        }
    }
}

// Remplir le formulaire de modification lorsque l'utilisateur clique sur "Modifier"
function editRow(button) {
    var row = button.closest('tr');
    var cells = row.getElementsByTagName('td');
    
    document.getElementById('codeInscription').value = cells[0].innerText;
    document.getElementById('codeInscription0').value = cells[1].innerText;
    document.getElementById('nom').value = cells[2].innerText;
    document.getElementById('prenom').value = cells[3].innerText;
    document.getElementById('sexe').value = cells[4].innerText == 'Masculin' ? 'M' : 'F';
    document.getElementById('datNaissance').value = cells[5].innerText;
    document.getElementById('classe').value = cells[6].innerText;
    document.getElementById('fraisInscription').value = cells[7].innerText;
    document.getElementById('dateInscription').value = cells[8].innerText;
}
</script>
</body>
</html>
