package com.projet.ShopConnect.service;

import com.projet.ShopConnect.model.Utilisateur;
import com.projet.ShopConnect.repository.UtilisateurRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;

import java.util.Optional;

@Service
public class UtilisateurService {

    @Autowired
    private UtilisateurRepository utilisateurRepository;

    // Récupérer tous les utilisateurs avec pagination
    public Page<Utilisateur> getAllUtilisateurs(Pageable pageable) {
        return utilisateurRepository.findAll(pageable);
    }

    // Récupérer un utilisateur par ID
    public Optional<Utilisateur> getUtilisateurById(Long id) {
        return utilisateurRepository.findById(id);
    }

    // Sauvegarder un nouvel utilisateur
    public Utilisateur saveUtilisateur(Utilisateur utilisateur) {
        return utilisateurRepository.save(utilisateur);
    }

    // Mettre à jour un utilisateur existant
    public Utilisateur updateUtilisateur(Long id, Utilisateur updatedUtilisateur) {
        return utilisateurRepository.findById(id)
                .map(utilisateur -> {
                    utilisateur.setNom(updatedUtilisateur.getNom());
                    utilisateur.setEmail(updatedUtilisateur.getEmail());
                    utilisateur.setPassword(updatedUtilisateur.getPassword());
                    utilisateur.setRole(updatedUtilisateur.getRole());
                    utilisateur.setLangage(updatedUtilisateur.getLangage());
                    return utilisateurRepository.save(utilisateur);
                }).orElseThrow(() -> new RuntimeException("Utilisateur non trouvé"));
    }

    // Supprimer un utilisateur par son ID
    public void deleteUtilisateur(Long id) {
        Utilisateur utilisateur = utilisateurRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Utilisateur non trouvé"));
        utilisateurRepository.delete(utilisateur);
    }
}
