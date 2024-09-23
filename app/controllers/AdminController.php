<?php
require_once 'app/models/UserModel.php';
require_once 'app/models/ArticleModel.php';
require_once 'app/models/ClientModel.php';
require_once 'app/models/FacturesModel.php';
require_once 'app/models/HistoriqueAchatsModel.php';
require_once 'app/models/ArticleBoutiqueModel.php';
require_once 'app/models/NotesModel.php';
require_once 'app/models/AchatModel.php';
require_once 'app/models/BoutiqueModel.php';
require_once 'app/models/MarketingModel.php';
require_once 'app/views/admin_view.php';

class AdminController extends BaseController
{
    private $userModel;
    private $articleModel;
    private $clientModel;
    private $facturesModel;
    private $historiqueAchatsModel;
    private $articleBoutiqueModel;
    private $notesModel;
    private $achatModel;
    private $marketingModel;
    private $boutiqueModel;

    private $adminView;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->articleModel = new ArticleModel();
        $this->clientModel = new ClientModel();
        $this->facturesModel = new FacturesModel();
        $this->historiqueAchatsModel = new HistoriqueAchatsModel();
        $this->articleBoutiqueModel = new ArticleBoutiqueModel();
        $this->notesModel = new NotesModel();
        $this->achatModel = new AchatModel();
        $this->boutiqueModel = new BoutiqueModel();
        $this->marketingModel = new MarketingModel();

