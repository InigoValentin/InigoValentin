class CreateProjects < ActiveRecord::Migration[6.1]
  def change
    create_table :projects do |t|
      t.string :permalink
      t.integer :priority
      t.integer :nature
      t.string :title
      t.string :logo
      t.string :header
      t.text :text
      t.references :license, null: false, foreign_key: true
      t.references :user, null: false, foreign_key: true
      t.integer :visibility

      t.timestamps
    end
  end
end
