package com.projet.ShopConnect.service;

import com.projet.ShopConnect.model.Commande;
import com.projet.ShopConnect.repository.CommandeRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class CommandeService {

    @Autowired
    private CommandeRepository commandeRepository;

    // Récupérer toutes les commandes
    public List<Commande> getAllCommandes() {
        return commandeRepository.findAll();
    }

    // Récupérer une commande par son ID
    public Commande getCommandeById(Long id) {
        return commandeRepository.findById(id).orElse(null);
    }

    // Enregistrer ou mettre à jour une commande
    public Commande saveCommande(Commande commande) {
        return commandeRepository.save(commande);
    }

    // Supprimer une commande par son ID
    public void deleteCommande(Long id) {
        commandeRepository.deleteById(id);
    }

    // Mettre à jour une commande existante
    public Commande updateCommande(Long id, Commande updatedCommande) {
        return commandeRepository.findById(id)
                .map(commande -> {
                    commande.setAdresseLivraison(updatedCommande.getAdresseLivraison());
                    commande.setStatut(updatedCommande.getStatut());
                    commande.setTotalMontant(updatedCommande.getTotalMontant());
                    return commandeRepository.save(commande);
                }).orElseThrow(() -> new RuntimeException("Commande non trouvée"));
    }
}
