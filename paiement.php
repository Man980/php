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

// Traitement des requêtes POST pour ajouter, modifier, supprimer les paiements
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_paiement'])) {
        $codeInscription = $_POST['codeInscription'];
        $montant = $_POST['montant'];
        $datePaiement = $_POST['datePaiement'];
        $methodPaiement = $_POST['methodPaiement'];

        // Vérifier si l'inscription existe
        $sql_check = "SELECT * FROM inscriptionstudent WHERE codeInscription0='$codeInscription'";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            // Ajouter un nouveau paiement
            $sql = "INSERT INTO paiement (codeInscription0, montant, datePaiement, methodPaiement)
                    VALUES ('$codeInscription', '$montant', '$datePaiement', '$methodPaiement')";

            if ($conn->query($sql) === TRUE) {
                echo "Nouveau paiement ajouté avec succès";
            } else {
                echo "Erreur: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Erreur: Aucune inscription trouvée avec ce code.";
        }
    }
}

if (isset($_POST['delete_paiement'])) {
    // Récupérer le code de l'inscription à supprimer
    $codePaiement = $_POST['codePaiement'];

    // Requête SQL pour supprimer l'inscription
    $sql = "DELETE FROM paiement WHERE codePaiement = '$codePaiement'";

    if ($conn->query($sql) === TRUE) {
        echo "Paiement supprimé avec succès";
    } else {
        echo "Erreur: " . $conn->error;
    }
}

// Requête pour obtenir tous les paiements
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM paiement WHERE 
            codeInscription LIKE '%$search%' OR 
            methodPaiement LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM paiement";
}

$result = $conn->query($sql);

$conn->close();
?>

<?php

include('header.php');

?>

    <meta charset="UTF-8">
    <title>Tableau de Bord - Gestion des Paiements</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="d-flex justify-content-between">
        <h2>Tableau de Bord - Gestion des Paiements</h2>
        <button class="btn btn-primary" onclick="location.href='inscriptions.php'">Inscription</button>
    </div>

    <!-- Barre de recherche -->
    <div class="input-group mb-3">
        <form method="GET" action="" class="form-inline mb-3">
            <input type="text" name="search" class="form-control mr-sm-2" placeholder="Rechercher un paiement" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-outline-success">Rechercher</button>
        </form>
    </div>

    <!-- Formulaire d'ajout/modification -->
    <form method="POST" action="" class="mb-5">
        <input type="hidden" name="codePaiement" id="codePaiement">
        <div class="form-row">
            <div class="col">
                <input type="text" name="codeInscription" id="codeInscription" class="form-control" placeholder="Code Inscription" required>
            </div>
            <div class="col">
                <input type="number" step="0.01" name="montant" id="montant" class="form-control" placeholder="Montant" required>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="col">
                <input type="date" name="datePaiement" id="datePaiement" class="form-control" required>
            </div>
            <div class="col">
                <select name="methodPaiement" id="methodPaiement" class="form-control" required>
                    <option value="Espèces">Espèces</option>
                    <option value="Chèque">Chèque</option>
                    <option value="Carte bancaire">Carte bancaire</option>
                </select>
            </div>
        </div>
        <button type="submit" name="add_paiement" class="btn btn-success mt-3">Ajouter / Mettre à jour</button>
    </form>

    <!-- Table de liste des paiements -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Code Inscription</th>
                    <th>Montant</th>
                    <th>Date de Paiement</th>
                    <th>Méthode de Paiement</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['codePaiement']; ?></td>
                            <td><?php echo $row['codeInscription0']; ?></td>
                            <td><?php echo $row['montant']; ?></td>
                            <td><?php echo $row['datePaiement']; ?></td>
                            <td><?php echo $row['methodPaiement']; ?></td>
                            <td>
                                <button type="button" class="btn btn-warning" onclick="editRow(this)">Modifier</button>
                                <form method="POST" action="" class="d-inline">
                                    <input type="hidden" name="codePaiement" value="<?php echo $row['codePaiement']; ?>">
                                    <button type="submit" name="delete_paiement" class="btn btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Aucun paiement trouvé</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Fonction pour remplir le formulaire avec les données existantes lors de la modification
function editRow(button) {
    var row = button.parentElement.parentElement;
    var cells = row.getElementsByTagName("td");

    document.getElementById("codePaiement").value = cells[0].innerText;
    document.getElementById("codeInscription").value = cells[1].innerText;
    document.getElementById("montant").value = cells[2].innerText;
    document.getElementById("datePaiement").value = cells[3].innerText;
    document.getElementById("methodPaiement").value = cells[4].innerText;
}
</script>

</body>
</html>
