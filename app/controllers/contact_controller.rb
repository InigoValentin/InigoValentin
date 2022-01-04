class ContactController < ApplicationController
    def index
        @message = Message.new
    end
    def create
        # Validate message fields
        valid = true
        @errors = []
        # Name is irrelevant, don't vlaidate
        # Email has to LOOK like an email
        if !(request.POST["sender_email"].match(URI::MailTo::EMAIL_REGEXP))
             valid = false
             @errors.push("INVALID_EMAIL")
        end
        # Text needs to have something
        if request.POST["text"].length < 1
            valid = false
            @error.push("INVALID_TEXT")
        end

        # If valid, save and send the email
        if valid
            @message = Message.new()
            @message.user_id = @user.id
            @message.sender_name = request.POST["sender_name"]
            @message.sender_email = request.POST["sender_email"]
            @message.text = request.POST["text"]
            @message.dtime = Time.now
            @message.language = I18n.locale
            @message.ip = request.remote_ip
            
        
            if @message.save
                ApplicationMailer.message_email(@user, @message).deliver_later
            else
                print("Error saving message: \n")
                print("   FROM: " + request.POST["sender_name"] + "(" + request.POST["sender_email"] + ")\n")
                print("   TEXT: " + request.POST["text"] + ")\n")
                print(@message.errors.full_messages)
                print("\n")
            end
            respond_to do |format|
                format.json { render 'contact/success'}
            end
        # If invalid, return the error
        else
            respond_to do |format|
                format.json { render 'contact/error', status: 400}
            end
        end
    end

end
