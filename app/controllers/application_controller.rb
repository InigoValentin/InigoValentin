class ApplicationController < ActionController::Base
    rescue_from ActiveRecord::RecordNotFound, :with => :record_not_found

    before_action :set_locale
    before_action :set_user
    skip_before_action :verify_authenticity_token

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
    
    def record_not_found(m, *args, &block)
        Rails.logger.error("MMM" + m)
        print("\nMETHOD MISSING\n")
        redirect_to :controller=>"error", :action=>"error_404"
        # or render/redirect_to somewhere else
    end

    
end
