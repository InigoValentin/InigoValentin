class ProfileController < ApplicationController
    def index
        @resume_main = @user.resumes.where(user_id: @user.id, language: I18n.locale).order(priority: :desc)[0]
        @resume_languages = @user.resumes.where(user_id: @user.id, priority: @resume_main.priority).where.not(language: I18n.locale)
    end
end
