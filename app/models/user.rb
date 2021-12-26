class User < ApplicationRecord
    has_many :mail_adresses
    has_many :resumes
    has_many_attached :picture
    has_and_belongs_to_many :technologies
    has_many :user_social_links
    def i18n_tagline
        return Text.where(user_id: self.id, language: I18n.locale, key: self.tagline)[0].text
    end
    def i18n_bio
        return Text.where(user_id: self.id, language: I18n.locale, key: self.bio)[0].text
    end
end
