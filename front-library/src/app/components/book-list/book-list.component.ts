import { Component, OnInit } from '@angular/core';
import { UserService } from '../../services/user.service';
import { BookService } from 'src/app/services/book.service';
import { global } from '../../services/global';
import { Book } from 'src/app/models/book';

@Component({
  selector: 'app-book-list',
  templateUrl: './book-list.component.html',
  styleUrls: ['./book-list.component.css']
})
export class BookListComponent implements OnInit {
  
  public page_title: string;
  public books: Array<Book>;
  public status: string
  public identity;
  public token;
  public url = global.url;

  constructor( 
    private _userService: UserService,
    private _bookService: BookService,
    
    ){
    this.page_title = 'Listado de libros';
    this.loadUser();
    this.url = global.url;
  }

  ngOnInit() {
    this.getBooks();
  }

    loadUser(){
    this.identity = this._userService.getIdentity();
    this.token = this._userService.getToken();
  }

  getBooks(){
    this._bookService.getBooks().subscribe(
      resp=>{
        if(resp.status == 'success'){
          this.books = resp.books;
          console.log(this.books);
          this.status = 'success';
        }
      },
      error=>{
        this.status = 'error';
        console.log(<any>error);
      }
    )
  }

}
