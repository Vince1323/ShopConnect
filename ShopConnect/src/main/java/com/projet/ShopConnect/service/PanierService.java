package com.projet.ShopConnect.service;

import com.projet.ShopConnect.model.Panier;
import com.projet.ShopConnect.repository.PanierRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class PanierService {

    @Autowired
    private PanierRepository panierRepository;

    // Récupérer tous les paniers
    public List<Panier> getAllPaniers() {
        return panierRepository.findAll();
    }

    // Récupérer un panier par son ID
    public Panier getPanierById(Long id) {
        return panierRepository.findById(id).orElse(null);
    }

    // Enregistrer un panier
    public Panier savePanier(Panier panier) {
        return panierRepository.save(panier);
    }

    // Mettre à jour un panier existant
    public Panier updatePanier(Long id, Panier updatedPanier) {
        return panierRepository.findById(id)
                .map(panier -> {
                    panier.setDateCreation(updatedPanier.getDateCreation());
                    panier.setUtilisateur(updatedPanier.getUtilisateur());
                    return panierRepository.save(panier);
                }).orElse(null);
    }

    // Supprimer un panier par son ID
    public void deletePanier(Long id) {
        panierRepository.deleteById(id);
    }
}
