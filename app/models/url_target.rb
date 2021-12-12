class UrlTarget < ApplicationRecord
    has_one_attached :logo
    def i18n_name
        return Text.where(language: I18n.locale, key: self.name)[0].text
    end
    def i18n_summary
        return Text.where(language: I18n.locale, key: self.summary)[0].text
    end
end
