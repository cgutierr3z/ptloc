import { Component, OnInit } from '@angular/core';
import { BookService } from '../../services/book.service';
import { Book } from '../../models/book';
import { ActivatedRoute, Router } from '@angular/router';
import { global } from '../../services/global';
import { UserService } from '../../services/user.service';
import { Comment } from 'src/app/models/comment';
import { CommentService } from 'src/app/services/comment.service';

@Component({
  selector: 'app-book-detail',
  templateUrl: './book-detail.component.html',
  providers: [BookService, CommentService]
})
export class BookDetailComponent implements OnInit {

  public book: Book;
  public comments: Array<Comment>;
  public url;
  public identity;
  public token;

  constructor(private _bookService: BookService,
    private _route: ActivatedRoute,
    private _router: Router,
    private _userService: UserService,
    private _commentService: CommentService) { }

  ngOnInit(): void {
    this.url = global.url;
    this.identity = this._userService.getIdentity();
    this.token = this._userService.getToken();
    this.getBook();
    this.getBookComments();
  }

  getBook() {
    // sacar el id del book
    this._route.params.subscribe(
      params => {
        let id = +params['id'];
        console.log(params);
        //peticion ajax para sacar los datos del book
        this._bookService.getBook(id).subscribe(
          resp => {
            if (resp.status == 'success') {
              this.book = resp.book;
              console.log(this.book);
            } else {
              this._router.navigate(['/libros']);
            }
          },
          error => {
            console.log(<any>error);
            this._router.navigate(['/login']);
          }
        );
      });
  }

  getBookComments() {
    // sacar el id del book
    this._route.params.subscribe(
      params => {
        let id = +params['id'];
        console.log("comments");
        console.log(params);
        console.log("comments");
        //peticion ajax para sacar los datos del book
        this._commentService.getBookComments(id,this.token).subscribe(
          resp => {
            if (resp.status == 'success') {
              this.comments = resp.comments;
              console.log(this.comments);
            } else {
              this._router.navigate(['/libros']);
            }
          },
          error => {
            console.log(<any>error);
            this._router.navigate(['/login']);
          }
        );
      });
  }

}
