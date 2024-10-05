package com.projet.ShopConnect.controller;

import com.projet.ShopConnect.model.Commande;
import com.projet.ShopConnect.service.CommandeService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/commandes")
public class CommandeController {

    @Autowired
    private CommandeService commandeService;

    // Récupérer toutes les commandes
    @GetMapping
    public List<Commande> getAllCommandes() {
        return commandeService.getAllCommandes();
    }

    // Récupérer une commande par son ID
    @GetMapping("/{id}")
    public ResponseEntity<Commande> getCommandeById(@PathVariable Long id) {
        Commande commande = commandeService.getCommandeById(id);
        if (commande != null) {
            return ResponseEntity.ok(commande);
        } else {
            return ResponseEntity.notFound().build();
        }
    }

    // Créer une nouvelle commande
    @PostMapping
    public ResponseEntity<Commande> createCommande(@RequestBody Commande commande) {
        Commande createdCommande = commandeService.saveCommande(commande);
        return ResponseEntity.ok(createdCommande);
    }

    // Mettre à jour une commande existante
    @PutMapping("/{id}")
    public ResponseEntity<Commande> updateCommande(@PathVariable Long id, @RequestBody Commande updatedCommande) {
        Commande commande = commandeService.updateCommande(id, updatedCommande);
        if (commande != null) {
            return ResponseEntity.ok(commande);
        } else {
            return ResponseEntity.notFound().build();
        }
    }

    // Supprimer une commande par son ID
    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deleteCommande(@PathVariable Long id) {
        commandeService.deleteCommande(id);
        return ResponseEntity.noContent().build();
    }
}
