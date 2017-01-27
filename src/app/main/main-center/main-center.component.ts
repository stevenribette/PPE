import { Component, OnInit, ViewChild } from '@angular/core';
import { Router } from '@angular/router';
import { MdSidenav } from '@angular/material';

@Component({
  selector: 'pr-main-center',
  templateUrl: './main-center.component.html',
  styleUrls: ['./main-center.component.css']
})
export class MainCenterComponent implements OnInit {

  @ViewChild(MdSidenav) sidenav: MdSidenav;

  //localStorage can take only string variable
  private theme = JSON.parse(localStorage['Theme']);

  constructor(private router: Router) { }

  ngOnInit() {
  }
  //Change the theme
  onThemeClicked() {
    this.theme =!this.theme;
    localStorage['Theme'] = JSON.stringify(this.theme); // only strings
  }

}
