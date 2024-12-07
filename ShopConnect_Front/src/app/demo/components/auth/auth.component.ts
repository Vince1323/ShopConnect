import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AuthService } from '../../service/auth.service';
import { Router } from '@angular/router';
import { MessageService } from 'primeng/api';

@Component({
  selector: 'app-auth',
  templateUrl: './auth.component.html',
  styleUrls: ['./auth.component.scss'],
})
export class AuthComponent implements OnInit {
  isLogin = true; // Basculer entre connexion et inscription
  loginForm: FormGroup;
  registrationForm: FormGroup;

  constructor(
    private fb: FormBuilder,
    private authService: AuthService,
    private router: Router,
    private messageService: MessageService
  ) {}

  ngOnInit(): void {
    this.initForms();
  }

  initForms(): void {
    // Formulaire de connexion
    this.loginForm = this.fb.group({
      username: ['', Validators.required],
      password: ['', Validators.required],
      rememberMe: [false],
    });

    // Formulaire d'inscription
    this.registrationForm = this.fb.group({
      username: ['', Validators.required],
      password: ['', [Validators.required, Validators.minLength(6)]],
      confirmPassword: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
    });
  }

  login(): void {
    if (this.loginForm.valid) {
      this.authService.login(this.loginForm.value).subscribe({
        next: () => {
          this.messageService.add({
            severity: 'success',
            summary: 'Connexion réussie',
            detail: 'Vous êtes connecté.',
          });
          this.router.navigate(['/']); // Redirection après connexion
        },
        error: () => {
          this.messageService.add({
            severity: 'error',
            summary: 'Erreur de connexion',
            detail: 'Vérifiez vos identifiants.',
          });
        },
      });
    }
  }

  register(): void {
    if (this.registrationForm.valid) {
      const { username, password, confirmPassword, email } = this.registrationForm.value;

      if (password !== confirmPassword) {
        this.messageService.add({
          severity: 'error',
          summary: 'Erreur d\'inscription',
          detail: 'Les mots de passe ne correspondent pas.',
        });
        return;
      }

      this.authService.register({ password, email }).subscribe({
        next: () => {
          this.messageService.add({
            severity: 'success',
            summary: 'Inscription réussie',
            detail: 'Compte créé avec succès.',
          });
          this.isLogin = true; // Retour au formulaire de connexion
        },
        error: () => {
          this.messageService.add({
            severity: 'error',
            summary: 'Erreur d\'inscription',
            detail: 'Impossible de créer le compte.',
          });
        },
      });
    }
  }
}
