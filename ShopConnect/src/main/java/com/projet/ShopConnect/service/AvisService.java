package com.projet.ShopConnect.service;

import com.projet.ShopConnect.model.Avis;
import com.projet.ShopConnect.repository.AvisRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class AvisService {

    @Autowired
    private AvisRepository avisRepository;

    // Récupérer tous les avis
    public List<Avis> getAllAvis() {
        return avisRepository.findAll();
    }

    // Récupérer un avis par son ID
    public Avis getAvisById(Long id) {
        return avisRepository.findById(id).orElse(null);
    }

    // Enregistrer ou mettre à jour un avis
    public Avis saveAvis(Avis avis) {
        return avisRepository.save(avis);
    }

    // Supprimer un avis par son ID
    public void deleteAvis(Long id) {
        avisRepository.deleteById(id);
    }

    // Mettre à jour un avis existant
    public Avis updateAvis(Long id, Avis updatedAvis) {
        return avisRepository.findById(id)
                .map(avis -> {
                    avis.setNote(updatedAvis.getNote());
                    avis.setCommentaire(updatedAvis.getCommentaire());
                    return avisRepository.save(avis);
                })
                .orElseThrow(() -> new RuntimeException("Avis non trouvé"));
    }
}
