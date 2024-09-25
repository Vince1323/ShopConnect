<?php

require_once 'base_view.php';
require_once 'admin_view.php';
require_once 'form_view.php';
require_once 'form_container.php';

class ContactView extends BaseView
{

    public function renderHeader()
    {
        include 'templates/header.php';
    }

    public function renderFooter()
    {
        include 'templates/footer.php';
    }

    public function renderContact()
    {

        $this->renderHeader(); // chargement du header

        // Création du FormContainer
        $form_container = new FormContainer();

        // Ajout du fil d'Ariane
        $form_container->addBreadcrumb("Accueil", "index.php");
        $form_container->addBreadcrumb("Contact");

        // Ajout du titre principal
        $form_container->addMainTitle("Nous contacter");
        $form_container->addDescription("Email : Medic@example.com ");
        $form_container->addDescription("Téléphone :  +32 04 44 44 44 ");
        $form_container->addDescription("Adresse : Rue Hazinelle 13  Liège, 4000  Belgique ");

        // Rendu du contenu
        echo $form_container->render();
    }
}