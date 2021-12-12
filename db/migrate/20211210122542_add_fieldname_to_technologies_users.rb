class AddFieldnameToTechnologiesUsers < ActiveRecord::Migration[6.1]
  def change
    add_column :technologies_users, :value, :tinyint
  end
end
