Rails.application.routes.draw do
    scope '(:locale)', locale: /#{I18n.available_locales.join('|')}/ do
    end

    # Profile page
    get "/:locale/profile", to: "profile#index", defaults: { locale: I18n.locale }, as: "profile"
    get "/profile/", to: "profile#index", as: "profile_canonical"
    
    # Project list
    get "/projects", to: "projects#index" , as: "projects_canonical"
    get "/:locale/projects", to: "projects#index", defaults: { locale: I18n.locale }, as: "project_index"
    
    # Project view
    get "/projects/:permalink", to: "projects#show", as: "project_canonical"
    get "/:locale/projects/:permalink", to: "projects#show", defaults: { locale: I18n.locale }, as: 'project_show'
    
    # Help page
    get "/help", to: "help#index", as: "help_canonical"
    get "/:locale/help", to: "help#index", defaults: { locale: I18n.locale }, as: 'help'
    
    # Main page
    root "main#index"
    get "/:locale", to: "main#index", defaults: { locale: I18n.locale }, as: "main"
    
    # Contact form    
    post "/contact", to: "contact#create", defaults: { locale: I18n.locale }, as: 'contact_create'
    
    # Error pages
    # Redirect to 404, but only for files without extension and content type HTML
    get '*unmatched_route', :to => 'error#error_404', format: false, constraints: { format: 'text/html' }
    
end
