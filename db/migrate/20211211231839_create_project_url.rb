class CreateProjectUrl < ActiveRecord::Migration[6.1]
  def change
    create_table :project_urls do |t|
      t.references :project, null: false, type: :bigint
      t.string :url
      t.references :urlTarget, null: false, type: :bigint

      t.timestamps
    end
  end
end
