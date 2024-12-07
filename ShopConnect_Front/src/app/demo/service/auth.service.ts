import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError, tap } from 'rxjs/operators';
import { Auth } from '../model/Auth';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private readonly API_URL = 'http://localhost:9292/api';
  private readonly LOGIN_ENDPOINT = '/auth/login';
  private readonly REGISTER_ENDPOINT = '/auth/register';
  private readonly LOGOUT_ENDPOINT = '/auth/logout';
  private readonly TOKEN_KEY = 'auth-token'; // Clé pour stocker le JWT dans le localStorage

  constructor(private httpClient: HttpClient) {}

  // Connexion
  login(credentials: Auth): Observable<any> {
    return this.httpClient.post(`${this.API_URL}${this.LOGIN_ENDPOINT}`, credentials)
      .pipe(
        catchError(this.handleError),
        // Ajouter une étape pour stocker le token si la réponse est correcte
        tap((response: any) => {
          if (response && response.token) {
            this.storeToken(response.token);
          }
        })
      );
  }

  // Enregistrement
  register(userDetails: Auth): Observable<any> {
    return this.httpClient.post(`${this.API_URL}${this.REGISTER_ENDPOINT}`, userDetails)
      .pipe(catchError(this.handleError));
  }

  // Déconnexion
  logout(): Observable<void> {
    return this.httpClient.post<void>(`${this.API_URL}${this.LOGOUT_ENDPOINT}`, {})
      .pipe(
        catchError(this.handleError),
        tap(() => {
          this.removeToken(); // Supprimer le token local après déconnexion
        })
      );
  }

  // Vérifie si l'utilisateur est authentifié
  isAuthenticated(): boolean {
    const token = this.getToken();
    if (token) {
      const payload = this.decodeToken(token);
      return payload && payload.exp * 1000 > Date.now(); // Vérifie si le token est expiré
    }
    return false;
  }

  
  // Récupérer le token actuel
  getToken(): string | null {
    return localStorage.getItem(this.TOKEN_KEY);
  }

  // Stocker le token
  private storeToken(token: string): void {
    localStorage.setItem(this.TOKEN_KEY, token);
  }

  // Supprimer le token
  private removeToken(): void {
    localStorage.removeItem(this.TOKEN_KEY);
  }

  // Décoder le JWT
  private decodeToken(token: string): any {
    try {
      const payload = atob(token.split('.')[1]); // Décoder la partie payload du token
      return JSON.parse(payload);
    } catch (e) {
      console.error('Erreur lors du décodage du token', e);
      return null;
    }
  }

  // Gestion des erreurs
  private handleError(error: HttpErrorResponse) {
    console.error('Erreur HTTP', error.message);
    return throwError(() => new Error('Erreur de communication avec le serveur'));
  }
}
