package com.projet.ShopConnect.model;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;

import java.util.List;

@Getter
@Setter
@Entity
public class Panier extends Identified {

    private String dateCreation;

    @ManyToOne
    private Utilisateur utilisateur;

    @OneToMany(mappedBy = "panier" , fetch = FetchType.LAZY, cascade = CascadeType.ALL, orphanRemoval = true)
    private List<PanierProduit> produits;
}