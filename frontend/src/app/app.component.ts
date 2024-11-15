import {Component, Input} from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { NavbarComponent } from './components/navbar/navbar.component';
import { FooterComponent } from './components/footer/footer.component';
import {User} from './models/user';
import {MetaService} from './services/meta.service'
import {UserService} from './services/user.service'

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, NavbarComponent, FooterComponent],
  templateUrl: './app.component.html'
})
export class AppComponent {
  testvar: string = "TEST";
  user: User;
  texts: {[key: string]: string} = {};
  errorMessage!: string;
  constructor(private metaService: MetaService, private userService: UserService){this.user = new User();}

  ngOnInit(){
    this.userService.getUser().subscribe({
      error: (error) => {this.errorMessage = error;},
      next: (user) => {
        this.user = user;
        //this.metaService.setTitle(this.user.firstName);
        this.metaService.setMetaTag("author", this.user.firstName + " " + this.user.lastName);
      },
    });
  }
}
