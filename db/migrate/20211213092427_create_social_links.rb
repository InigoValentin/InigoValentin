class CreateSocialLinks < ActiveRecord::Migration[6.1]
  def change
    create_table :social_links do |t|
      t.string :site_name
      t.string :pattern
      t.string :regexp
      t.string :link_title

      t.timestamps
    end
  end
end
