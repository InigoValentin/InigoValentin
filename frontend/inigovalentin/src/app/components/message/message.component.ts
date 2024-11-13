import {Component} from '@angular/core';
import {FormsModule, NgForm} from '@angular/forms';
import {HttpClient} from '@angular/common/http';
import {Message} from '../../models/message';

@Component({
  selector: 'app-message',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './message.component.html'
})
export class MessageComponent {

  validateEmail(email: string){
      return email && email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      );
  }

  constructor(private http: HttpClient) {}

  onSubmit(form: NgForm) {
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

    const apiUrl = 'http://localhost:8080/api/messages/';
    const message = new Message(name, email, subject, text);
    this.http.post<Message>(apiUrl, message).subscribe(data => {
      console.log("SENT: " + JSON.stringify(data));
      //if (data.status === 200) console.log("SENT OK");
      //else console.log("NOT SENT: status " + data.status + " - " + data.statusMessage);
    })

    console.log("VALUE: " + JSON.stringify(form.value)); // { first: '', last: '' }
    console.log("VALID: " + form.valid); // false
  }
}