        $this->adminView = new AdminView();
    }
    /**
     * Fonctions Admin (Dashboard)
     */
    public function isUserAdmin()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'Admin';
    }

    public function dashboard()
    {
        if (!$this->isUserAdmin()) {
            $this->handleError('Accès refusé. Vous devez être connecté en tant qu\'administrateur.');
            return;
        }

        $this->adminView->renderAdminDashboard();
    }

    /**
     * Dashboard USER (User)
     */

    public function dashboardUser()
    {
        if (!$this->isUserAdmin()) {
            $this->handleError('Accès refusé. Vous devez être connecté en tant qu\'administrateur.');
            return;
        }

        $this->showDashboardUser();
    }

    private function showDashboardUser()
    {
        try {
            $users = $this->userModel->getUsers();
            $this->adminView->AdminDashboardUser($users);
        } catch (Exception $e) {
            $this->handleError($e->getMessage());
        }
    }

    /**
     * Dashboard Article (Article)
     */

    public function dashboardArticle()
    {
        if (!$this->isUserAdmin()) {
            $this->handleError('Accès refusé. Vous devez être connecté en tant qu\'administrateur.');
            return;
        }

        $this->showDashboardArticle();
    }

    private function showDashboardArticle()
    {
        try {
            $articles = $this->articleModel->lire();
            $this->adminView->adminDashboardArticle($articles);
        } catch (Exception $e) {
            $this->handleError($e->getMessage());
        }
    }

    /**
     * Dashboard Client (Client)
     */

    public function dashboardClient()
    {
        if (!$this->isUserAdmin()) {
            $this->handleError('Accès refusé. Vous devez être connecté en tant qu\'administrateur.');
            return;
        }

        $this->showDashboardClient();
    }

    private function showDashboardClient()
    {
        try {
            $clients = $this->clientModel->lire();
            $this->adminView->adminDashboardClient($clients);
        } catch (Exception $e) {
            $this->handleError($e->getMessage());
        }
    }

    /**
     * Dashboard Marketing (Marketing)
     */

    public function dashboardMarketing()
    {
        if (!$this->isUserAdmin()) {
            $this->handleError('Accès refusé. Vous devez être connecté en tant qu\'administrateur.');
            return;
        }

        $this->showDashboardMarketing();
    }

    private function showDashboardMarketing()
    {
        try {
            $marketings = $this->marketingModel->lire();
            $this->adminView->adminDashboardMarketing($marketings);
        } catch (Exception $e) {
            $this->handleError($e->getMessage());
        }
    }


    /**
     * Fonctions Edit (User)
     */
    public function editUser($id)
    {
        $user = $this->userModel->getUserById($id);
        if ($user) {
            $this->adminView->renderEditUserForm($user);
        } else {
            // Gérer l'erreur
            echo "Erreur : L'utilisateur n'existe pas.";
        }
    }

    /**
     * Fonctions Update (User)
     */
    public function updateUser($id, $data)
    {
        $result = $this->userModel->updateById($id, $data);
        if ($result) {
            header("Location: index.php?action=dashboardUser");
            exit;
        } else {
            // Gérer l'erreur
            echo "Erreur : Échec de la mise à jour.";
        }
    }

    /**
     * Fonctions Delete (User)
     */
    public function deleteUser()
    {
        $id = $_POST['id'];
        $this->userModel->deleteById($id);
        header("Location: index.php?action=adminDashboard");  // Redirige vers le tableau de bord après la suppression
    }

    /**
     * Fonctions Edit (Article)
     */
    public function editArticle($id)
    {
        $article = $this->articleModel->lireUn($id);
        if ($article) {
            $this->adminView->renderEditArticleForm($article);
        } else {
            // Gérer l'erreur
            echo "Erreur : Le produit n'existe pas.";
        }
    }

    /**
     * Fonctions Update (Article)
     */
    public function updateArticle($id, $data)
    {
        $success = $this->articleModel->mettreAJour($id, $data);

        if ($success) {
            header("Location: index.php?action=dashboardArticle");
            exit();
        } else {
            echo "Erreur lors de la mise à jour du produit.";
        }
    }

    /**
     * Fonctions Delete (Article)
     */
    public function deleteArticle()
    {
        $id = $_POST['id'];
        $this->articleModel->id = $id;
        $this->articleModel->supprimer();
        header("Location: index.php?action=adminDashboardArticle");  // Redirige vers le tableau de bord après la suppression
    }

    /**
     * Fonctions Edit (Client)
     */
    public function editClient($id)
    {
        $client = $this->ClientModel->lireUn($id);
        if ($client) {
            $this->adminView->renderEditClientForm($client);
        } else {
            // Gérer l'erreur
            echo "Erreur : Le client n'existe pas.";
        }
    }

    /**
     * Fonctions Update (Client)
     */
    public function updateClient($id, $data)
    {
        $success = $this->clientModel->mettreAJour($id, $data);

        if ($success) {
            header("Location: index.php?action=dashboardClient");
            exit();
        } else {
            echo "Erreur lors de la mise à jour du client.";
        }
    }

    /**
     * Fonctions Delete (Client)
     */
    public function deleteClient()
    {
        $id = $_POST['id'];
        $this->clientModel->id = $id;
        $this->clientModel->supprimer();
        header("Location: index.php?action=adminDashboardClient");  // Redirige vers le tableau de bord après la suppression
    }


    /**
     * Dashboard Factures (Factures)
     */
    public function dashboardFactures()
    {
        if (!$this->isUserAdmin()) {
            $this->handleError('Accès refusé. Vous devez être connecté en tant qu\'administrateur.');
            return;
        }

        $this->showDashboardFactures();
    }

    private function showDashboardFactures()
    {
        try {
            $factures = $this->facturesModel->lire();
            $this->adminView->adminDashboardFactures($factures);
        } catch (Exception $e) {
            $this->handleError($e->getMessage());
        }
    }

    /**
     * Fonctions Edit, update, delete (Factures)
     */
    public function editFactures($id)
    {
        $facture = $this->facturesModel->lireUn($id);
        if ($facture) {
            $this->adminView->renderEditFacturesForm($facture);
        } else {
            echo "Erreur : La facture n'existe pas.";
        }
    }

    public function updateFactures($id, $data)
    {
        $success = $this->facturesModel->mettreAJour($id, $data);

        if ($success) {
            header("Location: index.php?action=dashboardFactures");
            exit();
        } else {
            echo "Erreur lors de la mise à jour de la facture.";
        }
    }

    public function deleteFactures()
    {
        $id = $_POST['id'];
        $this->facturesModel->supprimer($id);
        header("Location: index.php?action=dashboardFactures");
    }

    /**
     * Dashboard Historique (Historique)
     */
    public function dashboardHistorique()
    {
        if (!$this->isUserAdmin()) {
            $this->handleError('Accès refusé. Vous devez être connecté en tant qu\'administrateur.');
            return;
        }

        $this->showDashboardHistorique();
    }

    private function showDashboardHistorique()
    {
        try {
            $historiques = $this->historiqueAchatsModel->lire();
            $this->adminView->adminDashboardHistorique($historiques);
        } catch (Exception $e) {
            $this->handleError($e->getMessage());
        }
    }

    /**
     * Fonctions Edit, update, delete (Historique)
     */
    public function editHistorique($id)
    {
        $historique = $this->historiqueAchatsModel->lireUn($id);
        if ($historique) {
            $this->adminView->renderEditHistoriqueForm($historique);
        } else {
            echo "Erreur : L'historique médical n'existe pas.";
        }
    }

    public function updateHistorique($id, $data)
    {
        $success = $this->historiqueAchatsModel->mettreAJour($id, $data);

        if ($success) {
            header("Location: index.php?action=dashboardHistorique");
            exit();
        } else {
            echo "Erreur lors de la mise à jour de l'historique médical.";
        }
    }

    public function deleteHistorique()
    {
        $id = $_POST['id'];
        $this->historiqueAchatsModel->supprimer($id);
        header("Location: index.php?action=dashboardHistorique");
    }


    /**
     * Dashboard ArticleBoutique (ArticleBoutique)
     */
    public function dashboardArticleBoutique()
    {
        if (!$this->isUserAdmin()) {
            $this->handleError('Accès refusé. Vous devez être connecté en tant qu\'administrateur.');
            return;
        }

        $this->showDashboardArticleBoutique();
    }

    private function showDashboardArticleBoutique()
    {
        try {
            $articleBoutique = $this->articleBoutiqueModel->lire();
            $this->adminView->adminDashboardArticleBoutique($articleBoutique);
        } catch (Exception $e) {
            $this->handleError($e->getMessage());
        }
    }

    /**
     * Fonctions Edit, update, delete (ArticleBoutique)
     */
    public function editArticleBoutique($article_id, $boutique_id)
    {
        $articleBoutique = $this->articleBoutiqueModel->lireUn($article_id, $boutique_id);
        if ($articleBoutique) {
            $this->adminView->renderEditArticleBoutiqueForm($articleBoutique);
        } else {
            echo "Erreur : L'association article-boutique n'existe pas.";
        }
    }

    public function updateArticleBoutique($article_id, $boutique_id, $data)
    {
        $success = $this->articleBoutiqueModel->mettreAJour($article_id, $boutique_id, $data);

        if ($success) {
            header("Location: index.php?action=dashboardArticleBoutique");
            exit();
        } else {
            echo "Erreur lors de la mise à jour de l'association article-boutique.";
        }
    }

    public function deleteArticleBoutique()
    {
        $article_id = $_POST['article_id'];
        $boutique_id = $_POST['boutique_id'];
        $this->articleBoutiqueModel->supprimer($article_id, $boutique_id);
        header("Location: index.php?action=dashboardArticleBoutique");
    }
    /**
     * Dashboard Notes (Notes)
     */
    public function dashboardNotes()
    {
        if (!$this->isUserAdmin()) {
            $this->handleError('Accès refusé. Vous devez être connecté en tant qu\'administrateur.');
            return;
        }

        $this->showDashboardNotes();
    }

    private function showDashboardNotes()
    {
        try {
            $notes = $this->notesModel->lire();
            $this->adminView->adminDashboardNotes($notes);
        } catch (Exception $e) {
            $this->handleError($e->getMessage());
        }
    }

    /**
     * Fonctions Edit, update, delete (Notes)
     */
    public function editNotes($id)
    {
        $note = $this->notesModel->lireUn($id);
        if ($note) {
            $this->adminView->renderEditNotesForm($note);
        } else {
            echo "Erreur : La note n'existe pas.";
        }
    }

    public function updateNotes($id, $data)
    {
        $success = $this->notesModel->mettreAJour($id, $data);

        if ($success) {
            header("Location: index.php?action=dashboardNotes");
            exit();
        } else {
            echo "Erreur lors de la mise à jour de la note.";
        }
    }

    public function deleteNotes()
    {
        $id = $_POST['id'];
        $this->notesModel->supprimer($id);
        header("Location: index.php?action=dashboardNotes");
    }



    /**
     * Dashboard Achat (Achat)
     */
    public function dashboardAchats()
    {
        if (!$this->isUserAdmin()) {
            $this->handleError('Accès refusé. Vous devez être connecté en tant qu\'administrateur.');
            return;
        }

        $this->showDashboardachat();
    }

    private function showDashboardAchat()
    {
        try {
            $achat = $this->achatModel->lire();
            $this->adminView->adminDashboardAchat($achat);
        } catch (Exception $e) {
            $this->handleError($e->getMessage());
        }
    }

    /**
     * Fonctions Edit, update, delete (Achat)
     */
    public function editAchat($id)
    {
        $achat = $this->achatModel->lireUn($id);
        if ($achat) {
            $this->adminView->renderEditAchatForm($achat);
        } else {
            echo "Erreur : La commande n'existe pas.";
        }
    }

    public function updateAchat($id, $data)
    {
        $success = $this->achatModel->mettreAJour($id, $data);

        if ($success) {
            header("Location: index.php?action=dashboardAchat");
            exit();
        } else {
            echo "Erreur lors de la mise à jour de la commande.";
        }
    }

    public function deleteAchat()
    {
        $id = $_POST['id'];
        $this->achatModel->supprimer($id);
        header("Location: index.php?action=dashboardAchat");
    }

    /**
     * Dashboard Boutique (Boutique)
     */
    public function dashboardBoutiques()
    {
        if (!$this->isUserAdmin()) {
            $this->handleError('Accès refusé. Vous devez être connecté en tant qu\'administrateur.');
            return;
        }

        $this->showDashboardBoutique();
    }

    private function showDashboardBoutique()
    {
        try {
            $boutiques = $this->boutiqueModel->lire();
            $this->adminView->adminDashboardBoutiques($boutiques);
        } catch (Exception $e) {
            $this->handleError($e->getMessage());
        }
    }

    /**
     * Fonctions Edit, update, delete (Boutique)
     */
    public function editBoutique($id)
    {
        $boutique = $this->boutiqueModel->lireUn($id);
        if ($boutique) {
            $this->adminView->renderEditBoutiqueForm($boutique);
        } else {
            echo "Erreur : La boutique n'existe pas.";
        }
    }

    public function updateBoutique($id, $data)
    {
        $success = $this->boutiqueModel->mettreAJour($id, $data);

        if ($success) {
            header("Location: index.php?action=dashboardBoutique");
            exit();
        } else {
            echo "Erreur lors de la mise à jour de la boutique.";
        }
    }

    public function deleteBoutique()
    {
        $id = $_POST['id'];
        $this->boutiqueModel->supprimer($id);
        header("Location: index.php?action=dashboardBoutique");
    }

    /**
     * Fonctions Edit (Marketing)
     */
    public function editMarketing($id)
    {
        $marketing = $this->marketingModel->lireUn($id);
        if ($marketing) {
            $this->adminView->renderEditMarketingForm($marketing);
        } else {
            // Gérer l'erreur
            echo "Erreur : Le responsable marketing n'existe pas.";
        }
    }

    /**
     * Fonctions Update (Marketing)
     */
    public function updateMarketing($id, $data)
    {

        if (!isset($data['utilisateur_id'])) {

            $marketing = $this->marketingModel->lireUn($id);
            $data['utilisateur_id'] = $marketing['utilisateur_id'];
        }


        $success = $this->marketingModel->mettreAJour($id, $data);
        if ($success) {
            echo "Responsable Marketing mis à jour avec succès!";
            header("Location: index.php?action=dashboardMarketing");
        } else {
            echo "Erreur lors de la mise à jour du responsable marketing.";
        }
    }


    /**
     * Fonctions Delete (Marketing)
     */
    public function deleteMarketing()
    {
        $id = $_POST['id'];
        $this->marketingModel->id = $id;
        $this->marketingModel->supprimer($id);
        header("Location: index.php?action=adminDashboardMarketing");  // Redirige vers le tableau de bord après la suppression
    }
}