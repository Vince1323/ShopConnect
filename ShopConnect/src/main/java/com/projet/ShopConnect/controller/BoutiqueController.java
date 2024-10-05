package com.projet.ShopConnect.controller;

import com.projet.ShopConnect.model.Boutique;
import com.projet.ShopConnect.service.BoutiqueService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/boutiques")
public class BoutiqueController {

    @Autowired
    private BoutiqueService boutiqueService;

    // Récupérer toutes les boutiques
    @GetMapping
    public List<Boutique> getAllBoutiques() {
        return boutiqueService.getAllBoutiques();
    }

    // Récupérer une boutique par son ID
    @GetMapping("/{id}")
    public ResponseEntity<Boutique> getBoutiqueById(@PathVariable Long id) {
        Boutique boutique = boutiqueService.getBoutiqueById(id);
        if (boutique != null) {
            return ResponseEntity.ok(boutique);
        } else {
            return ResponseEntity.notFound().build();
        }
    }

    // Créer une nouvelle boutique
    @PostMapping
    public ResponseEntity<Boutique> createBoutique(@RequestBody Boutique boutique) {
        Boutique createdBoutique = boutiqueService.saveBoutique(boutique);
        return ResponseEntity.ok(createdBoutique);
    }

    // Mettre à jour une boutique existante
    @PutMapping("/{id}")
    public ResponseEntity<Boutique> updateBoutique(@PathVariable Long id, @RequestBody Boutique updatedBoutique) {
        Boutique boutique = boutiqueService.updateBoutique(id, updatedBoutique);
        if (boutique != null) {
            return ResponseEntity.ok(boutique);
        } else {
            return ResponseEntity.notFound().build();
        }
    }

    // Supprimer une boutique par son ID
    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deleteBoutique(@PathVariable Long id) {
        boutiqueService.deleteBoutique(id);
        return ResponseEntity.noContent().build();
    }
}
