class MainController < ApplicationController
    def index
        @user = User.find(1)
        @projects = Project.where(user_id: @user.id).order(priority: :desc).limit(3)
    end
end
