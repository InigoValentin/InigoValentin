class MainController < ApplicationController
    def index
        @projects = Project.where(user_id: @user.id).order(priority: :desc).limit(3)
    end
end
