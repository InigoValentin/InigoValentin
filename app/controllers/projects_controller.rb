class ProjectsController < ApplicationController
    def index
        @projects = Project.where(user_id: @user.id).order(priority: :desc)
    end
    def show
        @project = Project.where(permalink: params[:permalink])[0]
    end
end
