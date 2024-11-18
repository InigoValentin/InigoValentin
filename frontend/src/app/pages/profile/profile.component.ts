/**
 * @file Provides a component for the home page.
 * @author Inigo Valentin
 * @since 4.0.0
 */

import {Component} from '@angular/core';
import {NgFor} from '@angular/common';
import {TranslateModule} from "@ngx-translate/core";
import {User} from '../../models/user';
import {UserService} from '../../services/user.service';
import {MetaService} from '../../services/meta.service';

@Component({
  selector: 'app-profile',
  standalone: true,
  imports: [NgFor, TranslateModule],
  templateUrl: './profile.component.html'
})

/**
 * The component for the profile page.
 */
export class ProfileComponent {

  /**
   * The active user.
   */
  protected user: User | undefined;

  /**
   * Texts with user information.
   */
  protected texts: {[key: string]: string} = {};

  /**
   * The error message.
   */
  protected errorMessage!: string;

  /**
   * The constructor.
   *
   * @param metaService Service that handles HTML meta tags.
   * @param userService Service that handles user information.
   */
  constructor(private metaService: MetaService, private userService: UserService){}

  /**
   * Loads on component initialization.
   */
  ngOnInit(){
    this.userService.getUser().subscribe({
      next: (user) => {
        this.user = user;
        this.user.texts?.forEach((t) => {this.texts[t.key] = t.text;});
        this.metaService.setTitle("About me - " + this.user.firstName + " " + this.user.lastName);
        this.metaService.setMetaTag("description", "About " + this.user.firstName + " " + this.user.lastName);
      },
      error: (error) => {this.errorMessage = error;},
    });
  }
}
