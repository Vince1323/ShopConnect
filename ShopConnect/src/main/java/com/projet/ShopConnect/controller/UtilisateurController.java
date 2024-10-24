package com.projet.ShopConnect.controller;

import com.projet.ShopConnect.model.Utilisateur;
import com.projet.ShopConnect.service.UtilisateurService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Optional;

@RestController
@RequestMapping("/utilisateurs")
@CrossOrigin(origins = "http://localhost:4200")
public class UtilisateurController {

    @Autowired
    private UtilisateurService utilisateurService;

    @GetMapping
    public List<Utilisateur> getAllUtilisateurs() {
        return utilisateurService.getAllUtilisateurs();
    }

    @GetMapping("/{id}")
    public ResponseEntity<Utilisateur> getUtilisateurById(@PathVariable Long id) {
        Optional<Utilisateur> utilisateurOpt = utilisateurService.getUtilisateurById(id);
        return utilisateurOpt.map(ResponseEntity::ok)
                .orElseGet(() -> ResponseEntity.status(HttpStatus.NOT_FOUND).body(null));
    }

    @PostMapping
    public ResponseEntity<Utilisateur> createUtilisateur(@RequestBody Utilisateur utilisateur) {
        try {
            Utilisateur newUtilisateur = utilisateurService.saveUtilisateur(utilisateur);
            return ResponseEntity.status(HttpStatus.CREATED).body(newUtilisateur);
        } catch (Exception e) {
            return ResponseEntity.status(HttpStatus.BAD_REQUEST).build();
        }
    }

    @PutMapping("/{id}")
    public ResponseEntity<Utilisateur> updateUtilisateur(@PathVariable Long id, @RequestBody Utilisateur updatedUtilisateur) {
        try {
            Utilisateur utilisateur = utilisateurService.updateUtilisateur(id, updatedUtilisateur);
            return ResponseEntity.ok(utilisateur);
        } catch (RuntimeException e) {
            return ResponseEntity.status(HttpStatus.NOT_FOUND).build();
        }
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deleteUtilisateur(@PathVariable Long id) {
        try {
            utilisateurService.deleteUtilisateur(id);
            return ResponseEntity.noContent().build();
        } catch (RuntimeException e) {
            return ResponseEntity.status(HttpStatus.NOT_FOUND).build();
        }
    }
}
