package com.projet.ShopConnect.controller;

import com.projet.ShopConnect.model.Panier;
import com.projet.ShopConnect.service.PanierService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/paniers")
public class PanierController {

    @Autowired
    private PanierService panierService;

    // Récupérer tous les paniers
    @GetMapping
    public List<Panier> getAllPaniers() {
        return panierService.getAllPaniers();
    }

    // Récupérer un panier par son ID
    @GetMapping("/{id}")
    public ResponseEntity<Panier> getPanierById(@PathVariable Long id) {
        Panier panier = panierService.getPanierById(id);
        if (panier != null) {
            return ResponseEntity.ok(panier);
        } else {
            return ResponseEntity.notFound().build();
        }
    }

    // Créer un nouveau panier
    @PostMapping
    public Panier createPanier(@RequestBody Panier panier) {
        return panierService.savePanier(panier);
    }

    // Mettre à jour un panier existant
    @PutMapping("/{id}")
    public ResponseEntity<Panier> updatePanier(@PathVariable Long id, @RequestBody Panier updatedPanier) {
        Panier panier = panierService.updatePanier(id, updatedPanier);
        if (panier != null) {
            return ResponseEntity.ok(panier);
        } else {
            return ResponseEntity.notFound().build();
        }
    }

    // Supprimer un panier par son ID
    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deletePanier(@PathVariable Long id) {
        panierService.deletePanier(id);
        return ResponseEntity.noContent().build();
    }
}
