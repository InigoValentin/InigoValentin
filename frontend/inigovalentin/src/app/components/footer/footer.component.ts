import { Component } from '@angular/core';
import {AsyncPipe, NgFor} from '@angular/common';
import {UserService} from '../../services/user.service';
import {User} from '../../models/user';
import {AppComponent} from '../../app.component';

@Component({
  selector: 'app-footer',
  standalone: true,
  imports: [AsyncPipe, NgFor],
  templateUrl: './footer.component.html'
})
export class FooterComponent {
  user: User | undefined;
  errorMessage!: string;
  constructor(private user_service: UserService){}
  ngOnInit(){
    //this.user = this.app.guser;
    this.user_service.getUser().subscribe({
      next: (user) => {this.user = user;},
      error: (error) => {this.errorMessage = error;},
    });

  }
}
