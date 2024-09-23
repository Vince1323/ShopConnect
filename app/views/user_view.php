<?php

require_once 'base_view.php';
require_once 'form_container.php';


class UserView extends BaseView
{

    /**
     * Affichage de la page d'acceuil
     */

    public function renderHome()
    {
        $this->renderHeader();

        // Création du FormContainer
        $form_container = new FormContainer();

        // Ajout du fil d'Ariane
        $form_container->addBreadcrumb("Accueil", "index.php");
        $form_container->addBreadcrumb("Page Intérieure");

        // Ajout du titre principal
        $form_container->addMainTitle("Accueil");

        // Section de contenu principale
        $form_container->addDescription("Exemple de modèle de page intérieure");

        // Section Calendrier
        $form_container->addElement("Calendrier", '<div id="calendar"></div>');

        // Rendu du contenu
        echo $form_container->render();
    }


    /**
     * Affiche le formulaire de connexion.
     */
    public function displayLoginForm()
    {
        $this->renderHeader();
        $form_container = new FormContainer();

        // Ajout du fil d'Ariane
        $form_container->addBreadcrumb("Accueil", "index.php");
        $form_container->addBreadcrumb("Connexion");

        // Ajout du titre principal
        $form_container->addMainTitle("Connexion");

        // Création du formulaire de connexion
        $form_container->addDescription("Veuillez vous connecter en utilisant le formulaire ci-dessous.");

        $formHtml = $this->buildLoginForm();
        $form_container->addElement("Formulaire de Connexion", $formHtml);

        echo $form_container->render();
        $this->renderFooter();
    }

    private function buildLoginForm()
    {
        $form = new FormView("index.php?action=login");
        $form->addField('email', 'email', 'email', 'Email:');
        $form->addField('password', 'password', 'password', 'Mot de passe:');
        $form->addButton('submit', 'Se connecter');
        return $form->build();
    }


    public function displayRegistrationForm()
    {
        $this->renderHeader();
        $form_container = new FormContainer();

        $form_container->addBreadcrumb("Accueil", "index.php");
        $form_container->addBreadcrumb("Inscription");

        $form_container->addMainTitle("Inscription");

        $form_container->addDescription("Veuillez vous inscrire en utilisant le formulaire ci-dessous.");

        $formHtml = $this->buildRegistrationForm();
        $form_container->addElement("Formulaire d'Inscription", $formHtml);

        echo $form_container->render();
        $this->renderFooter();
    }

    private function buildRegistrationForm()
    {
        $form = new FormView("index.php?action=register", 'S\'inscrire');
        $form->addField('nom', 'nom', 'text', 'Nom d\'utilisateur:')
            ->addField('email', 'email', 'email', 'Email:')
            ->addField('password', 'password', 'password', 'Mot de passe:')
            ->addButton('submit', 'S\'inscrire');
        return $form->build();
    }

    public function displayProfile($user)
    {
        $this->renderHeader();

        $form_container = new FormContainer();

        // Ajout du fil d'Ariane
        $form_container->addBreadcrumb("Accueil", "index.php");
        $form_container->addBreadcrumb("Profil utilisateur");

        // Ajout du titre principal
        $form_container->addMainTitle("Profil de l'utilisateur");

        // Affichage des informations de l'utilisateur
        $form_container->addDescription("Voici les informations du profil utilisateur :");

        $profileHtml = "<ul>";
        $profileHtml .= "<li>ID : " . htmlspecialchars($user['id']) . "</li>";
        $profileHtml .= "<li>Nom : " . htmlspecialchars($user['nom']) . "</li>";
        $profileHtml .= "<li>Email : " . htmlspecialchars($user['email']) . "</li>";
        $profileHtml .= "<li>Rôle : " . htmlspecialchars($user['role']) . "</li>";
        $profileHtml .= "</ul>";

        // Ajoute le HTML du profil à la page
        $form_container->addElement("Informations du Profil", $profileHtml);

        echo $form_container->render();
        $this->renderFooter();
    }

    /**
     * Affiche le lien de déconnexion.
     */
    public function displayLogoutLink()
    {
        echo '<a href="index.php?action=logout">Déconnexion</a>';
    }
}
