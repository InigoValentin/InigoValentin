class CreateUserSocialLinks < ActiveRecord::Migration[6.1]
  def change
    create_table :user_social_links do |t|
      t.references :user, null: false, foreign_key: true
      t.references :social_link, null: false, foreign_key: true
      t.integer :priority
      t.string :link

      t.timestamps
    end
  end
end
