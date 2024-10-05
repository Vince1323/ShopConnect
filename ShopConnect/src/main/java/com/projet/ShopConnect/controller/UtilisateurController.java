package com.projet.ShopConnect.controller;

import com.projet.ShopConnect.model.Utilisateur;
import com.projet.ShopConnect.service.UtilisateurService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Optional;

// contrôleur Spring REST, qui gère les requêtes HTTP
@RestController

// Chemins d'accès pour ce contrôleur commenceront par "/api/utilisateurs"
@RequestMapping("/api/utilisateurs")
public class UtilisateurController {

    // Injection automatique de la dépendance UtilisateurService
    // Permet de faire appel à ce service sans avoir besoin de l'instancier manuellement
    @Autowired
    private UtilisateurService utilisateurService;

    // Méthode pour récupérer tous les utilisateurs.
    // @GetMapping : est appelée lorsqu'une requête GET est envoyée à "/api/utilisateurs"
    @GetMapping
    public List<Utilisateur> getAllUtilisateurs() {
        // Appelle la méthode du service pour récupérer tous les utilisateurs
        return utilisateurService.getAllUtilisateurs();
    }

    // Méthode pour récupérer un utilisateur en fonction de son ID
    // @GetMapping("/{id}") : est appelée avec une requête GET qui inclut un ID utilisateur "/api/utilisateurs/1"
    @GetMapping("/{id}")
    public ResponseEntity<Utilisateur> getUtilisateurById(@PathVariable Long id) {
        // Appelle la méthode du service pour récupérer un utilisateur avec l'ID fourni
        Optional<Utilisateur> utilisateurOpt = utilisateurService.getUtilisateurById(id);
        // Si l'utilisateur est trouvé, retourne (OK) avec les données de l'utilisateur
        return utilisateurOpt.map(ResponseEntity::ok)
                .orElseGet(() -> ResponseEntity.status(HttpStatus.NOT_FOUND)// Retourne NOT FOUND si utilisateur non trouvé
                        .body(null));
    }

    // Méthode pour créer un nouvel utilisateur.
    // @PostMapping : est appelée avec une requête POST à "/api/utilisateurs", avec les détails de l'utilisateur
    @PostMapping
    public ResponseEntity<Utilisateur> createUtilisateur(@RequestBody Utilisateur utilisateur) {
        try {
            // Sauvegarde le nouvel utilisateur dans la base de données via le service
            Utilisateur newUtilisateur = utilisateurService.saveUtilisateur(utilisateur);
            // retourne OK avec les détails de l'utilisateur nouvellement créé
            return ResponseEntity.status(HttpStatus.CREATED).body(newUtilisateur);
        } catch (Exception e) {
            return ResponseEntity.status(HttpStatus.BAD_REQUEST).build(); // Erreur de création, retourne BAD REQUEST
        }
    }

    // Méthode pour mettre à jour un utilisateur existant
    // @PutMapping("/{id}") : est appelée avec une requête PUT pour un utilisateur spécifique
    // "/api/utilisateurs/1", avec les données mises à jour dans le corps de la requête.
    @PutMapping("/{id}")
    public ResponseEntity<Utilisateur> updateUtilisateur(@PathVariable Long id, @RequestBody Utilisateur updatedUtilisateur) {
        try {
            // Mise à jour de l'utilisateur en base de données via le service.
            Utilisateur utilisateur = utilisateurService.updateUtilisateur(id, updatedUtilisateur);
            // retourne (OK) avec les détails de l'utilisateur mis à jour.
            return ResponseEntity.ok(utilisateur);
        } catch (RuntimeException e) {
            return ResponseEntity.status(HttpStatus.NOT_FOUND).build(); // Retourne NOT FOUND si utilisateur non trouvé
        }
    }

    // Méthode pour supprimer un utilisateur en fonction de son ID.
    // @DeleteMapping("/{id}") : est appelée avec une requête DELETE pour un utilisateur spécifique  "/api/utilisateurs/1".
    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deleteUtilisateur(@PathVariable Long id) {
        try {
            // Suppression de l'utilisateur via le service.
            utilisateurService.deleteUtilisateur(id);
            return ResponseEntity.noContent().build(); // Retourne NO CONTENT si la suppression est réussie.
        } catch (RuntimeException e) {

            return ResponseEntity.status(HttpStatus.NOT_FOUND).build(); // Retourne NOT FOUND si utilisateur non trouvé
        }
    }
}
