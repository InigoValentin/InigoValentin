class ApplicationController < ActionController::Base

    before_action :set_locale
    before_action :set_user

    

    private
    
    def set_user
        @user = User.find(1)
    end
    
    def set_locale
        I18n.locale = extract_locale || I18n.default_locale
        Rails.application.reload_routes!
    end

    def extract_locale
        parsed_locale = params[:locale]
        I18n.available_locales.map(&:to_s).include?(parsed_locale) ? parsed_locale : nil
    end
    
end
