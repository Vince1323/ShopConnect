import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { Boutique } from '../model/Boutique';

@Injectable({
  providedIn: 'root',
})
export class BoutiqueService {
  private readonly API_URL = 'http://localhost:9292/api';
  private readonly ENDPOINT_BOUTIQUE = '/boutiques';

  constructor(private httpClient: HttpClient) {}

  // POST: Ajouter une nouvelle boutique
  insertBoutique(boutique: Boutique): Observable<Boutique> {
    return this.httpClient.post<Boutique>(
      `${this.API_URL}${this.ENDPOINT_BOUTIQUE}`,
      boutique
    ).pipe(catchError(this.handleError));
  }

  // GET: Récupérer toutes les boutiques
  getAllBoutiques(): Observable<Boutique[]> {
    return this.httpClient.get<Boutique[]>(
      `${this.API_URL}${this.ENDPOINT_BOUTIQUE}/all`
    ).pipe(catchError(this.handleError));
  }

  // PUT: Mettre à jour une boutique existante
  updateBoutique(id: number, boutiqueModifiee: Boutique): Observable<Boutique> {
    return this.httpClient.put<Boutique>(
      `${this.API_URL}${this.ENDPOINT_BOUTIQUE}/${id}`,
      boutiqueModifiee
    ).pipe(catchError(this.handleError));
  }

  // DELETE: Supprimer une boutique
  deleteBoutique(id: number): Observable<void> {
    return this.httpClient.delete<void>(
      `${this.API_URL}${this.ENDPOINT_BOUTIQUE}/${id}`
    ).pipe(catchError(this.handleError));
  }

  // Handler pour les erreurs
  private handleError(error: HttpErrorResponse) {
    console.error('Erreur de la requête HTTP', error.message);
    return throwError(() => new Error('Une erreur s\'est produite lors de la communication avec le serveur; veuillez réessayer plus tard.'));
  }
}
