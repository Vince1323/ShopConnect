package com.projet.ShopConnect;

import com.stripe.Stripe;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.Bean;
import org.springframework.web.servlet.LocaleResolver;
import org.springframework.web.servlet.config.annotation.CorsRegistry;
import org.springframework.web.servlet.config.annotation.InterceptorRegistry;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurer;
import org.springframework.web.servlet.i18n.AcceptHeaderLocaleResolver;
import org.springframework.web.servlet.i18n.LocaleChangeInterceptor;
import org.springframework.beans.factory.annotation.Value;

import java.util.Locale;

@SpringBootApplication
public class ShopConnectApplication implements WebMvcConfigurer {

	// Clé Stripe importée depuis application.properties
	@Value("${stripe.apiKey}")
	private static String stripeApiKey;

	public static void main(String[] args) {
		// Initialisation de la clé Stripe pour les transactions
		Stripe.apiKey = stripeApiKey;
		SpringApplication.run(ShopConnectApplication.class, args);
	}

	// Définition du résolveur de langue par défaut
	@Bean
	public LocaleResolver localeResolver() {
		AcceptHeaderLocaleResolver localeResolver = new AcceptHeaderLocaleResolver();
		localeResolver.setDefaultLocale(Locale.FRENCH);
		return localeResolver;
	}

	// Intercepteur pour changer la langue via l'URL (ex : ?lang=en)
	@Bean
	public LocaleChangeInterceptor localeChangeInterceptor() {
		LocaleChangeInterceptor interceptor = new LocaleChangeInterceptor();
		interceptor.setParamName("lang");
		return interceptor;
	}

	@Override
	public void addInterceptors(InterceptorRegistry registry) {
		registry.addInterceptor(localeChangeInterceptor());
	}

	// Configuration CORS pour autoriser les requêtes depuis le frontend Angular
	@Override
	public void addCorsMappings(CorsRegistry registry) {
		registry.addMapping("/**")
				.allowedOrigins("http://localhost:4200")
				.allowedMethods("GET", "POST", "PUT", "DELETE", "OPTIONS")
				.allowedHeaders("*")
				.allowCredentials(true);
	}
}
