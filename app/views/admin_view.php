<?php
require_once 'form_view.php';
require_once 'form_container.php';

class AdminView
{

    public function renderHeader()
    {
        include 'templates/header.php';
    }

    public function renderFooter()
    {
        include 'templates/footer.php';
    }

    /**
     * Affiche le tableau de bord de l'administrateur.
     */
    public function renderAdminDashboard()
    {
        $this->renderHeader();

        // Création du FormContainer
        $form_container = new FormContainer();

        // Ajout du fil d'Ariane
        $form_container->addBreadcrumb("Accueil", "index.php");
        $form_container->addBreadcrumb("Tableau de Bord");

        // Ajout du titre principal
        $form_container->addMainTitle("Tableau de Bord Administrateur");

        // Ajout de la description
        $form_container->addDescription("Bienvenue sur le tableau de bord de l'administrateur.");

        // Ajout du bouton pour gérer les utilisateurs
        $form_container->addElement("", "<p><a href='index.php?action=manageUsers' class='btn btn-primary'>Gérer les utilisateurs</a></p>");

        // Ajout du bouton pour gérer les articles
        $form_container->addElement("", "<p><a href='index.php?action=manageArticles' class='btn btn-primary'>Gérer les articles</a></p>");

        // Ajout du bouton pour gérer les Clients
        $form_container->addElement("", "<p><a href='index.php?action=manageClients' class='btn btn-primary'>Gérer les clients</a></p>");

        // Rendu du contenu
        echo $form_container->render();
    }

    /**
     * Affiche un tableau à partir d'un titre, d'un tableau de données et de noms de colonnes personnalisés.
     */
    private function renderTable($title, $data, $rowCallback, $columns)
    {
        echo "<h2 class='mt-4'>{$title}</h2>";
        echo "<table class='table table-striped table-bordered' id='dataTable'>"; // Ajout de l'ID 'dataTable'.
        echo "<thead class='thead-dark'><tr>";

        // Affichage des en-têtes de colonne personnalisés
        foreach ($columns as $column) {
            echo "<th>{$column}</th>";
        }

        echo "</tr></thead>";
        echo "<tbody>";

        foreach ($data as $item) {
            $row = $rowCallback($item);
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>{$cell}</td>";
            }
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    }

