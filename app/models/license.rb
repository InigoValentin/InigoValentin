class License < ApplicationRecord
    has_many :project
    has_one_attached :logo
end
