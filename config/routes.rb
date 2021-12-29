Rails.application.routes.draw do
    scope '(:locale)', locale: /#{I18n.available_locales.join('|')}/ do
    end

    root "main#index"
    get "/:locale", to: "main#index", defaults: { locale: I18n.locale }, as: "main"
    get "/:locale/profile", to: "profile#index", defaults: { locale: I18n.locale }, as: "profile"
    get "/:locale/projects", to: "projects#index", defaults: { locale: I18n.locale }, as: "project_index"
    get "/:locale/projects/:permalink", to: "projects#show", defaults: { locale: I18n.locale }, as: 'project_show'
    get "/:locale/help", to: "help#index", defaults: { locale: I18n.locale }, as: 'help'
    get "/:locale/contact", to: "contact#index", defaults: { locale: I18n.locale }, as: 'contact'
    post "/contact", to: "contact#create", defaults: { locale: I18n.locale }, as: 'contact_create'
end
