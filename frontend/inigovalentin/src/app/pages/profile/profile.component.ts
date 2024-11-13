import {Component} from '@angular/core';
import {NgFor} from '@angular/common';
import {UserService} from '../../services/user.service';
import {User} from '../../models/user';
import {MessageComponent} from '../../components/message/message.component';
declare function openMessage(): any;
declare function closeMessage(): any;

@Component({
  selector: 'app-profile',
  standalone: true,
  imports: [NgFor, MessageComponent],
  templateUrl: './profile.component.html'
})
export class ProfileComponent {
  title = 'profile';
  user: User | undefined;
  texts: {[key: string]: string} = {};
  errorMessage!: string;
  constructor(private user_service: UserService){}
  ngOnInit(){
    this.user_service.getUser().subscribe({
      next: (user) => {
        this.user = user;
        this.title = this.user.firstName + " " + this.user.lastName;
        this.user.texts?.forEach((t) => {this.texts[t.key] = t.text;});
      },
      error: (error) => {this.errorMessage = error;},
    });
  }
}
