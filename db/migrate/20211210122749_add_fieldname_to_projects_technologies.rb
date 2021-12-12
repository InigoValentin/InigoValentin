class AddFieldnameToProjectsTechnologies < ActiveRecord::Migration[6.1]
  def change
    add_column :projects_technologies, :value, :tinyint
  end
end
