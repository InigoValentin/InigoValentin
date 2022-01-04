class SocialLink < ApplicationRecord
    has_one_attached :logo
    def i18n_link_title
        return Text.where(language: I18n.locale, key: self.link_title)[0].text
    end
end
