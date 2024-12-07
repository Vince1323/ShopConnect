import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AuthService } from '../../../service/auth.service';
import { Router } from '@angular/router';
import { MessageService } from 'primeng/api';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss'],
})
export class RegisterComponent implements OnInit {
  registrationForm: FormGroup;

  constructor(
    private fb: FormBuilder,
    private authService: AuthService,
    private router: Router,
    private messageService: MessageService
  ) {}

  ngOnInit(): void {
    this.registrationForm = this.fb.group({
      firstname: ['', Validators.required],
      lastname: ['', Validators.required],
      birthDate: ['', Validators.required],
      phone: ['', Validators.pattern(/^\+?[0-9]{7,15}$/)],
      address: this.fb.group({
        street: ['', Validators.required],
        city: ['', Validators.required],
        zipCode: ['', Validators.required],
        country: ['', Validators.required],
      }),
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required, Validators.minLength(6)]],
      hasReadTermsAndConditions: [false, Validators.requiredTrue],
    });
  }

  register(): void {
    if (this.registrationForm.valid) {
      this.authService.register(this.registrationForm.value).subscribe({
        next: () => {
          this.messageService.add({
            severity: 'success',
            summary: 'Succès',
            detail: 'Inscription réussie',
          });
          this.router.navigate(['/auth/login']);
        },
        error: (err) => {
          this.messageService.add({
            severity: 'error',
            summary: 'Erreur',
            detail: 'Échec de l’inscription',
          });
          console.error(err);
        },
      });
    }
  }
}
