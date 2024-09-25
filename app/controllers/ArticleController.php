<?php
require_once 'app/models/ArticleModel.php';
require_once 'app/models/HistoriqueAchatsModel.php';
require_once 'app/models/NotesModel.php';
require_once 'app/models/ClientModel.php';
require_once 'app/models/AchatModel.php';
require_once 'app/views/article_view.php';
require_once 'app/controllers/BaseController.php';




class ArticleController extends BaseController {
    private $articleModel;
    private $HistoriqueAchatsModel;
    private $notesModel;
    private $clientModel;
    private $achatModel;
    private $articleView;

    public function __construct() {
        $this->articleModel = new ArticleModel();
        $this->clientModel = new clientModel();
        $this->HistoriqueAchatsModel = new HistoriqueAchatsModel();
        $this->AchatModel = new AchatModel();
        $this->notesModel = new NotesModel();
        $this->articleView = new ArticleView();
    }

    public function homeArticle() {
        $articles = $this->articleModel->lire();
        $this->articleView->renderArticleList($articles);
    }

    public function listArticles() {
        $articles = $this->articleModel->lire();
        $this->articleView->displayArticles($articles);
    }

    public function viewArticle($id) {
        $article = $this->articleModel->lireUn($id);
        if ($article) {
            $this->articleView->displaySingleArticle($article);
        } else {
            echo "Article introuvable.";
        }
    }

  
// Méthodes pour gérer les historiques des achats
public function viewBuyHistory() {
  if (!isset($_SESSION['article_id'])) {
      echo "Erreur : ID de l'article non défini.";
      return;
  }

    $article_id = $_SESSION['article_id'];
    $histories = $this->HistoriqueAchatsModel->lire();
    $this->articleView->renderBuyHistories($histories);
}

public function addBuyHistory() {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = [
        'article_id' => $_SESSION['article_id'],
        'client_id' => $_POST['client_id'],
        'date_visite' => $_POST['date_visite'],
        'diagnostic' => $_POST['diagnostic'],
        'traitement' => $_POST['traitement'],
        'commentaires' => $_POST['commentaires']
    ];

    if ($this->HistoriqueAchatsModel->creer($data)) {
        header("Location: index.php?action=viewBuyHistory");
    } else {
        echo "Erreur : Échec de la création de l'historique médical.";
    }
  } else {
      $this->articleView->renderCreateBuyHistoryForm($_SESSION['article_id']);
  }
}

public function renderCreateBuyHistoryForm() {
  $article_id = $_SESSION['article_id']; // Récupérer l'ID du médecin à partir de la session
  $this->articleView->renderCreateBuyHistoryForm($article_id);
}

// Méthodes pour gérer les patients
public function listPatients() {
    $patients = $this->patientModel->lire();
    $this->articleView->renderPatientList($patients);
}

public function CreatePatientForm() {
    $this->articleView->renderCreatePatientForm();
}

public function addPatient() {
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
        header("Location: index.php?action=listPatients");
    } else {
        echo "Erreur : Échec de la création du patient.";
    }
}


// Méthodes pour gérer les Achat

public function viewConfirmedAchats() {
    if (!isset($_SESSION['article_id'])) {
        echo "Erreur : ID de l article non défini.";
        return;
    }

    $article_id = $_SESSION['article_id'];
    $achats = $this->achatModel->lireConfirmesParArticle($article_id);
    $this->articleView->renderConfirmedAchats($achats);
}

}

?>