import { Component, OnInit, DoCheck } from '@angular/core';
import { UserService } from './services/user.service';
import { global } from './services/global';
//import { CategoryService } from './services/category.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit, DoCheck{
  public title = 'LibraryApp';
  public identity;
  public token;
  public url;
  public categories;

  constructor( private _userService: UserService){
    this.loadUser();
    this.url = global.url;
  }
    
  ngOnInit(): void {
    //this.getCategories();
    
  }

  ngDoCheck(): void {
    
    this.loadUser();
  }

  loadUser(){
    this.identity = this._userService.getIdentity();
    this.token = this._userService.getToken();
  }

  
}