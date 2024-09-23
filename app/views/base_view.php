<?php
class BaseView
{
    public function loadTemplate($templateName, $data = [])
    {
        // Transforme les clés du tableau $data en variables
        extract($data);

        require_once "templates/$templateName.php";
    }

    public function renderHeader()
    {
        include 'templates/header.php';
    }

    public function renderContainer()
    {
        include 'templates/container.php';
    }

    public function renderFooter()
    {
        include 'templates/footer.php';
    }
}