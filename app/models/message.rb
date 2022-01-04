class Message < ApplicationRecord
    belongs_to :user
    validates :sender_email, presence: true
    validates :text, presence: true, length: { minimum: 10 }
end
