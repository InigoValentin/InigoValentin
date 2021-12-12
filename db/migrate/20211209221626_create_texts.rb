class CreateTexts < ActiveRecord::Migration[6.1]
  def change
    create_table :texts do |t|
      t.references :user, null: false, foreign_key: true
      t.string :key
      t.string :language
      t.text :text

      t.timestamps
    end
  end
end