    /**
     * Ajoute le script DataTables.
     */
    private function renderDataTableScript()
    {
        echo <<<HTML
        <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "paging": true,
                "pageLength": 10,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/French.json"
                }
            });

            // Confirmation avant la suppression d'un utilisateur
            $('form').on('submit', function(e) {
                if (!confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                    e.preventDefault();
                }
            });
        });
        </script>
        HTML;
    }

    /**
     * Affiche le tableau de bord de l'administrateur pour les utilisateurs.
     *
     * @param array $users Liste des utilisateurs.
     */
    public function adminDashboardUser($users)
    {
        $this->renderHeader();

        echo <<<HTML
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="myTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#users">Utilisateurs</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="users">
        HTML;

        // Utilisateurs
        $userColumns = ['Nom', 'Email', 'Rôle', 'Actions'];
        $this->renderTable("Liste des utilisateurs", $users, function ($user) {
            return [
                htmlspecialchars($user['nom']),
                htmlspecialchars($user['email']),
                htmlspecialchars($user['role']),
                "<a href='index.php?action=editUser&id={$user['id']}' class='btn btn-primary btn-sm'>Modifier</a>
                <form method='post' action='index.php?action=deleteUser' style='display: inline;'>
                <input type='hidden' name='id' value='{$user['id']}'>
                <button class='btn btn-danger btn-sm' type='submit'>Supprimer</button>
                </form>"
            ];
        }, $userColumns);

        echo <<<HTML
                        </div>
                    </div> <!-- Fin de la tab-content -->
                </div> <!-- Fin de la card-body -->
            </div> <!-- Fin de la card -->
        </div> <!-- Fin du container -->
        HTML;

        $this->renderDataTableScript();
    }

    /**
     * Affiche le tableau de bord de l'administrateur pour les articles.
     *
     * @param array $articles Liste des articles.
     */
    public function adminDashboardArticle($articles)
    {
        $this->renderHeader();

        echo <<<HTML
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="myTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#articles">articles</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="articles">
        HTML;

        // articles
        $articleColumns = ['Nom', 'Prénom', 'Spécialité', 'Téléphone', 'Actions'];
        $this->renderTable("Liste des articles", $articles, function ($article) {
            return [
                htmlspecialchars($article['nom']),
                htmlspecialchars($article['prenom']),
                htmlspecialchars($article['specialite']),
                htmlspecialchars($article['telephone']),
                "<a href='index.php?action=editArticle&id={$article['id']}' class='btn btn-primary btn-sm'>Modifier</a>
                <form method='post' action='index.php?action=deleteArticle' style='display: inline;'>
                <input type='hidden' name='id' value='{$article['id']}'>
                <button class='btn btn-danger btn-sm' type='submit'>Supprimer</button>
                </form>"
            ];
        }, $articleColumns);

        echo <<<HTML
                        </div>
                    </div> <!-- Fin de la tab-content -->
                </div> <!-- Fin de la card-body -->
            </div> <!-- Fin de la card -->
        </div> <!-- Fin du container -->
        HTML;

        $this->renderDataTableScript();
    }

    /* Affiche le tableau de bord de l'administrateur pour les clients.
    *
    * @param array $clients Liste des Clients.
    */
    public function adminDashboardClient($clients)
    {
        $this->renderHeader();

        echo <<<HTML
       <div class="container mt-5">
           <div class="card">
               <div class="card-header">
                   <ul class="nav nav-tabs card-header-tabs" id="myTabs">
                       <li class="nav-item">
                           <a class="nav-link active" data-toggle="tab" href="#clients">Clients</a>
                       </li>
                   </ul>
               </div>
               <div class="card-body">
                   <div class="tab-content">
                       <div class="tab-pane fade show active" id="clients">
       HTML;

        // clients
        $clientColumns = ['Nom', 'Prénom', 'Date de Naissance', 'Email', 'Téléphone', 'Adresse', 'Historique Médical', 'Actions'];
        $this->renderTable("Liste des clients", $clients, function ($client) {
            return [
                htmlspecialchars($client['nom']),
                htmlspecialchars($client['prenom']),
                htmlspecialchars($client['date_de_naissance']),
                htmlspecialchars($client['email']),
                htmlspecialchars($client['telephone']),
                htmlspecialchars($client['adresse']),
                htmlspecialchars($client['historique_medical']),
                "<a href='index.php?action=editClient&id={$client['id']}' class='btn btn-primary btn-sm'>Modifier</a>
               <form method='post' action='index.php?action=deleteClient' style='display: inline;'>
               <input type='hidden' name='id' value='{$client['id']}'>
               <button class='btn btn-danger btn-sm' type='submit'>Supprimer</button>
               </form>"
            ];
        }, $clientColumns);

        echo <<<HTML
                        </div>
                    </div> <!-- Fin de la tab-content -->
                </div> <!-- Fin de la card-body -->
            </div> <!-- Fin de la card -->
        </div> <!-- Fin du container -->
        HTML;

        $this->renderDataTableScript();
    }


    /*
    *   AFFICHAGE DES RENDEREDIT
    *
    */

    public function renderEditUserForm($user)
{
    $this->renderHeader();

    // Création d'une nouvelle instance de FormView
    $form = new FormView("index.php?action=updateUser&id={$user['id']}");

    // Ajout des champs au formulaire
    $form->addField('nom', 'nom', 'text', 'Nom:', $user['nom']);
    $form->addField('prenom', 'prenom', 'text', 'Prénom:', $user['prenom']);
    $form->addField('email', 'email', 'email', 'Email:', $user['email']);
    
    // Ajout du champ pour le rôle
    $form->addSelectField('role', 'role', 'Rôle:', [
        'Admin' => 'Admin',
        'Boutique' => 'Boutique',
        'Marketing' => 'Marketing',
        'Client' => 'Client'
    ], $user['role']);
    
    // Ajout du champ pour la langue
    $form->addSelectField('language', 'language', 'Langue:', [
        'fr' => 'Français',
        'en' => 'Anglais'
    ], $user['language']);
    
    // Ajout du champ pour le fournisseur d'authentification
    $form->addSelectField('auth_provider', 'auth_provider', 'Fournisseur d\'authentification:', [
        'email' => 'Email',
        'facebook' => 'Facebook',
        'google' => 'Google'
    ], $user['auth_provider']);
    
    // Ajout du bouton de validation
    $form->addButton('submit', 'Valider');

    // Affichage du formulaire
    echo "<div class='container mt-5'>
            <div class='row'>
                <div class='col-md-6 offset-md-3'>
                    <div class='card'>
                        <div class='card-header'>Modifier l'utilisateur</div>
                        <div class='card-body'>";

    echo $form->build();

    echo "         </div>
                    </div>
                </div>
            </div>
          </div>";

    // Ajout de JavaScript pour la validation du formulaire
    echo "<script>
          document.querySelector('form').onsubmit = function(event) {
              let nom = document.querySelector('[name=\"nom\"]').value;
              let prenom = document.querySelector('[name=\"prenom\"]').value;
              let email = document.querySelector('[name=\"email\"]').value;

              if(nom === '' || prenom === '' || email === '') {
                  alert('Veuillez remplir tous les champs.');
                  event.preventDefault(); // Empêche la soumission du formulaire
              }
          };
          </script>";
}


    public function renderEditArticleForm($article)
    {
        $this->renderHeader();

        // Création d'une nouvelle instance de FormView
        $form = new FormView("index.php?action=updateArticle&id={$article['id']}");

        // Ajout des champs au formulaire
        $form->addField('utilisateur_id', 'utilisateur_id', 'text', 'ID Utilisateur:', $article['utilisateur_id']);
        $form->addField('nom', 'nom', 'text', 'Nom:', $article['nom']);
        $form->addField('prenom', 'prenom', 'text', 'Prénom:', $article['prenom']);
        $form->addField('specialite', 'specialite', 'text', 'Spécialité:', $article['specialite']);
        $form->addField('telephone', 'telephone', 'text', 'Téléphone:', $article['telephone']);

        // Ajout des boutons au formulaire
        $form->addButton('submit', 'Valider');

        // Affichage du formulaire
        echo "<div class='container mt-5'>
                <div class='row'>
                    <div class='col-md-6 offset-md-3'>
                        <div class='card'>
                            <div class='card-header'>Modifier l article</div>
                            <div class='card-body'>";

        echo $form->build();

        echo "         </div>
                        </div>
                    </div>
                </div>
              </div>";

        // Ajout de JavaScript pour la validation du formulaire
        echo "<script>
              document.querySelector('form').onsubmit = function(event) {
                  let utilisateur_id = document.querySelector('[name=\"utilisateur_id\"]').value;
                  let nom = document.querySelector('[name=\"nom\"]').value;
                  let prenom = document.querySelector('[name=\"prenom\"]').value;
                  let specialite = document.querySelector('[name=\"specialite\"]').value;
                  let telephone = document.querySelector('[name=\"telephone\"]').value;

                  if(utilisateur_id === '' || nom === '' || prenom === '' || specialite === '' || telephone === '') {
                      alert('Veuillez remplir tous les champs.');
                      event.preventDefault(); // Empêche la soumission du formulaire
                  }
              };
              </script>";
    }


    public function renderEditClientForm($client)
    {
        $this->renderHeader();

        // Création d'une nouvelle instance de FormView
        $form = new FormView("index.php?action=updateClient&id={$client['id']}");

        // Ajout des champs au formulaire
        $form->addField('nom', 'nom', 'text', 'Nom:', $client['nom']);
        $form->addField('prenom', 'prenom', 'text', 'Prénom:', $client['prenom']);
        $form->addField('date_de_naissance', 'date_de_naissance', 'date', 'Date de Naissance:', $client['date_de_naissance']);
        $form->addField('email', 'email', 'email', 'Email:', $client['email']);
        $form->addField('telephone', 'telephone', 'text', 'Téléphone:', $client['telephone']);
        $form->addField('adresse', 'adresse', 'text', 'Adresse:', $client['adresse']);
        $form->addField('historique_medical', 'historique_medical', 'textarea', 'Historique Médical:', $client['historique_medical']);

        // Ajout des boutons au formulaire
        $form->addButton('submit', 'Valider');

        // Affichage du formulaire
        echo "<div class='container mt-5'>
                  <div class='row'>
                      <div class='col-md-6 offset-md-3'>
                          <div class='card'>
                              <div class='card-header'>Modifier le client</div>
                              <div class='card-body'>";

        echo $form->build();

        echo "         </div>
                          </div>
                      </div>
                  </div>
                </div>";

        // Ajout de JavaScript pour la validation du formulaire
        echo "<script>
                document.querySelector('form').onsubmit = function(event) {
                    let nom = document.querySelector('[name=\"nom\"]').value;
                    let prenom = document.querySelector('[name=\"prenom\"]').value;
                    let date_de_naissance = document.querySelector('[name=\"date_de_naissance\"]').value;
                    let email = document.querySelector('[name=\"email\"]').value;
                    let telephone = document.querySelector('[name=\"telephone\"]').value;
                    let adresse = document.querySelector('[name=\"adresse\"]').value;
                    let historique_medical = document.querySelector('[name=\"historique_medical\"]').value;

                    if(nom === '' || prenom === '' || date_de_naissance === '' || email === '' || telephone === '' || adresse === '' || historique_medical === '') {
                        alert('Veuillez remplir tous les champs.');
                        event.preventDefault(); // Empêche la soumission du formulaire
                    }
                };
                </script>";
    }



    /* Affiche le tableau de bord de l'administrateur pour les factures.
      *
      * @param array $factures Liste des factures.
      */
    public function adminDashboardFactures($factures)
    {
        $this->renderHeader();

        echo <<<HTML
          <div class="container mt-5">
              <div class="card">
                  <div class="card-header">
                      <ul class="nav nav-tabs card-header-tabs" id="myTabs">
                          <li class="nav-item">
                              <a class="nav-link active" data-toggle="tab" href="#factures">Factures</a>
                          </li>
                      </ul>
                  </div>
                  <div class="card-body">
                      <div class="tab-content">
                          <div class="tab-pane fade show active" id="factures">
          HTML;

        // Factures
        $factureColumns = ['Achat ID', 'Montant', 'Statut Paiement', 'Date Facture', 'Actions'];
        $this->renderTable("Liste des factures", $factures, function ($facture) {
            return [
                htmlspecialchars($facture['rendezvous_id']),
                htmlspecialchars($facture['montant']),
                htmlspecialchars($facture['statut_paiement']),
                htmlspecialchars($facture['date_facture']),
                "<a href='index.php?action=editFactures&id={$facture['id']}' class='btn btn-primary btn-sm'>Modifier</a>
                  <form method='post' action='index.php?action=deleteFactures' style='display: inline;'>
                  <input type='hidden' name='id' value='{$facture['id']}'>
                  <button class='btn btn-danger btn-sm' type='submit'>Supprimer</button>
                  </form>"
            ];
        }, $factureColumns);

        echo <<<HTML
                          </div>
                      </div> <!-- Fin de la tab-content -->
                  </div> <!-- Fin de la card-body -->
              </div> <!-- Fin de la card -->
          </div> <!-- Fin du container -->
          HTML;

        $this->renderDataTableScript();
    }

    public function renderEditFacturesForm($facture)
    {
        $this->renderHeader();

        // Formater la date pour l'input de type date
        $date_facture = date('Y-m-d\TH:i', strtotime($facture['date_facture']));

        // Création d'une nouvelle instance de FormView
        $form = new FormView("index.php?action=updateFactures&id={$facture['id']}");

        // Ajout des champs au formulaire
        $form->addField('rendezvous_id', 'rendezvous_id', 'text', 'ID Achat:', $facture['rendezvous_id']);
        $form->addField('montant', 'montant', 'text', 'Montant:', $facture['montant']);
        $form->addField('statut_paiement', 'statut_paiement', 'text', 'Statut Paiement:', $facture['statut_paiement']);
        $form->addField('date_facture', 'date_facture', 'datetime-local', 'Date Facture:', $date_facture);

        // Ajout des boutons au formulaire
        $form->addButton('submit', 'Valider');

        // Affichage du formulaire
        echo "<div class='container mt-5'>
                  <div class='row'>
                      <div class='col-md-6 offset-md-3'>
                          <div class='card'>
                              <div class='card-header'>Modifier la facture</div>
                              <div class='card-body'>";

        echo $form->build();

        echo "         </div>
                          </div>
                      </div>
                  </div>
                </div>";

        // Ajout de JavaScript pour la validation du formulaire
        echo "<script>
                document.querySelector('form').onsubmit = function(event) {
                    let rendezvous_id = document.querySelector('[name=\"rendezvous_id\"]').value;
                    let montant = document.querySelector('[name=\"montant\"]').value;
                    let statut_paiement = document.querySelector('[name=\"statut_paiement\"]').value;
                    let date_facture = document.querySelector('[name=\"date_facture\"]').value;

                    if(rendezvous_id === '' || montant === '' || statut_paiement === '' || date_facture === '') {
                        alert('Veuillez remplir tous les champs.');
                        event.preventDefault(); // Empêche la soumission du formulaire
                    }
                };
                </script>";
    }


    /* Affiche le tableau de bord de l'administrateur pour l'historique médical.
      *
      * @param array $historiques Liste des historiques médicaux.
      */
    public function adminDashboardHistorique($historiques)
    {
        $this->renderHeader();

        echo <<<HTML
          <div class="container mt-5">
              <div class="card">
                  <div class="card-header">
                      <ul class="nav nav-tabs card-header-tabs" id="myTabs">
                          <li class="nav-item">
                              <a class="nav-link active" data-toggle="tab" href="#historiques">Historique Médical</a>
                          </li>
                      </ul>
                  </div>
                  <div class="card-body">
                      <div class="tab-content">
                          <div class="tab-pane fade show active" id="historiques">
          HTML;

        // Historiques
        $historiqueColumns = ['Client', 'article', 'Date de Visite', 'Diagnostic', 'Traitement', 'Commentaires', 'Actions'];
        $this->renderTable("Liste des historiques d'achats ", $historiques, function ($historique) {
            return [
                htmlspecialchars($historique['client_id'] ?? 'Client non défini'),
                htmlspecialchars($historique['article_id'] ?? 'Article non défini'),
                htmlspecialchars($historique['date_visite'] ?? 'Date non définie'),
                htmlspecialchars($historique['diagnostic'] ?? 'Diagnostic non défini'),
                htmlspecialchars($historique['traitement'] ?? 'Traitement non défini'),
                htmlspecialchars($historique['commentaires'] ?? 'Aucun commentaire'),
                "<a href='index.php?action=editHistorique&id={$historique['id']}' class='btn btn-primary btn-sm'>Modifier</a>
                <form method='post' action='index.php?action=deleteHistorique' style='display: inline;'>
                    <input type='hidden' name='id' value='{$historique['id']}'>
                    <button class='btn btn-danger btn-sm' type='submit'>Supprimer</button>
                </form>"
            ];
        }, $historiqueColumns);

        echo <<<HTML
                          </div>
                      </div> <!-- Fin de la tab-content -->
                  </div> <!-- Fin de la card-body -->
              </div> <!-- Fin de la card -->
          </div> <!-- Fin du container -->
          HTML;

        $this->renderDataTableScript();
    }

    public function renderEditHistoriqueForm($historique)
    {
        $this->renderHeader();

        // Création d'une nouvelle instance de FormView
        $form = new FormView("index.php?action=updateHistorique&id={$historique['id']}");

        // Ajout des champs au formulaire
        $form->addField('client_id', 'client_id', 'text', 'ID Client:', $historique['client_id']);
        $form->addField('article_id', 'article_id', 'text', 'ID article:', $historique['article_id']);
        $form->addField('date_visite', 'date_visite', 'datetime-local', 'Date de Visite:', $historique['date_visite']);
        $form->addField('diagnostic', 'diagnostic', 'text', 'Diagnostic:', $historique['diagnostic']);
        $form->addField('traitement', 'traitement', 'text', 'Traitement:', $historique['traitement']);
        $form->addField('commentaires', 'commentaires', 'textarea', 'Commentaires:', $historique['commentaires']);

        // Ajout des boutons au formulaire
        $form->addButton('submit', 'Valider');

        // Affichage du formulaire
        echo "<div class='container mt-5'>
                  <div class='row'>
                      <div class='col-md-6 offset-md-3'>
                          <div class='card'>
                              <div class='card-header'>Modifier l'historique médical</div>
                              <div class='card-body'>";

        echo $form->build();

        echo "         </div>
                          </div>
                      </div>
                  </div>
                </div>";

        // Ajout de JavaScript pour la validation du formulaire
        echo "<script>
                document.querySelector('form').onsubmit = function(event) {
                    let client_id = document.querySelector('[name=\"client_id\"]').value;
                    let article_id = document.querySelector('[name=\"article_id\"]').value;
                    let date_visite = document.querySelector('[name=\"date_visite\"]').value;
                    let diagnostic = document.querySelector('[name=\"diagnostic\"]').value;
                    let traitement = document.querySelector('[name=\"traitement\"]').value;
                    let commentaires = document.querySelector('[name=\"commentaires\"]').value;

                    if(client_id === '' || article_id === '' || date_visite === '' || diagnostic === '' || traitement === '' || commentaires === '') {
                        alert('Veuillez remplir tous les champs.');
                        event.preventDefault(); // Empêche la soumission du formulaire
                    }
                };
                </script>";
    }


    /**
     * Affiche le tableau de bord de l'administrateur pour les responsables marketing.
     *
     * @param array $marketings Liste des responsables marketing.
     */
    public function adminDashboardMarketing($marketings)
    {
        $this->renderHeader();

        echo <<<HTML
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="myTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#Marketings">Secrétaires</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="Marketings">
        HTML;

        // Secrétaires
        $marketingColumns = ['Nom', 'Prénom', 'Téléphone', 'Actions'];
        $this->renderTable("Liste des secrétaires", $marketings, function ($marketing) {
            return [
                htmlspecialchars($marketing['nom']),
                htmlspecialchars($marketing['prenom']),
                htmlspecialchars($marketing['telephone']),
                "<a href='index.php?action=editMarketing&id={$marketing['id']}' class='btn btn-primary btn-sm'>Modifier</a>
                <form method='post' action='index.php?action=deleteMarketing' style='display: inline;'>
                <input type='hidden' name='id' value='{$marketing['id']}'>
                <button class='btn btn-danger btn-sm' type='submit'>Supprimer</button>
                </form>"
            ];
        }, $marketingColumns);

        echo <<<HTML
                        </div>
                    </div> <!-- Fin de la tab-content -->
                </div> <!-- Fin de la card-body -->
            </div> <!-- Fin de la card -->
        </div> <!-- Fin du container -->
        HTML;

        $this->renderDataTableScript();
    }


    /* Affiche le tableau de bord de l'administrateur pour les horaires de travail.
      *
      * @param array $horaires Liste des horaires de travail.
      */
    public function adminDashboardHoraires($horaires)
    {
        $this->renderHeader();

        echo <<<HTML
          <div class="container mt-5">
              <div class="card">
                  <div class="card-header">
                      <ul class="nav nav-tabs card-header-tabs" id="myTabs">
                          <li class="nav-item">
                              <a class="nav-link active" data-toggle="tab" href="#horaires">Horaires de Travail</a>
                          </li>
                      </ul>
                  </div>
                  <div class="card-body">
                      <div class="tab-content">
                          <div class="tab-pane fade show active" id="horaires">
          HTML;

        // Horaires
        $horairesColumns = ['article', 'Jour de la Semaine', 'Heure Début', 'Heure Fin', 'Type', 'Commentaires', 'Actions'];
        $this->renderTable("Liste des horaires de travail", $horaires, function ($horaire) {
            return [
                htmlspecialchars($horaire['article_id']),
                htmlspecialchars($horaire['jour_de_la_semaine']),
                htmlspecialchars($horaire['heure_debut']),
                htmlspecialchars($horaire['heure_fin']),
                htmlspecialchars($horaire['type']),
                htmlspecialchars($horaire['commentaire']),
                "<a href='index.php?action=editHoraires&id={$horaire['id']}' class='btn btn-primary btn-sm'>Modifier</a>
                  <form method='post' action='index.php?action=deleteHoraires' style='display: inline;'>
                  <input type='hidden' name='id' value='{$horaire['id']}'>
                  <button class='btn btn-danger btn-sm' type='submit'>Supprimer</button>
                  </form>"
            ];
        }, $horairesColumns);

        echo <<<HTML
                          </div>
                      </div> <!-- Fin de la tab-content -->
                  </div> <!-- Fin de la card-body -->
              </div> <!-- Fin de la card -->
          </div> <!-- Fin du container -->
          HTML;

        $this->renderDataTableScript();
    }

    public function renderEditHorairesForm($horaire)
    {
        $this->renderHeader();

        // Création d'une nouvelle instance de FormView
        $form = new FormView("index.php?action=updateHoraires&id={$horaire['id']}");

        // Ajout des champs au formulaire
        $form->addField('article_id', 'article_id', 'text', 'ID article:', $horaire['article_id']);
        $form->addField('jour_de_la_semaine', 'jour_de_la_semaine', 'text', 'Jour de la Semaine:', $horaire['jour_de_la_semaine']);
        $form->addField('heure_debut', 'heure_debut', 'time', 'Heure Début:', $horaire['heure_debut']);
        $form->addField('heure_fin', 'heure_fin', 'time', 'Heure Fin:', $horaire['heure_fin']);
        $form->addField('type', 'type', 'text', 'Type:', $horaire['type']);
        $form->addField('commentaire', 'commentaire', 'textarea', 'Commentaire:', $horaire['commentaire']);

        // Ajout des boutons au formulaire
        $form->addButton('submit', 'Valider');

        // Affichage du formulaire
        echo "<div class='container mt-5'>
                  <div class='row'>
                      <div class='col-md-6 offset-md-3'>
                          <div class='card'>
                              <div class='card-header'>Modifier l'horaire de travail</div>
                              <div class='card-body'>";

        echo $form->build();

        echo "         </div>
                          </div>
                      </div>
                  </div>
                </div>";

        // Ajout de JavaScript pour la validation du formulaire
        echo "<script>
                document.querySelector('form').onsubmit = function(event) {
                    let article_id = document.querySelector('[name=\"article_id\"]').value;
                    let jour_de_la_semaine = document.querySelector('[name=\"jour_de_la_semaine\"]').value;
                    let heure_debut = document.querySelector('[name=\"heure_debut\"]').value;
                    let heure_fin = document.querySelector('[name=\"heure_fin\"]').value;
                    let type = document.querySelector('[name=\"type\"]').value;
                    let commentaire = document.querySelector('[name=\"commentaire\"]').value;

                    if(article_id === '' || jour_de_la_semaine === '' || heure_debut === '' || heure_fin === '' || type === '' || commentaire === '') {
                        alert('Veuillez remplir tous les champs.');
                        event.preventDefault(); // Empêche la soumission du formulaire
                    }
                };
                </script>";
    }

    /* Affiche le tableau de bord de l'administrateur pour les associations article-Boutique.
      *
      * @param array $articleBoutiques Liste des associations article-Boutique.
      */
    public function adminDashboardArticleBoutique($articleBoutiques)
    {
        $this->renderHeader();

        echo <<<HTML
          <div class="container mt-5">
              <div class="card">
                  <div class="card-header">
                      <ul class="nav nav-tabs card-header-tabs" id="myTabs">
                          <li class="nav-item">
                              <a class="nav-link active" data-toggle="tab" href="#ArticleBoutique">article-Boutiques</a>
                          </li>
                      </ul>
                  </div>
                  <div class="card-body">
                      <div class="tab-content">
                          <div class="tab-pane fade show active" id="ArticleBoutique">
          HTML;

        $articleBoutiquesColumns = ['article ID', 'Boutique ID', 'Actions'];
        $this->renderTable("Liste des associations article-Boutique", $articleBoutiques, function ($articleBoutique) {
            return [
                htmlspecialchars($articleBoutique['article_id']),
                htmlspecialchars($articleBoutique['boutique_id']),
                "<a href='index.php?action=editArticleBoutique&article_id={$articleBoutique['article_id']}&boutique_id={$articleBoutique['boutique_id']}' class='btn btn-primary btn-sm'>Modifier</a>
                  <form method='post' action='index.php?action=deleteArticleBoutique' style='display: inline;'>
                  <input type='hidden' name='article_id' value='{$articleBoutique['article_id']}'>
                  <input type='hidden' name='boutique_id' value='{$articleBoutique['boutique_id']}'>
                  <button class='btn btn-danger btn-sm' type='submit'>Supprimer</button>
                  </form>"
            ];
        }, $articleBoutiquesColumns);

        echo <<<HTML
                          </div>
                      </div> <!-- Fin de la tab-content -->
                  </div> <!-- Fin de la card-body -->
              </div> <!-- Fin de la card -->
          </div> <!-- Fin du container -->
          HTML;

        $this->renderDataTableScript();
    }

    public function renderEditArticleBoutiqueForm($articleBoutique)
    {
        $this->renderHeader();

        // Création d'une nouvelle instance de FormView
        $form = new FormView("index.php?action=updateArticleBoutique&article_id={$articleBoutique['article_id']}&boutique_id={$articleBoutique['boutique_id']}");

        // Ajout des champs au formulaire
        $form->addField('article_id', 'article_id', 'text', 'ID article:', $articleBoutique['article_id']);
        $form->addField('boutique_id', 'boutique_id', 'text', 'ID Boutique:', $articleBoutique['boutique_id']);

        // Ajout des boutons au formulaire
        $form->addButton('submit', 'Valider');

        // Affichage du formulaire
        echo "<div class='container mt-5'>
                  <div class='row'>
                      <div class='col-md-6 offset-md-3'>
                          <div class='card'>
                              <div class='card-header'>Modifier l'association article-Boutique</div>
                              <div class='card-body'>";

        echo $form->build();

        echo "         </div>
                          </div>
                      </div>
                  </div>
                </div>";

        // Ajout de JavaScript pour la validation du formulaire
        echo "<script>
                document.querySelector('form').onsubmit = function(event) {
                    let article_id = document.querySelector('[name=\"article_id\"]').value;
                    let boutique_id = document.querySelector('[name=\"boutique_id\"]').value;

                    if(article_id === '' || boutique_id === '') {
                        alert('Veuillez remplir tous les champs.');
                        event.preventDefault(); // Empêche la soumission du formulaire
                    }
                };
                </script>";
    }

    /* Affiche le tableau de bord de l'administrateur pour les notes.
      *
      * @param array $notes Liste des notes.
      */
    public function adminDashboardNotes($notes)
    {
        $this->renderHeader();

        echo <<<HTML
          <div class="container mt-5">
              <div class="card">
                  <div class="card-header">
                      <ul class="nav nav-tabs card-header-tabs" id="myTabs">
                          <li class="nav-item">
                              <a class="nav-link active" data-toggle="tab" href="#notes">Notes</a>
                          </li>
                      </ul>
                  </div>
                  <div class="card-body">
                      <div class="tab-content">
                          <div class="tab-pane fade show active" id="notes">
          HTML;

        // Notes
        $notesColumns = ['Achat ID', 'Note', 'Date de Création', 'Actions'];
        $this->renderTable("Liste des notes", $notes, function ($note) {
            return [
                htmlspecialchars($note['rendezvous_id']),
                htmlspecialchars($note['note']),
                htmlspecialchars($note['date_creation']),
                "<a href='index.php?action=editNotes&id={$note['id']}' class='btn btn-primary btn-sm'>Modifier</a>
                  <form method='post' action='index.php?action=deleteNotes' style='display: inline;'>
                  <input type='hidden' name='id' value='{$note['id']}'>
                  <button class='btn btn-danger btn-sm' type='submit'>Supprimer</button>
                  </form>"
            ];
        }, $notesColumns);

        echo <<<HTML
                          </div>
                      </div> <!-- Fin de la tab-content -->
                  </div> <!-- Fin de la card-body -->
              </div> <!-- Fin de la card -->
          </div> <!-- Fin du container -->
          HTML;

        $this->renderDataTableScript();
    }

    public function renderEditMarketingForm($marketing)
    {
        $this->renderHeader();

        // Création d'une nouvelle instance de FormView
        $form = new FormView("index.php?action=updateMarketing&id={$marketing['id']}");

        // Ajout des champs au formulaire
        $form->addField('nom', 'nom', 'text', 'Nom:', $marketing['nom']);
        $form->addField('prenom', 'prenom', 'text', 'Prénom:', $marketing['prenom']);
        $form->addField('telephone', 'telephone', 'text', 'Téléphone:', $marketing['telephone']);

        // Ajout des boutons au formulaire
        $form->addButton('submit', 'Valider');

        // Affichage du formulaire
        echo "<div class='container mt-5'>
                <div class='row'>
                    <div class='col-md-6 offset-md-3'>
                        <div class='card'>
                            <div class='card-header'>Modifier le responsable marketing</div>
                            <div class='card-body'>";

        echo $form->build();

        echo "         </div>
                        </div>
                    </div>
                </div>
              </div>";

        // Ajout de JavaScript pour la validation du formulaire
        echo "<script>
              document.querySelector('form').onsubmit = function(event) {
                  let nom = document.querySelector('[name=\"nom\"]').value;
                  let prenom = document.querySelector('[name=\"prenom\"]').value;
                  let telephone = document.querySelector('[name=\"telephone\"]').value;

                  if(nom === '' || prenom === '' || telephone === '') {
                      alert('Veuillez remplir tous les champs.');
                      event.preventDefault(); // Empêche la soumission du formulaire
                  }
              };
              </script>";
    }

    public function renderEditNotesForm($note)
    {
        $this->renderHeader();

        // Création d'une nouvelle instance de FormView
        $form = new FormView("index.php?action=updateNotes&id={$note['id']}");

        // Ajout des champs au formulaire
        $form->addField('rendezvous_id', 'rendezvous_id', 'text', 'ID Achat:', $note['rendezvous_id']);
        $form->addField('note', 'note', 'textarea', 'Note:', $note['note']);

        // Ajout des boutons au formulaire
        $form->addButton('submit', 'Valider');

        // Affichage du formulaire
        echo "<div class='container mt-5'>
                  <div class='row'>
                      <div class='col-md-6 offset-md-3'>
                          <div class='card'>
                              <div class='card-header'>Modifier la note</div>
                              <div class='card-body'>";

        echo $form->build();

        echo "         </div>
                          </div>
                      </div>
                  </div>
                </div>";

        // Ajout de JavaScript pour la validation du formulaire
        echo "<script>
                document.querySelector('form').onsubmit = function(event) {
                    let rendezvous_id = document.querySelector('[name=\"rendezvous_id\"]').value;
                    let note = document.querySelector('[name=\"note\"]').value;

                    if(rendezvous_id === '' || note === '') {
                        alert('Veuillez remplir tous les champs.');
                        event.preventDefault(); // Empêche la soumission du formulaire
                    }
                };
                </script>";
    }

    /* Affiche le tableau de bord de l'administrateur pour les Achat.
      *
      * @param array $achat Liste des Achat.
      */
    public function adminDashboardAchat($achat)
    {
        $this->renderHeader();

        echo <<<HTML
          <div class="container mt-5">
              <div class="card">
                  <div class="card-header">
                      <ul class="nav nav-tabs card-header-tabs" id="myTabs">
                          <li class="nav-item">
                              <a class="nav-link active" data-toggle="tab" href="#achat">Achat</a>
                          </li>
                      </ul>
                  </div>
                  <div class="card-body">
                      <div class="tab-content">
                          <div class="tab-pane fade show active" id="achat">
          HTML;

        // Achat
        $achatColumns = ['article ID', 'Client ID', 'Date et Heure', 'Raison', 'Statut', 'Commentaires', 'Actions'];
        $this->renderTable("Liste des Achat", $achat, function ($achatItem) {
            return [
                htmlspecialchars($achatItem['article_id']),
                htmlspecialchars($achatItem['client_id']),
                htmlspecialchars($achatItem['date_heure']),
                htmlspecialchars($achatItem['raison']),
                htmlspecialchars($achatItem['statut']),
                htmlspecialchars($achatItem['commentaires']),
                "<a href='index.php?action=editAchat&id={$achatItem['id']}' class='btn btn-primary btn-sm'>Modifier</a>
                  <form method='post' action='index.php?action=deleteAchat' style='display: inline;'>
                  <input type='hidden' name='id' value='{$achatItem['id']}'>
                  <button class='btn btn-danger btn-sm' type='submit'>Supprimer</button>
                  </form>"
            ];
        }, $achatColumns);

        echo <<<HTML
                          </div>
                      </div> <!-- Fin de la tab-content -->
                  </div> <!-- Fin de la card-body -->
              </div> <!-- Fin de la card -->
          </div> <!-- Fin du container -->
          HTML;

        $this->renderDataTableScript();
    }

    public function renderEditAchatForm($achat)
    {
        $this->renderHeader();

        // Création d'une nouvelle instance de FormView
        $form = new FormView("index.php?action=updateAchat&id={$achat['id']}");

        // Ajout des champs au formulaire
        $form->addField('article_id', 'article_id', 'text', 'ID article:', $achat['article_id']);
        $form->addField('client_id', 'client_id', 'text', 'ID Client:', $achat['client_id']);
        $form->addField('date_heure', 'date_heure', 'datetime-local', 'Date et Heure:', $achat['date_heure']);
        $form->addField('raison', 'raison', 'text', 'Raison:', $achat['raison']);
        $form->addField('statut', 'statut', 'text', 'Statut:', $achat['statut']);
        $form->addField('commentaires', 'commentaires', 'textarea', 'Commentaires:', $achat['commentaires']);

        // Ajout des boutons au formulaire
        $form->addButton('submit', 'Valider');

        // Affichage du formulaire
        echo "<div class='container mt-5'>
                  <div class='row'>
                      <div class='col-md-6 offset-md-3'>
                          <div class='card'>
                              <div class='card-header'>Modifier l Achat</div>
                              <div class='card-body'>";

        echo $form->build();

        echo "         </div>
                          </div>
                      </div>
                  </div>
                </div>";

        // Ajout de JavaScript pour la validation du formulaire
        echo "<script>
                document.querySelector('form').onsubmit = function(event) {
                    let article_id = document.querySelector('[name=\"article_id\"]').value;
                    let client_id = document.querySelector('[name=\"client_id\"]').value;
                    let date_heure = document.querySelector('[name=\"date_heure\"]').value;
                    let raison = document.querySelector('[name=\"raison\"]').value;
                    let statut = document.querySelector('[name=\"statut\"]').value;
                    let commentaires = document.querySelector('[name=\"commentaires\"]').value;

                    if(article_id === '' || client_id === '' || date_heure === '' || raison === '' || statut === '' || commentaires === '') {
                        alert('Veuillez remplir tous les champs.');
                        event.preventDefault(); // Empêche la soumission du formulaire
                    }
                };
                </script>";
    }

    /* Affiche le tableau de bord de l'administrateur pour les boutiques.
      *
      * @param array $boutiques Liste des boutiques.
      */
    public function adminDashboardBoutiques($boutiques)
    {
        $this->renderHeader();

        echo <<<HTML
          <div class="container mt-5">
              <div class="card">
                  <div class="card-header">
                      <ul class="nav nav-tabs card-header-tabs" id="myTabs">
                          <li class="nav-item">
                              <a class="nav-link active" data-toggle="tab" href="#boutiques">Boutiques</a>
                          </li>
                      </ul>
                  </div>
                  <div class="card-body">
                      <div class="tab-content">
                          <div class="tab-pane fade show active" id="boutiques">
          HTML;

        // Boutiques
        $boutiqueColumns = ['Nom', 'Description', 'Actions'];
        $this->renderTable("Liste des boutiques", $boutiques, function ($boutique) {
            return [
                htmlspecialchars($boutique['nom']),
                htmlspecialchars($boutique['description']),
                "<a href='index.php?action=editBoutiques&id={$boutique['id']}' class='btn btn-primary btn-sm'>Modifier</a>
                  <form method='post' action='index.php?action=deleteBoutiques' style='display: inline;'>
                  <input type='hidden' name='id' value='{$boutique['id']}'>
                  <button class='btn btn-danger btn-sm' type='submit'>Supprimer</button>
                  </form>"
            ];
        }, $boutiqueColumns);

        echo <<<HTML
                          </div>
                      </div> <!-- Fin de la tab-content -->
                  </div> <!-- Fin de la card-body -->
              </div> <!-- Fin de la card -->
          </div> <!-- Fin du container -->
          HTML;

        $this->renderDataTableScript();
    }

    public function renderEditBoutiquesForm($boutique)
    {
        $this->renderHeader();

        // Création d'une nouvelle instance de FormView
        $form = new FormView("index.php?action=updateBoutiques&id={$boutique['id']}");

        // Ajout des champs au formulaire
        $form->addField('nom', 'nom', 'text', 'Nom:', $boutique['nom']);
        $form->addField('description', 'description', 'textarea', 'Description:', $boutique['description']);

        // Ajout des boutons au formulaire
        $form->addButton('submit', 'Valider');

        // Affichage du formulaire
        echo "<div class='container mt-5'>
                  <div class='row'>
                      <div class='col-md-6 offset-md-3'>
                          <div class='card'>
                              <div class='card-header'>Modifier la boutique</div>
                              <div class='card-body'>";

        echo $form->build();

        echo "         </div>
                          </div>
                      </div>
                  </div>
                </div>";

        // Ajout de JavaScript pour la validation du formulaire
        echo "<script>
                document.querySelector('form').onsubmit = function(event) {
                    let nom = document.querySelector('[name=\"nom\"]').value;
                    let description = document.querySelector('[name=\"description\"]').value;

                    if(nom === '' || description === '') {
                        alert('Veuillez remplir tous les champs.');
                        event.preventDefault(); // Empêche la soumission du formulaire
                    }
                };
                </script>";
    }

    private function isSelected($currentRole, $roleOption)
    {
        return $currentRole == $roleOption ? "selected" : "";
    }
}