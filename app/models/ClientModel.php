<?php
require_once 'BaseModel.php';

class ClientModel extends BaseModel
{
    public $id;
    public $nom;
    public $prenom;
    public $date_de_naissance;
    public $email;
    public $telephone;
    public $adresse;
    public $historique_medical;

    private $table_name = "Client";

    public function __construct()
    {
        parent::__construct();
    }

    // Méthode pour lire tous les médecins
    public function lire()
    {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->get_result();
    }

    // Méthode pour lire un seul médecin par ID
    public function lireUn($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id); // Utiliser bind_param au lieu de bindParam
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Ajouter un client
    public function creer($data)
    {
        $query = "INSERT INTO " . $this->table_name . "
                  (nom, prenom, date_de_naissance, email, telephone, adresse, historique_medical)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $this->conn->error);
        }

        // Nettoyer et lier les paramètres
        $nom = htmlspecialchars(strip_tags($data['nom']));
        $prenom = htmlspecialchars(strip_tags($data['prenom']));
        $date_de_naissance = htmlspecialchars(strip_tags($data['date_de_naissance']));
        $email = htmlspecialchars(strip_tags($data['email']));
        $telephone = htmlspecialchars(strip_tags($data['telephone']));
        $adresse = htmlspecialchars(strip_tags($data['adresse']));
        $historique_medical = htmlspecialchars(strip_tags($data['historique_medical']));

        if (!$stmt->bind_param('sssssss', $nom, $prenom, $date_de_naissance, $email, $telephone, $adresse, $historique_medical)) {
            die("Erreur lors de la liaison des paramètres : " . $stmt->error);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            die("Erreur lors de l'exécution de la requête : " . $stmt->error);
        }

        return false;
    }

    // Mettre à jour un client
    public function mettreAJour($id, $data)
    {
        $query = "UPDATE " . $this->table_name . "
                  SET
                    nom = ?,
                    prenom = ?,
                    date_de_naissance = ?,
                    email = ?,
                    telephone = ?,
                    adresse = ?,
                    historique_medical = ?
                  WHERE
                   id = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $this->conn->error);
        }

        // Nettoyer et lier les paramètres, y compris l'ID
        $id = htmlspecialchars(strip_tags($id));
        $nom = htmlspecialchars(strip_tags($data['nom']));
        $prenom = htmlspecialchars(strip_tags($data['prenom']));
        $date_de_naissance = htmlspecialchars(strip_tags($data['date_de_naissance']));
        $email = htmlspecialchars(strip_tags($data['email']));
        $telephone = htmlspecialchars(strip_tags($data['telephone']));
        $adresse = htmlspecialchars(strip_tags($data['adresse']));
        $historique_medical = htmlspecialchars(strip_tags($data['historique_medical']));

        if (!$stmt->bind_param('sssssssi', $nom, $prenom, $date_de_naissance, $email, $telephone, $adresse, $historique_medical, $id)) {
            die("Erreur lors de la liaison des paramètres : " . $stmt->error);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            die("Erreur lors de l'exécution de la requête : " . $stmt->error);
        }

        return false;
    }

    // Supprimer un client
    public function supprimer()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Nettoyer l'id
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Lier l'id
        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}