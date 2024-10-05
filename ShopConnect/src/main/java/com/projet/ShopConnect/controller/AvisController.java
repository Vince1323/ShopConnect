package com.projet.ShopConnect.controller;

import com.projet.ShopConnect.model.Avis;
import com.projet.ShopConnect.service.AvisService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/avis")
public class AvisController {

    @Autowired
    private AvisService avisService;

    // Récupérer tous les avis
    @GetMapping
    public List<Avis> getAllAvis() {
        return avisService.getAllAvis();
    }

    // Récupérer un avis par son ID
    @GetMapping("/{id}")
    public ResponseEntity<Avis> getAvisById(@PathVariable Long id) {
        Avis avis = avisService.getAvisById(id);
        if (avis != null) {
            return ResponseEntity.ok(avis);
        } else {
            return ResponseEntity.notFound().build();
        }
    }

    // Créer un nouvel avis
    @PostMapping
    public ResponseEntity<Avis> createAvis(@RequestBody Avis avis) {
        Avis createdAvis = avisService.saveAvis(avis);
        return ResponseEntity.ok(createdAvis);
    }

    // Mettre à jour un avis existant
    @PutMapping("/{id}")
    public ResponseEntity<Avis> updateAvis(@PathVariable Long id, @RequestBody Avis updatedAvis) {
        Avis avis = avisService.updateAvis(id, updatedAvis);
        if (avis != null) {
            return ResponseEntity.ok(avis);
        } else {
            return ResponseEntity.notFound().build();
        }
    }

    // Supprimer un avis par son ID
    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deleteAvis(@PathVariable Long id) {
        avisService.deleteAvis(id);
        return ResponseEntity.noContent().build();
    }
}
