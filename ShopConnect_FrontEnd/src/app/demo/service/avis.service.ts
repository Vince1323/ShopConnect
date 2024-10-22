import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { Avis } from '../model/Avis';

@Injectable({
  providedIn: 'root',
})
export class AvisService {
  private readonly API_URL = 'http://localhost:9292/api';
  private readonly ENDPOINT_AVIS = '/avis';

  constructor(private httpClient: HttpClient) {}

  // POST: Ajouter un nouvel avis
  insertAvis(avis: Avis): Observable<Avis> {
    return this.httpClient.post<Avis>(
      `${this.API_URL}${this.ENDPOINT_AVIS}`,
      avis
    ).pipe(catchError(this.handleError));
  }

  // GET: Récupérer tous les avis
  getAllAvis(): Observable<Avis[]> {
    return this.httpClient.get<Avis[]>(
      `${this.API_URL}${this.ENDPOINT_AVIS}/all`
    ).pipe(catchError(this.handleError));
  }

  // PUT: Mettre à jour un avis existant
  updateAvis(id: number, avisModifie: Avis): Observable<Avis> {
    return this.httpClient.put<Avis>(
      `${this.API_URL}${this.ENDPOINT_AVIS}/${id}`,
      avisModifie
    ).pipe(catchError(this.handleError));
  }

  // DELETE: Supprimer un avis
  deleteAvis(id: number): Observable<void> {
    return this.httpClient.delete<void>(
      `${this.API_URL}${this.ENDPOINT_AVIS}/${id}`
    ).pipe(catchError(this.handleError));
  }

  // Handler pour les erreurs
  private handleError(error: HttpErrorResponse) {
    console.error('Erreur de la requête HTTP', error.message);
    return throwError(() => new Error('Une erreur s\'est produite lors de la communication avec le serveur; veuillez réessayer plus tard.'));
  }
}
