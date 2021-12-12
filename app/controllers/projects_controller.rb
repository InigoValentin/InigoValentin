class ProjectsController < ApplicationController
    def index
        @projects = Project.all
    end
    def show
        @project = Project.where(permalink: params[:permalink])[0]
    end
end
