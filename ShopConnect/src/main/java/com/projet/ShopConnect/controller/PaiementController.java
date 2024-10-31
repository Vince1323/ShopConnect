package com.projet.ShopConnect.controller;

import com.projet.ShopConnect.model.Paiement;
import com.projet.ShopConnect.service.PaiementService;
import com.stripe.exception.StripeException;
import com.stripe.model.PaymentIntent;
import com.stripe.param.PaymentIntentCreateParams;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.math.BigDecimal;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

@RestController
@RequestMapping("/api/paiements")
public class PaiementController {

    @Autowired
    private PaiementService paiementService;

    @Value("${stripe.apiKey}")
    private String stripeApiKey;

    // Récupérer tous les paiements
    @GetMapping
    public List<Paiement> getAllPaiements() {
        return paiementService.getAllPaiements();
    }

    // Récupérer un paiement par son ID
    @GetMapping("/{id}")
    public ResponseEntity<Paiement> getPaiementById(@PathVariable Long id) {
        Paiement paiement = paiementService.getPaiementById(id);
        return paiement != null ? ResponseEntity.ok(paiement) : ResponseEntity.status(HttpStatus.NOT_FOUND).build();
    }

    // Créer un paiement Stripe
    @PostMapping("/create-payment-intent")
    public ResponseEntity<?> createPaymentIntent(@RequestParam BigDecimal montant) {
        PaymentIntentCreateParams params = PaymentIntentCreateParams.builder()
                .setAmount(montant.multiply(new BigDecimal(100)).longValue()) // Convertir en centimes
                .setCurrency("eur")
                .build();

        try {
            PaymentIntent intent = PaymentIntent.create(params);
            Map<String, String> responseData = new HashMap<>();
            responseData.put("clientSecret", intent.getClientSecret());
            return ResponseEntity.ok(responseData);
        } catch (StripeException e) {
            return ResponseEntity.badRequest().body("Erreur lors de la création du paiement Stripe");
        }
    }

    // Créer un nouveau paiement dans la base de données
    @PostMapping
    public ResponseEntity<Paiement> createPaiement(@RequestBody Paiement paiement) {
        try {
            Paiement newPaiement = paiementService.savePaiement(paiement);
            return ResponseEntity.status(HttpStatus.CREATED).body(newPaiement);
        } catch (Exception e) {
            return ResponseEntity.status(HttpStatus.BAD_REQUEST).build();
        }
    }

    // Mettre à jour un paiement existant
    @PutMapping("/{id}")
    public ResponseEntity<Paiement> updatePaiement(@PathVariable Long id, @RequestBody Paiement updatedPaiement) {
        try {
            Paiement paiement = paiementService.updatePaiement(id, updatedPaiement);
            return ResponseEntity.ok(paiement);
        } catch (RuntimeException e) {
            return ResponseEntity.status(HttpStatus.NOT_FOUND).build();
        }
    }

    // Supprimer un paiement
    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deletePaiement(@PathVariable Long id) {
        try {
            paiementService.deletePaiement(id);
            return ResponseEntity.noContent().build();
        } catch (RuntimeException e) {
            return ResponseEntity.status(HttpStatus.NOT_FOUND).build();
        }
    }
}
