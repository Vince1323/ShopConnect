<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) : '🛒 ShopConnect'; ?></title>
    <meta name="description" content="<?php echo isset($description) ? htmlspecialchars($description) : ''; ?>">
    <meta name="keywords" content="<?php echo isset($keywords) ? htmlspecialchars($keywords) : ''; ?>">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Fichiers CSS des bibliothèques via CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/2.5.0/remixicon.css" rel="stylesheet">
    <link href="https://unpkg.com/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js"></script>

    <!-- Votre propre CSS -->
    <link href="app/views/templates/css/style.css" rel="stylesheet">

    <!-- jQuery (necessary for FullCalendar's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>

    <!-- Fichiers JS des bibliothèques via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js" defer></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js" defer></script>

    <style>
        /* Light Theme */
        :root.light {
            --bg-color: #ffffff;
            --text-color: #000000;
            --link-color: #007bff;
            --header-bg-color: #f8f9fa;
            --header-text-color: #343a40;
        }

        /* Dark Theme */
        :root.dark {
            --bg-color: #1f1f1f;
            --text-color: #f0f0f0;
            --link-color: #ffcc00;
            --header-bg-color: #343a40;
            --header-text-color: #f0f0f0;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.3s, color 0.3s;
        }

        a {
            color: var(--link-color);
        }

        a:hover {
            color: var(--link-color);
            text-decoration: underline;
        }

        #header, #topbar {
            background-color: var(--header-bg-color);
            color: var(--header-text-color);
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-warning {
            background-color: var(--link-color);
            color: var(--bg-color);
        }

        .btn-warning:hover {
            background-color: #ffdd33;
            color: var(--text-color);
        }
    </style>

    <script>
        function toggleTheme() {
            // Toggle between dark and light mode
            document.documentElement.classList.toggle('dark');
            const themeIcon = document.getElementById("theme-icon");
            if (document.documentElement.classList.contains('dark')) {
                themeIcon.classList.replace('bi-moon-stars', 'bi-sun');
            } else {
                themeIcon.classList.replace('bi-sun', 'bi-moon-stars');
            }
        }

        function changeLanguage(language) {
            if (language === 'fr') {
                document.documentElement.lang = 'fr';
                // Change text to French
                document.getElementById('home-link').innerText = 'Accueil';
                document.getElementById('services-link').innerText = 'Services';
                document.getElementById('contact-link').innerText = 'Contact';
            } else if (language === 'en') {
                document.documentElement.lang = 'en';
                // Change text to English
                document.getElementById('home-link').innerText = 'Home';
                document.getElementById('services-link').innerText = 'Services';
                document.getElementById('contact-link').innerText = 'Contact';
            }
        }
    </script>
</head>

<body class="light">
    <!-- ======= Barre du Haut ======= -->
    <div id="topbar" class="d-flex align-items-center fixed-top">
        <div class="container d-flex justify-content-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope"></i> <a href="mailto:contact@example.com">contact@example.com</a>
                <i class="bi bi-phone"></i> +32 04 04 04 04
            </div>
            <div class="d-none d-lg-flex align-items-center">
                <!-- Language Switch -->
                <select onchange="changeLanguage(this.value)" style="margin-right: 15px;">
                    <option value="fr">Français</option>
                    <option value="en">English</option>
                </select>

                <!-- Theme Switch -->
                <button onclick="toggleTheme()" style="background: none; border: none; cursor: pointer;">
                    <i id="theme-icon" class="bi bi-moon-stars" style="font-size: 20px;"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- ======= En-tête ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">
            <h1 class="logo me-auto"><a href="index.php">ShopConnect</a></h1>
            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <li><a id="home-link" class="nav-link scrollto active" href="index.php">Accueil</a></li>
                    <li><a class="nav-link scrollto" href="index.php?action=register">Register Tempo</a></li>
                    <li><a id="services-link" class="nav-link scrollto" href="#boutiques">Boutiques</a></li>
                    <li><a class="nav-link scrollto" href="index.php?action=homeArticle">Articles</a></li>
                    <?php if (isset($_SESSION['user_id'])) : ?>
                    <li class="dropdown">
                        <a href="#" class="btn btn-warning"><span>Tableau de bord</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <?php if ($_SESSION['role'] === 'Admin') : ?>
                            <li class="dropdown">
                                <a href="index.php?action=adminDashboard"><span>Gestion admin</span> <i class="bi bi-chevron-right"></i></a>
                                <ul>
                                    <li><a href="index.php?action=dashboardUser">Utilisateur</a></li>
                                    <li><a href="index.php?action=dashboardArticle">Article</a></li>
                                    <li><a href="index.php?action=dashboardClient">Client</a></li>
                                    <li><a href="index.php?action=dashboardMarketing">Marketing</a></li>
                                    <li><a href="index.php?action=dashboardFactures">Factures</a></li>
                                    <li><a href="index.php?action=dashboardHistorique">Historique Achat</a></li>
                                    <li><a href="index.php?action=dashboardArticleBoutique">Article Boutique</a></li>
                                    <li><a href="index.php?action=dashboardNotes">Notes</a></li>
                                    <li><a href="index.php?action=dashboardAchats">Achats</a></li>
                                    <li><a href="index.php?action=dashboardBoutiques">Boutiques</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php if ($_SESSION['role'] === 'boutique') : ?>
                            <li class="dropdown">
                                <a href="#"><span>Gestion Article</span> <i class="bi bi-chevron-right"></i></a>
                                <ul>
                                    <li><a href="index.php?action=viewAchatHistory">Historique des achats</a></li>
                                    <li><a href="index.php?action=listClients">Liste des clients</a></li>
                                    <li><a href="index.php?action=viewConfirmedAchats">Mes Achats</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php if ($_SESSION['role'] === 'Marketing') : ?>
                            <li class="dropdown">
                            <li><a href="index.php?action=listeClients">Liste des clients</a></li>
                            <li><a href="index.php?action=montrerFormulaireAchat">Passer Achat</a></li>
                            <li class="dropdown">
                                <a href="#"><span>Achats client</span> <i class="bi bi-chevron-right"></i></a>
                                <ul>
                                    <li><a href="index.php?action=viewAllAchat">Tous les Achats</a></li>
                                    <li><a href="index.php?action=viewConfirmedAchat">Achats Confirmés</a></li>
                                    <li><a href="index.php?action=viewPendingAchat">Achats en Attente</a></li>
                                    <li><a href="index.php?action=viewCancelledAchat">Achats Annulés</a></li>
                                </ul>
                            </li>
                           
                    </li>
                    <?php endif; ?>
                </ul>
                </li>
                <?php endif; ?>
                <li><a id="contact-link" class="nav-link scrollto" href="index.php?action=contact">Contact</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
            <?php if (isset($_SESSION['user_id'])) : ?>
            <a href="index.php?action=logout" class="appointment-btn scrollto"><span class="d-none d-md-inline">Déconnexion</span></a>
            <?php else : ?>
            <a href="index.php?action=login" class="appointment-btn scrollto"><span class="d-none d-md-inline">Se connecter</span></a>
            <?php endif; ?>
        </div>
    </header><!-- Fin En-tête -->

    <div class="container mt-5">
        
