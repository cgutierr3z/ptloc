import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { UserService } from '../../services/user.service';
import { Book } from '../../models/book';
import { global } from '../../services/global';
import { BookService } from '../../services/book.service';

@Component({
  selector: 'app-book-new',
  templateUrl: './book-new.component.html',
  styles: [
  ]
})
export class BookNewComponent implements OnInit {

  public page_title: string;
  public identity;
  public token;
  public status;
  public book: Book;
  public categories;
  public is_edit = false;

  public afuConfig = {
    multiple: false,
    formatsAllowed: ".jpg,.png,.gif,.jpeg",
    maxSize: "50",
    uploadAPI: {
      url: global.url + 'book/upload',
      method: "POST",
      headers: {
        "Authorization": this._userService.getToken()
      },
    },
    theme: "attachPin",
    hideProgressBar: false,
    hideResetBtn: true,
    hideSelectBtn: false,
    fileNameIndex: false,
    attachPinText: 'Presione para cargar Archivo',
    replaceTexts: {
      selectFileBtn: 'Select Files',
      resetBtn: 'Reset',
      uploadBtn: 'Upload',
      dragNDropBox: 'Drag N Drop',
      attachPinBtn: 'Attach Files...',
      afterUploadMsg_success: 'Successfully Uploaded !',
      afterUploadMsg_error: 'Upload Failed !',
      sizeLimit: 'Size Limit'
    }
  };

  constructor(private _router: Router,
    private _userService: UserService,
    private _bookService: BookService
  ) {

    this.page_title = 'Crear un libro'
    this.identity = this._userService.getIdentity();
    this.token = this._userService.getToken();

  }

  ngOnInit(): void {
    this.book = new Book(1, this.identity.sub, '', '', null, null, '', 0, '');
    //this.getCategories();
    
  }

  onSubmit(form) {
    //console.log(this.book);
    this._bookService.create(this.token, this.book).subscribe(
      resp => {
        if (resp.status == 'success') {
          this.book = resp.book;
          this.status = 'success';
          this._router.navigate(['/inicio']);
          //console.log(this.book);
        } else {
          this.status = 'error';
        }
      },
      error => {
        this.status = 'error';
        console.log(<any>error);
      }
    );
  }

  imageUpload(data) {
    let image_data = JSON.parse(data.response);
    this.book.image = image_data.image;
  }

}
