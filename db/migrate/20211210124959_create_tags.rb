class CreateTags < ActiveRecord::Migration[6.1]
  def change
    create_table :tags do |t|
      t.references :project, null: false, foreign_key: true
      t.string :tag

      t.timestamps
    end
  end
end
