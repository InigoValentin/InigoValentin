class ApplicationMailer < ActionMailer::Base
    layout 'mailer'
    default from: Rails.application.credentials.smtp[:username]
   
    def message_email(user, message)
        @message = message
        to = user.mail_adresses[0].address
        print("SENDING EMAIL\n")
        print("SENDING TO " + to + "\n")
        print("DOMAIN TO " + Rails.application.credentials.smtp[:domain] + "\n")
        print("AUTH " + Rails.application.credentials.smtp[:authentication] + "\n")
        to = Rails.application.credentials.smtp[:username]
        mail(to: to, subject: 'New message')
    end
end
