package com.projet.ShopConnect.controller;

import com.projet.ShopConnect.model.Paiement;
import com.projet.ShopConnect.service.PaiementService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/paiements")
public class PaiementController {

    @Autowired
    private PaiementService paiementService;

    // Récupérer tous les paiements
    @GetMapping
    public List<Paiement> getAllPaiements() {
        return paiementService.getAllPaiements();
    }

    // Récupérer un paiement par son ID
    @GetMapping("/{id}")
    public ResponseEntity<Paiement> getPaiementById(@PathVariable Long id) {
        Paiement paiement = paiementService.getPaiementById(id);
        if (paiement != null) {
            return ResponseEntity.ok(paiement);
        } else {
            return ResponseEntity.notFound().build();
        }
    }

    // Créer un nouveau paiement
    @PostMapping
    public Paiement createPaiement(@RequestBody Paiement paiement) {
        return paiementService.savePaiement(paiement);
    }

    // Mettre à jour un paiement existant
    @PutMapping("/{id}")
    public ResponseEntity<Paiement> updatePaiement(@PathVariable Long id, @RequestBody Paiement updatedPaiement) {
        Paiement paiement = paiementService.updatePaiement(id, updatedPaiement);
        if (paiement != null) {
            return ResponseEntity.ok(paiement);
        } else {
            return ResponseEntity.notFound().build();
        }
    }

    // Supprimer un paiement par son ID
    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deletePaiement(@PathVariable Long id) {
        paiementService.deletePaiement(id);
        return ResponseEntity.noContent().build();
    }
}
