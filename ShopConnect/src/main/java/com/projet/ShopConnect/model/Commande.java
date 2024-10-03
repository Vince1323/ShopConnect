package com.projet.ShopConnect.model;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;

import java.math.BigDecimal;
import java.util.List;

@Getter
@Setter
@Entity
public class Commande extends Identified {

    private String adresseLivraison;
    private String statut;

    @Column(nullable = false)
    private BigDecimal totalMontant;
    private String dateCommande;

    @ManyToOne
    private Utilisateur utilisateur;

    @OneToMany(mappedBy = "commande")
    private List<CommandeProduit> produits;

    @OneToOne(mappedBy = "commande")
    private Paiement paiement;
}