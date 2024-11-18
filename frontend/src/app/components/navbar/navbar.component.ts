/**
 * @file Provides a component for the page header.
 * @author Inigo Valentin
 * @since 4.0.0
 */

import {Component} from '@angular/core';
import {NgIf} from '@angular/common';
import {TranslateModule} from "@ngx-translate/core";
import {RouterModule} from '@angular/router';
import {User} from '../../models/user';
import {UserService} from '../../services/user.service';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [RouterModule, NgIf, TranslateModule],
  templateUrl: './navbar.component.html'
})

/**
 * The component for the page header.
 *
 * It includes the user name as the logo and the navigation bar.
 */
export class NavbarComponent {

  /**
   * The active user.
   */
  public user: User | undefined;

  /**
   * The error message.
   */
  private errorMessage!: string;

  /**
   * The constructor.
   *
   * @param userService Service that handles user information.
   */
  public constructor(private userService: UserService){}

  /**
   * Loads on component initialization.
   */
  private async ngOnInit(){
    this.userService.getUser().subscribe({
      error: (error) => {this.errorMessage = error;},
      next: (user) => {this.user = user;},
    });
  }
}
