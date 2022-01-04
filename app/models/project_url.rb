class ProjectUrl < ApplicationRecord
      belongs_to :project
      belongs_to :urlTarget
end
