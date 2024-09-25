<?php

require_once 'base_view.php';
require_once 'admin_view.php';
require_once 'form_view.php';
require_once 'form_container.php';


class MarketingView {

    public function renderHeader() {
        include 'templates/header.php';
    }

    public function renderFooter() {
        include 'templates/footer.php';
    }

    public function renderMarketingList($marketings) {
        $this->renderHeader();

        // Création du FormContainer
        $form_container = new FormContainer();

        // Ajout du fil d'Ariane
        $form_container->addBreadcrumb("Accueil", "index.php");
        $form_container->addBreadcrumb("Nos responsables marketing");

        // Ajout du titre principal
        $form_container->addMainTitle("Nos responsables marketing");

        // Check $articles not NULL
        if ($articles !== null) {
        // Ajout de chaque responsables marketing dans le FormContainer
        foreach ($articles as $article) {
          $form_container->addSubTitle("Nom " . htmlspecialchars($article['nom']));
            $form_container->addDescription("Téléphone : " . htmlspecialchars($article['telephone']));
          }
      } else {
        // Handle case where $articles is NULL
        $form_container->addDescription("Aucun(e) secrétaire trouvé(e).");
    }

        // Rendu du contenu
        echo $form_container->render();
    }

    // gestion des Clients 
    public function renderClientList($clients)
    {
        $this->renderHeader();

        $formContainer = new FormContainer();


        if (!empty($clients)) {
            $table = "<table class='table table-striped'>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>";
            foreach ($clients as $client) {
                $table .= "<tr>
                                <td>{$client['nom']}</td>
                                <td>{$client['prenom']}</td>
                                <td>{$client['email']}</td>
                                <td>{$client['telephone']}</td>
                              <td>
                                    <div class='btn-group'>
                                        <form action='index.php' method='get'>
                                            <input type='hidden' name='action' value='showClientDetails'>
                                            <input type='hidden' name='id' value='{$client['id']}'>
                                            <button type='submit' class='btn btn-primary display-btn' data-client-id='{$client['id']}'>Afficher</button>
                                        </form>
                                        <form action='index.php' method='get'>
                                            <input type='hidden' name='action' value='modifClient'>
                                            <input type='hidden' name='id' value='{$client['id']}'>
                                            <button type='submit' class='btn btn-warning edit-btn' data-client-id='{$client['id']}'>Modifier</button>
                                        </form>
                                         <form action='index.php' method='get'>
                                            <input type='hidden' name='action' value='montrerFormulaireRendezVous'>
                                            <input type='hidden' name='id' value='{$client['id']}'>
                                            <button type='submit' class='btn btn-success edit-btn' data-client-id='{$client['id']}'>Effectuer un achat</button>
                                        </form>
                                    </div>
                                </td>

                            </tr>";
            }


            $table .= "</tbody></table>";
            $formContainer->addElement('Liste des clients', $table);
        } else {
            $formContainer->addDescription("Aucun client trouvé.");
        }

        $formContainer->addElement('', "<a href='index.php?action=creeClientForm' class='btn btn-primary'>Ajouter un nouveau client</a>");

        echo $formContainer->render();

        // Ajout du script JavaScript pour gérer l'affichage des attributs du client
        echo "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var displayButtons = document.querySelectorAll('.display-btn');
                    displayButtons.forEach(function(button) {
                        button.addEventListener('click', function() {
                            var clientId = this.getAttribute('data-client-id');
                            window.location.href = 'index.php?action=showClientDetails&id=' + clientId;
                        });
                    });
                });
            </script>
        ";
    }


    public function renderClientDetails($clientDetails)
    {
        $this->renderHeader();

        // Affichage des détails du client
        echo "<h2>Détails du client</h2>";
        echo "<ul>";
        echo "<li><strong>Nom :</strong> {$clientDetails['nom']}</li>";
        echo "<li><strong>Prénom :</strong> {$clientDetails['prenom']}</li>";
        echo "<li><strong>Date de Naissance :</strong> {$clientDetails['date_de_naissance']}</li>";
        echo "<li><strong>Email :</strong> {$clientDetails['email']}</li>";
        echo "<li><strong>Téléphone :</strong> {$clientDetails['telephone']}</li>";
        echo "<li><strong>Adresse :</strong> {$clientDetails['adresse']}</li>";
        echo "<li><strong>Historique Médical :</strong> {$clientDetails['historique_medical']}</li>";
        echo "</ul>";

        // Bouton de retour vers le menu précédent
        echo "<a href='javascript:history.back()' class='btn btn-primary'>Retour</a>";
        echo "<a href='index.php?action=modifClient&id={$clientDetails['id']}' class='btn btn-warning'>Modifier</a>";
        echo "<a href='index.php?action=montrerFormulaireRendezVous&id={$clientDetails['id']}' class='btn btn-success'>Effectuer un achat</a>";
    }

    public function renderCreeClientForm()
    {
        $this->renderHeader();

        $form = new FormView("index.php?action=ajoutClient");

        // Ajout des champs au formulaire
        $form->addField('nom', 'nom', 'text', 'Nom:');
        $form->addField('prenom', 'prenom', 'text', 'Prénom:');
        $form->addField('date_de_naissance', 'date_de_naissance', 'date', 'Date de Naissance:');
        $form->addField('email', 'email', 'email', 'Email:');
        $form->addField('telephone', 'telephone', 'text', 'Téléphone:');
        $form->addField('adresse', 'adresse', 'text', 'Adresse:');
        $form->addField('historique_medical', 'historique_medical', 'textarea', 'Historique Médical:');

        // Ajout des boutons au formulaire
        $form->addButton('submit', 'Valider');

        echo "<div class='container mt-5'>
                <div class='row'>
                    <div class='col-md-6 offset-md-3'>
                        <div class='card'>
                            <div class='card-header'>Ajouter un Client</div>
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
                if (!confirm('Êtes-vous sûr de vouloir supprimer cet achat ?')) {
                    e.preventDefault();
                }
            });
        });
        </script>
        HTML;
    }

    public function renderEditClientForm($client)
    {
        $this->renderHeader();

        // Création d'une nouvelle instance de FormView
        $form = new FormView("index.php?action=miseAjourClient&id={$client['id']}");

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

    public function renderCreateAchatForm($articles, $clients)
    {
        $this->renderHeader();

        echo "<div class='container mt-5'>";
        echo "<h2 class='text-center mb-4'>Créer un achat</h2>";
        echo "<form action='index.php?action=ajouterRendezVous' method='post'>";

        echo "<div class='form-group row'>";
        echo "<label for='article' class='col-sm-3 col-form-label'>Médecin:</label>";
        echo "<div class='col-sm-9'>";
        echo "<select class='form-control' id='article' name='article' required>";
        foreach ($articles as $article) {
            echo "<option value='{$article['id']}'>{$article['prenom']} {$article['nom']}  {$article['specialite']}</option>";
        }
        echo "</select>";
        echo "</div>";
        echo "</div>";

        echo "<div class='form-group row'>";
        echo "<label for='client' class='col-sm-3 col-form-label'>Client:</label>";
        echo "<div class='col-sm-9'>";
        echo "<select class='form-control' id='client' name='client' required>";
        foreach ($clients as $client) {
            echo "<option value='{$client['id']}'>{$client['prenom']} {$client['nom']}</option>";
        }
        echo "</select>";
        echo "</div>";
        echo "</div>";

        echo "<div class='form-group row'>";
        echo "<label for='achat' class='col-sm-3 col-form-label'>Date et heure du achat:</label>";
        echo "<div class='col-sm-9'>";
        echo "<input type='datetime-local' class='form-control' id='achat' name='achat' required>";
        echo "</div>";
        echo "</div>";

        echo "<div class='form-group row'>";
        echo "<label for='raison' class='col-sm-3 col-form-label'>Raison du achat:</label>";
        echo "<div class='col-sm-9'>";
        echo "<input type='text' class='form-control' id='raison' name='raison' required>";
        echo "</div>";
        echo "</div>";

        echo "<div class='form-group row'>";
        echo "<label for='remarques' class='col-sm-3 col-form-label'>Commentaires:</label>";
        echo "<div class='col-sm-9'>";
        echo "<textarea class='form-control' id='remarques' name='remarques' rows='4' cols='50'></textarea>";
        echo "</div>";
        echo "</div>";

        echo "<div class='text-right'>";
        echo "<button type='submit' class='btn btn-primary'>Valider le achat</button>";
        echo "<a href='index.php?action=listeClients' class='btn btn-success'>Retour</a>";
        echo "</div>";

        echo "</form>";
        echo "</div>";
    }

    public function marketingAchat($achat)
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

        // achat
        $achatColumns = ['Médecin ID', 'Client ID', 'Date et Heure', 'Raison', 'Statut', 'Commentaires', 'Action'];
        $this->renderTable("Liste des achat", $achat, function ($achatItem) {
            return [
                htmlspecialchars($achatItem['article_id']),
                htmlspecialchars($achatItem['client_id']),
                htmlspecialchars($achatItem['date_heure']),
                htmlspecialchars($achatItem['raison']),
                htmlspecialchars($achatItem['statut']),
                htmlspecialchars($achatItem['commentaires']),
                $this->getActionButton($achatItem)
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



    public function marketingConfirmedAchat($achat)
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

        // achat
        $achatColumns = ['Médecin ID', 'Client ID', 'Date et Heure', 'Raison', 'Statut', 'Commentaires', 'Action'];
        $this->renderTable("Liste des achat", $achat, function ($achatItem) {
            return [
                htmlspecialchars($achatItem['article_id']),
                htmlspecialchars($achatItem['client_id']),
                htmlspecialchars($achatItem['date_heure']),
                htmlspecialchars($achatItem['raison']),
                htmlspecialchars($achatItem['statut']),
                htmlspecialchars($achatItem['commentaires']),
                $this->getActionButton($achatItem)
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


    public function marketingPendingAchat($achat)
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

        // achat
        $achatColumns = ['Médecin ID', 'Client ID', 'Date et Heure', 'Raison', 'Statut', 'Commentaires', 'Action'];
        $this->renderTable("Liste des achat", $achat, function ($achatItem) {
            return [
                htmlspecialchars($achatItem['article_id']),
                htmlspecialchars($achatItem['client_id']),
                htmlspecialchars($achatItem['date_heure']),
                htmlspecialchars($achatItem['raison']),
                htmlspecialchars($achatItem['statut']),
                htmlspecialchars($achatItem['commentaires']),
                $this->getActionButton($achatItem)
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


    public function marketingCancelledAchat($achat)
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
        $achatColumns = ['Médecin ID', 'Client ID', 'Date et Heure', 'Raison', 'Statut', 'Commentaires', 'Action'];
        $this->renderTable("Liste des achat", $achat, function ($achatItem) {
            return [
                htmlspecialchars($achatItem['article_id']),
                htmlspecialchars($achatItem['client_id']),
                htmlspecialchars($achatItem['date_heure']),
                htmlspecialchars($achatItem['raison']),
                htmlspecialchars($achatItem['statut']),
                htmlspecialchars($achatItem['commentaires']),
                $this->getActionButton($achatItem)
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

    private function getActionButton($achatItem)
    {
        $id = htmlspecialchars($achatItem['id']);
        $statut = htmlspecialchars($achatItem['statut']);
        $button = '';

        if ($statut == 'annule') {
            $button = "<a href='index.php?action=changerStatutRendezVous&id={$id}&statut=confirme' class='btn btn-success'>Confirmer</a>";
        } elseif ($statut == 'en_attente') {
            $button = "<a href='index.php?action=changerStatutRendezVous&id={$id}&statut=confirme' class='btn btn-success'>Confirmer</a>";
        } elseif ($statut == 'confirme') {
            $button = "<a href='index.php?action=changerStatutRendezVous&id={$id}&statut=annule' class='btn btn-danger'>Annuler</a>";
            $button .= " <a href='index.php?action=changerStatutRendezVous&id={$id}&statut=en_attente' class='btn btn-warning'>Mettre en attente</a>";
        }

        return $button;
    }

    public function marketingHoraires($horaires)
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
        $horairesColumns = ['Médecin', 'Jour de la Semaine', 'Heure Début', 'Heure Fin', 'Type', 'Commentaires', 'Actions'];
        $this->renderTable("Liste des horaires de travail", $horaires, function ($horaire) {
            return [
                htmlspecialchars($horaire['article_id']),
                htmlspecialchars($horaire['jour_de_la_semaine']),
                htmlspecialchars($horaire['heure_debut']),
                htmlspecialchars($horaire['heure_fin']),
                htmlspecialchars($horaire['type']),
                htmlspecialchars($horaire['commentaire']),
                "<a href='index.php?action=modifHoraires&id={$horaire['id']}' class='btn btn-primary btn-sm'>Modifier</a>
                  <form method='post' action='index.php?action=supprimeHoraires' style='display: inline;'>
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

    public function renderChangeHorairesForm($horaire)
    {
        $this->renderHeader();

        // Création d'une nouvelle instance de FormView
        $form = new FormView("index.php?action=changeHoraires&id={$horaire['id']}");

        // Ajout des champs au formulaire
        $form->addField('article_id', 'article_id', 'text', 'ID Article:', $horaire['article_id']);
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

}