Rails.application.routes.draw do
    scope '(:locale)', locale: /#{I18n.available_locales.join('|')}/ do
        I18n.locale = :locale
    end

    if :locale == nil
        locale = I18n.default_locale
    end

    root "main#index"
    get "/:locale", to: "main#index", as: 'main'
    get "/profile", to: "profile#index", as: 'profile'
    get "/:locale/profile", to: "profile#index"
    get "/projects", to: "projects#index"
    get "/:locale/projects", to: "projects#index", as: 'project_index'
    get "/projects/:permalink", to: "projects#show", as: 'project_show'
    get "/:locale/projects/:permalink", to: "projects#show"
    get "/help", to: "help#index"
end
