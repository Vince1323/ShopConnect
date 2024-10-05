package com.projet.ShopConnect.repository;

import com.projet.ShopConnect.model.Boutique;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface BoutiqueRepository extends JpaRepository<Boutique, Long> {
}