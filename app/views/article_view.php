<?php

require_once 'base_view.php';
require_once 'admin_view.php';
require_once 'form_view.php';
require_once 'form_container.php';


class ArticleView {

    public function renderHeader() {
        include 'templates/header.php';
    }

    public function renderFooter() {
        include 'templates/footer.php';
    }

    public function renderArticleList($articles) {
        $this->renderHeader();

        // Création du FormContainer
        $form_container = new FormContainer();

        // Ajout du fil d'Ariane
        $form_container->addBreadcrumb("Accueil", "index.php");
        $form_container->addBreadcrumb("Nos Articles");

        // Ajout du titre principal
        $form_container->addMainTitle("Nos Articles");

        // Check $articles not NULL
        if ($articles !== null) {
        // Ajout de chaque médecin dans le FormContainer
        foreach ($articles as $article) {
          $form_container->addSubTitle("Docteur " . htmlspecialchars($article['nom']));
            $form_container->addDescription("Spécialité : " . htmlspecialchars($article['specialite']));
            $form_container->addDescription("Téléphone : " . htmlspecialchars($article['telephone']));
          }
      } else {
        // Handle case where $articles is NULL
        $form_container->addDescription("Aucun article trouvé.");
    }

        // Rendu du contenu
        echo $form_container->render();
    }
}
