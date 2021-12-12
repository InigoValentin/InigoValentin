class CreateMailAdresses < ActiveRecord::Migration[6.1]
  def change
    create_table :mail_adresses do |t|
      t.references :user, null: false, foreign_key: true
      t.string :address
      t.integer :priority
      t.integer :visibility

      t.timestamps
    end
  end
end
