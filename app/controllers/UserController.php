
<?php
require_once 'app/models/UserModel.php';
require_once 'app/views/user_view.php';
require_once 'BaseController.php';
require_once 'app/views/article_view.php';
require_once 'app/views/contact_view.php';

class UserController extends BaseController
{
    private $userModel;
    private $userView;
    private $articleView;
    private $contactView;


    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->userView = new UserView();
        $this->articleView = new ArticleView();
        $this->contactView = new ContactView();
    }

    public function isValidUserId($userId)
    {
        $user = $this->userModel->getUserById($userId);
        return $user !== null;
    }

    public function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    public function showProfile($userId)
    {
        $user = $this->userModel->getUserById($userId);

        if ($user) {
            $this->userView->displayProfile($user);
        } else {
            $this->redirect("errorPage.php?message=Utilisateur non trouvé.");
        }
    }

    public function contact()
    {
        $this->contactView->renderContact();
    }

    public function home()
    {
        $this->userView->renderHome();
    }

    public function showLoginForm()
    {
        $this->userView->displayLoginForm();
    }

    public function showRegistrationForm()
    {
        $this->userView->displayRegistrationForm();
    }

    public function login($postData)
    {
        $email = $postData['email'] ?? null;
        $password = $postData['password'] ?? null;

        if (!$email || !$password) {
            $this->showLoginForm("Email ou mot de passe manquant");
            return;
        }

        $user = $this->userModel->authenticateUser($email, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if ($_SESSION['role'] === 'Admin') {
                $this->redirect("index.php?action=adminDashboard");
                return;
            }

            $this->redirect("index.php");
        } else {
            $this->showLoginForm("Email ou mot de passe incorrect");
        }
    }

    public function register($postData)
    {
        $username = $postData['nom'] ?? null;
        $password = $postData['password'] ?? null;
        $email = $postData['email'] ?? null;

        if (!$username || !$password || !$email) {
            $this->showRegistrationForm("Veuillez remplir tous les champs requis");
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = "Visiteur";
        $result = $this->userModel->registerUser($username, $hashedPassword, $email, $role);

        if ($result) {
            $this->redirect("index.php");
        } else {
            echo "Erreur lors de l'enregistrement.";
        }
    }

    public function logout()
    {
        // Démarre la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Supprime toutes les variables de session
        $_SESSION = array();

        // Détruit complètement la session
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_destroy();

        // Redirige l'utilisateur vers la page d'accueil
        $this->redirect("index.php");
    }
}


