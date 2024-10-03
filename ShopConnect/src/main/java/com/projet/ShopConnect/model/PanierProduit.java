package com.projet.ShopConnect.model;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;

@Getter
@Setter
@Entity
public class PanierProduit extends Identified {

    private Integer quantite;

    @ManyToOne
    private Panier panier;

    @ManyToOne
    private Produit produit;
}