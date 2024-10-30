package com.projet.ShopConnect.model;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;

import java.math.BigDecimal;
import java.util.List;

@Getter
@Setter
@Entity
public class Produit extends Identified {

    @Column(nullable = false)
    private String nom;

    @Column(nullable = false)
    private String description;

    private int quantiteStock;
    private String imageUrl;

    @Column(nullable = false)
    private BigDecimal prix;

    private String urlSlug;

    @ManyToOne
    private Categorie categorie;

    @OneToMany(mappedBy = "produit" , fetch = FetchType.LAZY, cascade = CascadeType.ALL, orphanRemoval = true)
    private List<PromotionProduit> promotions;

    @OneToMany(mappedBy = "produit" , fetch = FetchType.LAZY, cascade = CascadeType.ALL, orphanRemoval = true)
    private List<CommandeProduit> commandes;

    @OneToMany(mappedBy = "produit" , fetch = FetchType.LAZY, cascade = CascadeType.ALL, orphanRemoval = true)
    private List<PanierProduit> paniers;

    @OneToMany(mappedBy = "produit")
    private List<Avis> avis;
}