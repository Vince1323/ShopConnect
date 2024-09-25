<?php
require_once 'app/models/MarketingModel.php';
require_once 'app/models/AchatModel.php';
require_once 'app/views/marketing_view.php';
require_once 'app/controllers/BaseController.php';


class MarketingController extends BaseController
{
    private $marketingModel;
    private $marketingView;
    private $patientModel;
    private $medecinModel;
    private $achatModel;
    private $horairesTravailModel;

    public function __construct()
    {
        $this->marketingModel = new marketingModel();
        $this->marketingView = new MarketingView();
        $this->clientModel = new ClientModel();
        $this->achatModel = new AchatModel();
    }

    public function homeMarketing() {
        $marketings = $this->marketingModel->lire();
        $this->marketingView->renderMarketingList($marketings);
    }

    public function listMarketings() {
        $marketings = $this->marketingModel->lire();
        $this->marketingView->displayMarketings($marketings);
    }

    public function viewMarketing($id) {
        $marketing = $this->marketingModel->lireUn($id);
        if ($marketing) {
            $this->marketingView->displaySingleMarketing($marketing);
        } else {
            echo "Marketing introuvable.";
        }
    }

    public function createMarketing($utilisateur_id, $nom, $prenom, $telephone) {
        $this->marketingModel->utilisateur_id = $utilisateur_id;
        $this->marketingModel->nom = $nom;
        $this->marketingModel->prenom = $prenom;
        $this->marketingModel->telephone = $telephone;

        $success = $this->marketingModel->creer();
        if ($success) {
            echo "Marketing créé avec succès!";
        } else {
            echo "Erreur lors de la création du Marketing.";
        }
    }


    // Afficher tous les secrétaires
    public function listerMarketings()
    {
        $marketings = $this->marketingModel->obtenirTousLesMarketings();
        $this->marketingView->afficherMarketings($marketings);
    }

    // Afficher le formulaire de création de secrétaire
    public function montrerFormulaireCreation()
    {
        $this->marketingView->renderCreateAchatForm();
    }

    // Créer un nouveau secrétaire
    public function creerMarketing($donnees)
    {
        $resultat = $this->marketingModel->creerMarketing($donnees['utilisateur_id'], $donnees['nom'], $donnees['prenom'], $donnees['telephone']);
        if ($resultat) {
            $this->redirect('index.php?action=listerMarketings');
        } else {
            echo "Erreur lors de la création du secrétaire.";
        }
    }

    // Afficher le formulaire de modification de secrétaire
    public function montrerFormulaireModification($id)
    {
        $marketing = $this->marketingModel->obtenirMarketingParId($id);
        $this->marketingView->afficherFormulaireMarketing($marketing);
    }

    // Mettre à jour les informations d'un secrétaire
    public function mettreAJourMarketing($id, $donnees)
    {
        $resultat = $this->marketingModel->mettreAJourMarketing($id, $donnees['nom'], $donnees['prenom'], $donnees['telephone']);
        if ($resultat) {
            $this->redirect('index.php?action=listerMarketings');
        } else {
            echo "Erreur lors de la mise à jour du secrétaire.";
        }
    }

    // Supprimer un secrétaire
    public function supprimerMarketing($id)
    {
        $resultat = $this->marketingModel->supprimerMarketing($id);
        if ($resultat) {
            $this->redirect('index.php?action=listerMarketings');
        } else {
            echo "Erreur lors de la suppression du secrétaire.";
        }
    }

    // Méthodes pour gérer les patients
    public function listePatients()
    {
        $patients = $this->patientModel->lire();
        $this->marketingView->renderPatientList($patients);
    }

    public function CreePatientForm()
    {
        $this->marketingView->renderCreePatientForm();
    }

    public function ajoutPatient()
    {
        $data = [
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'date_de_naissance' => $_POST['date_de_naissance'],
            'email' => $_POST['email'],
            'telephone' => $_POST['telephone'],
            'adresse' => $_POST['adresse'],
            'historique_medical' => $_POST['historique_medical']
        ];

        if ($this->patientModel->creer($data)) {
            header("Location: index.php?action=listePatients");
        } else {
            echo "Erreur : Échec de la création du patient.";
        }
    }

    public function showPatientDetails($patientId)
    {
        // Récupérer les détails du patient avec l'ID $patientId depuis la base de données
        $patientDetails = $this->patientModel->lireUn($patientId);

        // Vérifier si les détails du patient ont été récupérés avec succès
        if ($patientDetails) {
            $this->marketingView->renderPatientDetails($patientDetails);
        } else {
            echo "Aucun patient trouvé avec cet identifiant.";
        }
    }


    /**
     * Fonctions Edit (Patient)
     */
    public function editPatient($id)
    {
        $patient = $this->patientModel->lireUn($id);
        if ($patient) {
            $this->marketingView->renderEditPatientForm($patient);
        } else {
            // Gérer l'erreur
            echo "Erreur : Le patient n'existe pas.";
        }
    }

    /**
     * Fonctions Update (Patient)
     */
    public function updatePatient($id, $data)
    {
        $success = $this->marketingModel->editPatient($id, $data);

        if ($success) {
            header("Location: index.php?action=listePatients");
            exit();
        } else {
            echo "Erreur lors de la mise à jour du patient.";
        }
    }

    // Méthode pour afficher le formulaire de création de rendez-vous   
    public function creerAchat($data)
    {
        $query = "INSERT INTO achat (article_id, client_id, date_heure, remarques) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiss", $data['article_id'], $data['client_id'], $data['date_heure'], $data['remarques']);
        return $stmt->execute();
    }

    public function montrerFormulaireAchat()
    {
        $clients = $this->marketingModel->lireClients();
        $articles = $this->marketingModel->lireArticles();
        $this->marketingView->renderCreateAchatForm($articles, $clients);
    }

    public function ajouterRendezVous()
    {
        $data = [
            'article_id' => $_POST['article'],
            'client_id' => $_POST['client'],
            'date_heure' => $_POST['Achat'],
            'raison' => $_POST['raison'],
            'statut' => 'confirme',
            'commentaires' => $_POST['remarques']
        ];

        if ($this->marketingModel->creerAchat($data)) {
            header("Location: index.php?action=listerAchat");
            exit;
        } else {
            echo "Erreur lors de la création de la commande.";
        }
    }

    public function viewAllAchat()
    {
        try {
            $achat = $this->achatModel->lire();
            $this->marketingView->MarketingAchat($achat);
        } catch (Exception $e) {
            $this->handleError($e->getMessage());
        }
    }

    public function viewConfirmedAchat()
    {
        try {
            $achat = $this->marketingModel->getConfirmedAchat();
            $this->marketingView->marketingAchat($achat);
        } catch (Exception $e) {
            $this->handleError($e->getMessage());
        }
    }

    public function viewPendingAchat()
    {
        try {
            $achat = $this->marketingModel->getPendingAchat();
            $this->marketingView->marketingAchat($achat);
        } catch (Exception $e) {
            $this->handleError($e->getMessage());
        }
    }

    public function viewCancelledAchat()
    {
        try {
            $achat = $this->marketingModel->getCancelledAchat();
            $this->marketingView->marketingAchat($achat);
        } catch (Exception $e) {
            $this->handleError($e->getMessage());
        }
    }

    public function changerStatutAchat($id, $statut)
    {
        $this->marketingModel->changerStatut($id, $statut);
        $this->redirect('index.php?action=viewAllAchat');
    }
   
}
?>