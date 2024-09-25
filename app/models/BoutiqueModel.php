<?php
require_once 'BaseModel.php';

class BoutiqueModel extends BaseModel
{
    public $id;
    public $nom;
    public $description;

    private $table_name = "Boutique";

    public function __construct()
    {
        parent::__construct();
    }

    // Méthode pour lire toutes les boutiques
    public function lire()
    {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->get_result();
    }

    // Méthode pour lire une seule boutique par ID
    public function lireUn($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Méthode pour créer un nouveau boutique
    public function creer($data)
    {
        $query = "INSERT INTO " . $this->table_name . " (nom, description) VALUES (?, ?)";

        $stmt = $this->conn->prepare($query);

        // Nettoyer les données
        $nom = htmlspecialchars(strip_tags($data['nom']));
        $description = htmlspecialchars(strip_tags($data['description']));

        // Lier les valeurs
        $stmt->bind_param("ss", $nom, $description);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Méthode pour mettre à jour un boutique
    public function mettreAJour($id, $data)
    {
        $query = "UPDATE " . $this->table_name . "
                  SET
                    nom = ?,
                    description = ?
                  WHERE
                    id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $this->conn->error);
        }

        // Nettoyer les données
        $nom = htmlspecialchars(strip_tags($data['nom']));
        $description = htmlspecialchars(strip_tags($data['description']));
        $id = htmlspecialchars(strip_tags($id));

        // Lier les nouvelles valeurs
        if (!$stmt->bind_param('ssi', $nom, $description, $id)) {
            die("Erreur lors de la liaison des paramètres : " . $stmt->error);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            die("Erreur lors de l'exécution de la requête : " . $stmt->error);
        }
    }

    // Méthode pour supprimer un boutique
    public function supprimer($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $this->conn->error);
        }

        // Nettoyer l'id
        $id = htmlspecialchars(strip_tags($id));

        // Lier l'id
        if (!$stmt->bind_param('i', $id)) {
            die("Erreur lors de la liaison des paramètres : " . $stmt->error);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            die("Erreur lors de l'exécution de la requête : " . $stmt->error);
        }
    }

    // Méthode pour rechercher un boutique par ID
    public function rechercherParID($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $stmt->bind_param('i', $id);

        $stmt->execute();
        return $stmt->get_result();
    }
}