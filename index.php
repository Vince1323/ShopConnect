<?php
session_start();
/*
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
*/

// Inclure les fichiers nécessaires
require_once 'app/controllers/UserController.php';
require_once 'app/controllers/AdminController.php';
require_once 'app/controllers/ArticleController.php';
require_once 'app/controllers/MarketingController.php';

// Créer les instances des contrôleurs nécessaires
$userController = new UserController();
$adminController = new AdminController();
$articleController = new ArticleController();
$marketingController = new MarketingController();


// Déterminer l'action à effectuer (utiliser une valeur par défaut si aucune action spécifiée)
$action = isset($_GET['action']) ? $_GET['action'] : 'default';

// Traitement en fonction de l'action spécifiée
switch ($action) {
    case 'showProfile':
        $userId = $_GET['id'];
        if (!$userController->isValidUserId($userId)) {
            $userController->redirect('errorPage.php?message=ID utilisateur invalide.');
        }
        $userController->showProfile($userId);
        break;

   // All Dashboard Admin
   case 'adminDashboard':
       $adminController->dashboard();
       break;

   case 'dashboardUser':
       $adminController->dashboardUser();
       break;

   case 'dashboardArticle':
       $adminController->dashboardArticle();
       break;

   case 'dashboardClient':
       $adminController->dashboardClient();
       break;

  
   case 'dashboardFactures':
       $adminController->dashboardFactures();
       break;

   case 'dashboardHistorique':
       $adminController->dashboardHistorique();
       break;

   case 'dashboardHoraires':
       $adminController->dashboardHoraires();
       break;

   case 'dashboardArticleBoutique':
       $adminController->dashboardArticleBoutique();
       break;

   case 'dashboardNotes':
       $adminController->dashboardNotes();
       break;

   case 'dashboardAchats':
       $adminController->dashboardAchats();
       break;

   case 'dashboardBoutiques':
       $adminController->dashboardBoutiques();
       break;

    case 'dashboardMarketing':
        $adminController->dashboardMarketing();
        break;
        

       /**
        * Méthodes Article
        */

       case 'homeArticle':
           $articleController->homeArticle();
           break;
       case 'listArticles':
           $articleController->listArticles();
           break;
       case 'viewArticle':
           $id = $_GET['id'];
           $articleController->viewArticle($id);
           break;

    /**
     * Login et Register et leur formulaire
     */
    case 'showLoginForm':
        $userController->showLoginForm();
        break;
    case 'showRegistrationForm':
        $userController->home();
        $userController->showRegistrationForm();
        break;
    case 'login':
        $userController->login($_POST);
        break;
    case 'register':
        $userController->home();
        $userController->register($_POST);
        break;

      /**
       * Edit, Update, Delete User
       */

    case 'editUser':
      $adminController->editUser($_GET['id']);
      break;
    case 'updateUser':
      $adminController->updateUser($_GET['id'], $_POST);
      break;
    case 'deleteUser':
       $adminController->deleteUser($_POST['id']);
       break;
     /**
      * Edit, Update, Delete Article
      */
      case 'editArticle':
          $adminController->editArticle($_GET['id']);
          break;
      case 'updateArticle':
          $adminController->updateArticle($_GET['id'], $_POST);
          break;
      case 'deleteArticle':
          $adminController->deleteArticle($_POST['id']);
          break;
     /**
      * Edit, Update, Delete Client
      */
     case 'editClient':
       $adminController->editClient($_GET['id']);
       break;
    case 'updateClient':
       $adminController->updateClient($_GET['id'], $_POST);
       break;
    case 'deleteClient':
       $adminController->deleteClient($_GET['id']);
       break;

 
  /**
  * Edit, Update, Delete Marketing
  */
  case 'editMarketing':
      $adminController->editMarketing($_GET['id']);
      break;
  case 'updateMarketing':
      $adminController->updateMarketing($_GET['id'], $_POST);
      break;
  case 'deleteMarketing':
      $adminController->deleteMarketing($_POST['id']);
      break;

      
      /**
       * Edit, Update, Delete Factures
       */

    case 'editFactures':
      $adminController->editFactures($_GET['id']);
      break;
    case 'updateFactures':
      $adminController->updateFactures($_GET['id'], $_POST);
      break;
    case 'deleteFactures':
       $adminController->deleteFactures($_POST['id']);
       break;

      /**
       * Edit, Update, Delete Historique
       */

    case 'editHistorique':
      $adminController->editHistorique($_GET['id']);
      break;
    case 'updateHistorique':
      $adminController->updateHistorique($_GET['id'], $_POST);
      break;
    case 'deleteHistorique':
       $adminController->deleteHistorique($_POST['id']);
       break;

      /**
       * Edit, Update, Delete Horaires
       */

    case 'editHoraires':
      $adminController->editHoraires($_GET['id']);
      break;
    case 'updateHoraires':
      $adminController->updateHoraires($_GET['id'], $_POST);
      break;
    case 'deleteHoraires':
       $adminController->deleteHoraires($_POST['id']);
       break;

      /**
       * Edit, Update, Delete ArticleBoutique
       */

       case 'editArticleBoutique':
           $adminController->editArticleBoutique($_GET['article_id'], $_GET['boutique_id']);
           break;
       case 'updateArticleBoutique':
           $adminController->updateArticleBoutique($_GET['article_id'], $_GET['boutique_id'], $_POST);
           break;
       case 'deleteArticleBoutique':
           $adminController->deleteArticleBoutique();
           break;

      /**
       * Edit, Update, Delete Notes
       */

    case 'editNotes':
      $adminController->editNotes($_GET['id']);
      break;
    case 'updateNotes':
      $adminController->updateNotes($_GET['id'], $_POST);
      break;
    case 'deleteNotes':
       $adminController->deleteNotes($_POST['id']);
       break;

      /**
       * Edit, Update, Delete Achat
       */

    case 'editAchat':
      $adminController->editAchat($_GET['id']);
      break;
    case 'updateAchat':
      $adminController->updateAchat($_GET['id'], $_POST);
      break;
    case 'deleteAchat':
       $adminController->deleteAchat($_POST['id']);
       break;

      /**
       * Edit, Update, Delete Boutiques
       */

    case 'editBoutiques':
      $adminController->editBoutiques($_GET['id']);
      break;
    case 'updateBoutiques':
      $adminController->updateBoutiques($_GET['id'], $_POST);
      break;
    case 'deleteBoutiques':
       $adminController->deleteBoutiques($_POST['id']);
       break;

  case 'logout':
       $userController->logout();
       break;

  case 'homeArticle':
  $articleController->homeArticle();
  break;

  // Afficher le contact
  case 'contact':
    $userController->contact();
    break;

  default:
       $userController->home();
       break;
}


include 'app/views/templates/footer.php';
