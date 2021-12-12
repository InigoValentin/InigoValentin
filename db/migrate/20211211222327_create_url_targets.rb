class CreateUrlTargets < ActiveRecord::Migration[6.1]
  def change
    create_table :url_targets do |t|
      t.string :name
      t.string :summary

      t.timestamps
    end
  end
end
