import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { Panier } from '../model/Panier';

@Injectable({
  providedIn: 'root',
})
export class PanierService {
  private readonly API_URL = 'http://localhost:9292/api';
  private readonly ENDPOINT_PANIER = '/paniers';

  constructor(private httpClient: HttpClient) {}

  insertPanier(panier: Panier): Observable<Panier> {
    return this.httpClient.post<Panier>(
      `${this.API_URL}${this.ENDPOINT_PANIER}`,
      panier
    ).pipe(catchError(this.handleError));
  }

  getAllPaniers(): Observable<Panier[]> {
    return this.httpClient.get<Panier[]>(
      `${this.API_URL}${this.ENDPOINT_PANIER}/all`
    ).pipe(catchError(this.handleError));
  }

  updatePanier(id: number, panier: Panier): Observable<Panier> {
    return this.httpClient.put<Panier>(
      `${this.API_URL}${this.ENDPOINT_PANIER}/${id}`,
      panier
    ).pipe(catchError(this.handleError));
  }

  deletePanier(id: number): Observable<void> {
    return this.httpClient.delete<void>(
      `${this.API_URL}${this.ENDPOINT_PANIER}/${id}`
    ).pipe(catchError(this.handleError));
  }

  private handleError(error: HttpErrorResponse) {
    console.error('HTTP Error', error.message);
    return throwError(() => new Error('Server communication error'));
  }
}
