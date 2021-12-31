class ApplicationMailer < ActionMailer::Base
    layout 'mailer'
    default from: Rails.application.credentials.smtp[:username]
   
    def message_email(user, message)
        @message = message
        to = user.mail_adresses[0].address
        to = Rails.application.credentials.smtp[:username]
        mail(to: to, subject: 'New message')
    end
end
