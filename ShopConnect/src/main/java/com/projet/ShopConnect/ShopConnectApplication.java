package com.projet.ShopConnect;

import org.keycloak.adapters.springboot.KeycloakSpringBootConfigResolver;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.Bean;
import org.springframework.web.servlet.i18n.LocaleChangeInterceptor;
import org.springframework.web.servlet.i18n.AcceptHeaderLocaleResolver;
import org.springframework.web.servlet.LocaleResolver;
import org.springframework.web.servlet.config.annotation.InterceptorRegistry;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurer;
import com.stripe.Stripe;

import java.util.Locale;

@SpringBootApplication
public class ShopConnectApplication implements WebMvcConfigurer {

	public static void main(String[] args) {
		// Configuration Stripe API pour les paiements
		Stripe.apiKey = "pk_test_51Q6L4HFkmPyq3F8X7q8PW3StR2JOF9yAsHNbUBsUsVuq76RSVfepf5L58mi2h0j1cIgIhthVKgjssPbDom8yZ8J300FZJedwsM"; // Remplacer par votre clé API Stripe

		// Démarrage de l'application
		SpringApplication.run(ShopConnectApplication.class, args);
	}

	// Configuration de l'internationalisation (choix de la langue)
	@Bean
	public LocaleResolver localeResolver() {
		AcceptHeaderLocaleResolver localeResolver = new AcceptHeaderLocaleResolver();
		localeResolver.setDefaultLocale(Locale.FRENCH); // Par défaut, le site sera en français
		return localeResolver; // Plus besoin de cast, AcceptHeaderLocaleResolver implémente LocaleResolver
	}

	// Intercepteur pour changer la langue via un paramètre dans l'URL (ex : ?lang=en)
	@Bean
	public LocaleChangeInterceptor localeChangeInterceptor() {
		LocaleChangeInterceptor interceptor = new LocaleChangeInterceptor();
		interceptor.setParamName("lang"); // Paramètre URL pour changer la langue (ex. ?lang=en)
		return interceptor;
	}

	@Override
	public void addInterceptors(InterceptorRegistry registry) {
		registry.addInterceptor(localeChangeInterceptor()); // Enregistrement de l'intercepteur pour i18n
	}

	// Configuration "Keycloak" -> pour la gestion des utilisateurs !! DEPENDENCE.
	@Bean
	public KeycloakSpringBootConfigResolver keycloakConfigResolver() {
		return new KeycloakSpringBootConfigResolver();
	}

}
