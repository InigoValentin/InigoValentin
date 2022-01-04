class UserSocialLink < ApplicationRecord
    belongs_to :user
    belongs_to :social_link
    def generate_link
        return self.social_link.pattern.sub("*", self.link)
    end
end
