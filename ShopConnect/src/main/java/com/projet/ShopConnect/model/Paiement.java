package com.projet.ShopConnect.model;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;

import java.math.BigDecimal;

@Getter
@Setter
@Entity
public class Paiement extends Identified {

    @Column(nullable = false)
    private BigDecimal montant;

    @Column(nullable = false)
    private String methodePaiement;

    private String statutPaiement;
    private String datePaiement;
    private String transactionId;

    @OneToOne
    private Commande commande;
}