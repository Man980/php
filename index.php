<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue à l'Ecole les Aventuriers</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers le fichier CSS personnalisé -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Menu de navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Ecole les Aventuriers</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#testimonials">Témoignages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary ml-3" href="admin.php">Administration</a>
                </li>
                <!-- Bouton de déconnexion -->
                <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                    <li class="nav-item">
                        <a class="btn btn-danger ml-3" href="logout.php">Déconnexion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Section de la bannière -->
<header class="homepage-banner">
    <div class="overlay"></div>
    <div class="container text-center">
        <h1 class="display-4 text-white">Ecole les Aventuriers</h1>
        <p class="lead text-white">Excellence, Innovation, et Développement pour Tous</p>
    </div>
</header>

<!-- Section de présentation -->
<section class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <h2>À Propos de Nous</h2>
            <p>Ecole les Aventuriers est dédiée à offrir une éducation de qualité qui prépare les étudiants à un avenir brillant. Notre mission est de fournir un environnement d'apprentissage stimulant, innovant et inclusif.</p>
            <a href="#" class="btn btn-primary">En Savoir Plus</a>
        </div>
        <div class="col-md-6">
            <img src="images/image1.jpg" alt="Université" class="img-fluid">
        </div>
    </div>
</section>

<!-- Section des services -->
<section id="services" class="bg-light py-5">
    <div class="container text-center">
        <h2>Nos Services</h2>
        <div class="row">
            <div class="col-md-4">
                <img src="images/image4.jpg" alt="Programmes Académiques" class="img-fluid mb-3">
                <h3>Programmes Académiques</h3>
                <p>Nous offrons une large gamme de programmes académiques adaptés à tous les étudiants.</p>
            </div>
            <div class="col-md-4">
                <img src="images/image2.jpg" alt="Activités Extra-scolaires" class="img-fluid mb-3">
                <h3>Activités Extra-scolaires</h3>
                <p>Découvrez nos clubs, associations et événements culturels pour enrichir votre expérience scolaire.</p>
            </div>
            <div class="col-md-4">
                <img src="images/image3.jpg" alt="Soutien Financier" class="img-fluid mb-3">
                <h3>Soutien Financier</h3>
                <p>Nous proposons des bourses et des aides financières pour soutenir les écoliers dans leurs études.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section des témoignages -->
<section id="testimonials" class="container my-5">
    <h2 class="text-center">Témoignages</h2>
    <div id="testimonialsCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <blockquote class="blockquote text-center">
                    <p class="mb-0">"Une expérience incroyable qui a changé ma vie. Les professeurs sont excellents et l'environnement est très accueillant."</p>
                    <footer class="blockquote-footer">Jean Renal, Nouveau Secondaire 2 (NS2)</footer>
                </blockquote>
            </div>
            <div class="carousel-item">
                <blockquote class="blockquote text-center">
                    <p class="mb-0">"Ecole les Aventuriers m'a aidé à réaliser mes rêves. Les infrastructures sont de premier ordre."</p>
                    <footer class="blockquote-footer">Marie Claire, Nouveau Secondaire 4 (NS4)</footer>
                </blockquote>
            </div>
        </div>
        <a class="carousel-control-prev" href="#testimonialsCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Précédent</span>
        </a>
        <a class="carousel-control-next" href="#testimonialsCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Suivant</span>
        </a>
    </div>
</section>

<!-- Pied de page -->
<footer id="contact" class="bg-dark text-white text-center py-4">
    <p>&copy; Ecole les Aventuriers. Tous droits réservés.</p>
    <p>Contactez-nous à : <a href="mailto:angelocharlemagne@gmail.com" class="text-white">ecoleaventurier@ea.com</a></p>
    <ul class="list-inline">
        <li class="list-inline-item"><a href="#" class="text-white">Facebook</a></li>
        <li class="list-inline-item"><a href="#" class="text-white">Twitter</a></li>
        <li class="list-inline-item"><a href="#" class="text-white">Instagram</a></li>
    </ul>
</footer>

<!-- Lien vers Bootstrap JS et jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
