package com.projet.ShopConnect.model;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;

import java.util.List;

@Getter
@Setter
@Entity
public class Utilisateur extends Identified {

    @Column(nullable = false, unique = true)
    private String email;

    @Column(nullable = false)
    private String password;

    @Column(nullable = false)
    private String nom;

    @Column(nullable = false)
    private String role;

    private String langage;
    private String authProvider;
    private String dateInscription;

    @OneToMany(mappedBy = "utilisateur")
    private List<Commande> commandes;

    @OneToMany(mappedBy = "utilisateur")
    private List<Promotion> promotions;

    @OneToMany(mappedBy = "utilisateur")
    private List<Boutique> boutiques;

    @OneToMany(mappedBy = "utilisateur")
    private List<Panier> paniers;
}