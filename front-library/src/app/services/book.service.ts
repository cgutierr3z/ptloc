import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Book } from '../models/book';
import { global } from './global';

@Injectable({
  providedIn: 'root'
})
export class BookService {
  public url: string;

  constructor( private _http: HttpClient) { 
    this.url = global.url;
  }

  create(token, book): Observable<any>{
    let json = JSON.stringify(book);
    let params = 'json='+json;
    console.log(params);
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
                                   .set('Authorization', token);

    return this._http.post(this.url+'book', params, {headers: headers});
  }

  getBooks(): Observable<any>{
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this._http.get(this.url+'book', {headers: headers});
  }

  getBook(id): Observable<any>{
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this._http.get(this.url+'book/'+ id, {headers: headers});
  }

  update(token, post, id): Observable<any>{
    let json = JSON.stringify(post);
    let params = 'json='+json;
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
                                   .set('Authorization', token);

    return this._http.put(this.url + 'book/' + id, params, {headers: headers});
  }

  delete(token: string, id: string): Observable<any>{
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
                                   .set('Authorization', token);

    return this._http.delete(this.url + 'book/' + id, {headers: headers});
  }
}