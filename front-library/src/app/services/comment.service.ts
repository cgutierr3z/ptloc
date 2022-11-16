import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Comment } from '../models/comment';
import { global } from './global';

@Injectable({
  providedIn: 'root'
})
export class CommentService {
  public url: string;

  constructor( private _http: HttpClient) { 
    this.url = global.url;
  }

  create(token, comment): Observable<any>{
    let json = JSON.stringify(comment);
    let params = 'json='+json;
    console.log(params);
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
                                   .set('Authorization', token);

    return this._http.post(this.url+'comment', params, {headers: headers});
  }

  getComments(): Observable<any>{
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this._http.get(this.url+'comment', {headers: headers});
  }

  getBookComments(id,token): Observable<any>{
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
                                    .set('Authorization', token);;

    return this._http.get(this.url+'comment/book/'+ id, {headers: headers});
  }

  getComment(id): Observable<any>{
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this._http.get(this.url+'comment/'+ id, {headers: headers});
  }

  update(token, post, id): Observable<any>{
    let json = JSON.stringify(post);
    let params = 'json='+json;
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
                                   .set('Authorization', token);

    return this._http.put(this.url + 'comment/' + id, params, {headers: headers});
  }

  delete(token: string, id: string): Observable<any>{
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
                                   .set('Authorization', token);

    return this._http.delete(this.url + 'comment/' + id, {headers: headers});
  }
}