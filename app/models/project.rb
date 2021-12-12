class Project < ApplicationRecord
    has_one_attached :logo
    has_and_belongs_to_many :technologies
    has_many :projectUrls
    belongs_to :license
    def i18n_title
        return Text.where(user_id: self.user_id, language: I18n.locale, key: self.title)[0].text
    end
    def i18n_header
        return Text.where(user_id: self.user_id, language: I18n.locale, key: self.header)[0].text
    end
    def i18n_text
        return Text.where(user_id: self.user_id, language: I18n.locale, key: self.text)[0].text
    end
end
