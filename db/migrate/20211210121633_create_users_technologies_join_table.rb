class CreateUsersTechnologiesJoinTable < ActiveRecord::Migration[6.1]
  def change
    create_join_table :users, :technologies do |t|
    t.index :user_id
    t.index :technology_id
    end
  end
end
