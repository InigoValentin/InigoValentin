class CreateUsers < ActiveRecord::Migration[6.1]
  def change
    create_table :users do |t|
      t.string :username
      t.string :full_name
      t.string :first_name
      t.string :last_name
      t.string :tagline
      t.string :bio
      t.string :country
      t.string :city
      t.string :password
      t.string :salt
      t.boolean :admin
      t.integer :visibility

      t.timestamps
    end
  end
end
