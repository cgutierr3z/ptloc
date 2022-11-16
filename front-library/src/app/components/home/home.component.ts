import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  public page_tittle: string;

  constructor() { 
    this.page_tittle = 'Inicio';
  }

  ngOnInit() {
  }

}
