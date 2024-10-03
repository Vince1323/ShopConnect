package com.projet.ShopConnect.model;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;

import java.util.List;

@Getter
@Setter
@Entity
public class Categorie extends Identified {

    private String nom;
    private String description;

    @OneToMany(mappedBy = "categorie")
    private List<Produit> produits;
}