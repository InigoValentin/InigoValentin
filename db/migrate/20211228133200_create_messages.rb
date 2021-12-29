class CreateMessages < ActiveRecord::Migration[6.1]
  def change
    create_table :messages do |t|
      t.references :user, null: false, foreign_key: true
      t.string :sender_name
      t.string :sender_email
      t.text :text
      t.datetime :dtime
      t.string :language
      t.string :ip

      t.timestamps
    end
  end
end
