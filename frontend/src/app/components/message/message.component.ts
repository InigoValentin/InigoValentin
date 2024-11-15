/**
 * @file Provides a component for the message form.
 * @author Inigo Valentin
 * @since 4.0.0
 */

import {Component} from '@angular/core';
import {FormsModule, NgForm} from '@angular/forms';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {Message} from '../../models/message';
import {environment} from '../../../environments/environment';

@Component({
  selector: 'app-message',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './message.component.html'
})

/**
 * The component for the message form.
 *
 * It includes the name as the logo and the navigation bar.
 */
export class MessageComponent {

  /**
   * Validates an email address.
   *
   * @param email The email address to validate.
   * @return True for valid email addressess, false for invalid ones.
   */
  private validateEmail(email: string){
      return email && email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      );
  }

  /**
   * The constructor.
   *
   * @param http For sending the message request.
   */
  public constructor(private http: HttpClient) {}

  /**
   * Handles the form submission.
   *
   * Also, it validates the input fields.
   */
  protected onSubmit(form: NgForm) {
    // Clear errors
    document.getElementById("error_name")?.setAttribute("style", "visibility:hidden;")
    document.getElementById("error_email")?.setAttribute("style", "visibility:hidden;");
    document.getElementById("error_message")?.setAttribute("style", "visibility:hidden;");
    document.getElementById("error_consent")?.setAttribute("style", "visibility:hidden;");

    var valid = true;
    const name = form.value.name;
    const email = form.value.email;
    const subject = form.value.subject;
    const text = form.value.text;
    const consent = form.value.consent === true;
    if (!name || name == ""){
      valid = false;
      document.getElementById("error_name")?.setAttribute("style", "visibility:visible;")
    }
    if (!this.validateEmail(email)){
      valid = false;
      document.getElementById("error_email")?.setAttribute("style", "visibility:visible;")
    }
    if (!text || text == ""){
      valid = false;
      document.getElementById("error_message")?.setAttribute("style", "visibility:visible;")
    }
    if (!consent){
      valid = false;
      document.getElementById("error_consent")?.setAttribute("style", "visibility:visible;")
    }
    if (!valid) return;

    const apiUrl = environment.API_URL + 'messages/';
    const message = new Message(name, email, subject, text);
    this.http.post<Message>(
      apiUrl,
      message,
      {headers: new HttpHeaders({ 'Content-Type': 'application/json'}), observe: 'response'}
    ).subscribe(data => {
      if (data.status === 200){
        document.getElementById("message_form")?.setAttribute("style", "display:none;");
        document.getElementById("message_confirmation")?.setAttribute("style", "display:block;");
      }
      // TODO: DO something on error.
    })
  }
}
