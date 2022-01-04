class ProjectsController < ApplicationController
    def index
        @projects = Project.where(user_id: @user.id).order(priority: :desc)
    end
    def show
        @project = Project.where(permalink: params[:permalink])[0]
        if @project == nil
            print("ERROR 404")
            #render status: 404
            #redirect_to '/404'
            respond_to do |format|
                format.all { render "error/error_404", status: 404}
              end
        end
    end
end
