require_relative "boot"

require "rails/all"

# Require the gems listed in Gemfile, including any gems
# you've limited to :test, :development, or :production.
Bundler.require(*Rails.groups)

module InigoValentin
  class Application < Rails::Application
    # Initialize configuration defaults for originally generated Rails version.
    config.load_defaults 6.1

    # Configuration for the application, engines, and railties goes here.
    #
    # These settings can be overridden in specific environments using the files
    # in config/environments, which are processed later.
    #
    # config.time_zone = "Central Time (US & Canada)"
    # config.eager_load_paths << Rails.root.join("extras")
    config.assets.paths << Rails.root.join("app", "assets", "images")
    
    # Show assests without digest
    config.assets.digest = false
    
    # Active storage prefix
    config.active_storage.routes_prefix = '/content'
    
    # Hack for allowing SVG files. While this hack is here, we should **not**
    # allow arbitrary SVG uploads. https://github.com/rails/rails/issues/34665
    ActiveStorage::Engine.config
    .active_storage
    .content_types_to_serve_as_binary
    .delete('image/svg+xml')

    # Serve raw html from assests (for resumes)
    ActiveStorage::Engine.config
    .active_storage
    .content_types_to_serve_as_binary
    .delete('text/html')
    ActiveStorage::Engine.config.active_storage.content_types_allowed_inline.append('text/html')
    
    config.exceptions_app = self.routes
    
    config.action_mailer.delivery_method = :smtp
    config.action_mailer.smtp_settings = {
       address:              Rails.application.credentials.smtp[:server],
       port:                 Rails.application.credentials.smtp[:port],
       domain:               Rails.application.credentials.smtp[:domain],
       user_name:            Rails.application.credentials.smtp[:username],
       password:             Rails.application.credentials.smtp[:password],
       authentication:       Rails.application.credentials.smtp[:authentication],
       #enable_starttls_auto: Rails.application.credentials.smtp[:enable_starttls_auto]
       ssl:                  Rails.application.credentials.smtp[:ssl],
       openssl_verify_mode:  Rails.application.credentials.smtp[:openssl_verify_mode]
    }
    
  end
end
