class ApplicationController < ActionController::Base

    before_action :set_locale

    private
    def set_locale
        I18n.locale = extract_locale || I18n.default_locale
        logger.debug "LOCALE SET TO " + I18n.locale.to_s
    end

    def extract_locale
        logger.debug "Extracting locale: "
        parsed_locale = params[:locale]
        I18n.available_locales.map(&:to_s).include?(parsed_locale) ? parsed_locale : nil
    end
end
