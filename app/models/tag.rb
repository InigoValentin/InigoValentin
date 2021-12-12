class Tag < ApplicationRecord
    belongs_to :project_id
    def i18n_tag
        return t(self.tag)
    end
end
