class CreateResumes < ActiveRecord::Migration[6.1]
  def change
    create_table :resumes do |t|
      t.references :user, null: false, foreign_key: true
      t.string :language
      t.integer :priority
      t.boolean :printable
      t.string :format

      t.timestamps
    end
  end
end
