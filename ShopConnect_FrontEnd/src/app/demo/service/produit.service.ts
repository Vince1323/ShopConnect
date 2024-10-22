import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { Produit } from '../model/Produit';

@Injectable({
  providedIn: 'root',
})
export class ProduitService {
  private readonly API_URL = 'http://localhost:9292/api';
  private readonly ENDPOINT_PRODUIT = '/produits';

  constructor(private httpClient: HttpClient) {}

  insertProduit(produit: Produit): Observable<Produit> {
    return this.httpClient.post<Produit>(
      `${this.API_URL}${this.ENDPOINT_PRODUIT}`,
      produit
    ).pipe(catchError(this.handleError));
  }

  getAllProduits(): Observable<Produit[]> {
    return this.httpClient.get<Produit[]>(
      `${this.API_URL}${this.ENDPOINT_PRODUIT}/all`
    ).pipe(catchError(this.handleError));
  }

  updateProduit(id: number, produit: Produit): Observable<Produit> {
    return this.httpClient.put<Produit>(
      `${this.API_URL}${this.ENDPOINT_PRODUIT}/${id}`,
      produit
    ).pipe(catchError(this.handleError));
  }

  deleteProduit(id: number): Observable<void> {
    return this.httpClient.delete<void>(
      `${this.API_URL}${this.ENDPOINT_PRODUIT}/${id}`
    ).pipe(catchError(this.handleError));
  }

  private handleError(error: HttpErrorResponse) {
    console.error('HTTP Error', error.message);
    return throwError(() => new Error('Server communication error'));
  }
}
