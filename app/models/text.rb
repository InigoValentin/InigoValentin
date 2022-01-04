class Text < ApplicationRecord
    belongs_to :user, optional: true
end
