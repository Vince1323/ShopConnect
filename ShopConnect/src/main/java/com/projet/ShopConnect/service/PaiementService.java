package com.projet.ShopConnect.service;

import com.projet.ShopConnect.model.Paiement;
import com.projet.ShopConnect.repository.PaiementRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class PaiementService {

    @Autowired
    private PaiementRepository paiementRepository;

    // Récupérer tous les paiements
    public List<Paiement> getAllPaiements() {
        return paiementRepository.findAll();
    }

    // Récupérer un paiement par son ID
    public Paiement getPaiementById(Long id) {
        return paiementRepository.findById(id).orElse(null);
    }

    // Enregistrer un paiement
    public Paiement savePaiement(Paiement paiement) {
        return paiementRepository.save(paiement);
    }

    // Mettre à jour un paiement existant
    public Paiement updatePaiement(Long id, Paiement updatedPaiement) {
        return paiementRepository.findById(id)
                .map(paiement -> {
                    paiement.setMontant(updatedPaiement.getMontant());
                    paiement.setMethodePaiement(updatedPaiement.getMethodePaiement());
                    paiement.setStatutPaiement(updatedPaiement.getStatutPaiement());
                    paiement.setDatePaiement(updatedPaiement.getDatePaiement());
                    paiement.setTransactionId(updatedPaiement.getTransactionId());
                    return paiementRepository.save(paiement);
                }).orElse(null);
    }

    // Supprimer un paiement par son ID
    public void deletePaiement(Long id) {
        paiementRepository.deleteById(id);
    }
}
