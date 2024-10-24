package com.projet.ShopConnect.service;

import com.projet.ShopConnect.model.Utilisateur;
import com.projet.ShopConnect.repository.UtilisateurRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class UtilisateurService {

    @Autowired
    private UtilisateurRepository utilisateurRepository;

    public List<Utilisateur> getAllUtilisateurs() {
        return utilisateurRepository.findAll();
    }

    public Optional<Utilisateur> getUtilisateurById(Long id) {
        return utilisateurRepository.findById(id);
    }

    public Utilisateur saveUtilisateur(Utilisateur utilisateur) {
        Optional<Utilisateur> existingUser = Optional.ofNullable(utilisateurRepository.findByEmail(utilisateur.getEmail()));
        if (existingUser.isPresent()) {
            throw new RuntimeException("Email déjà utilisé");
        }
        return utilisateurRepository.save(utilisateur);
    }

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

    public void deleteUtilisateur(Long id) {
        Utilisateur utilisateur = utilisateurRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Utilisateur non trouvé"));
        utilisateurRepository.delete(utilisateur);
    }
}
