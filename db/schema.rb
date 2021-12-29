# This file is auto-generated from the current state of the database. Instead
# of editing this file, please use the migrations feature of Active Record to
# incrementally modify your database, and then regenerate this schema definition.
#
# This file is the source Rails uses to define your schema when running `bin/rails
# db:schema:load`. When creating a new database, `bin/rails db:schema:load` tends to
# be faster and is potentially less error prone than running all of your
# migrations from scratch. Old migrations may fail to apply correctly if those
# migrations use external dependencies or application code.
#
# It's strongly recommended that you check this file into your version control system.

ActiveRecord::Schema.define(version: 2021_12_28_133200) do

  create_table "active_storage_attachments", charset: "utf8mb4", force: :cascade do |t|
    t.string "name", null: false
    t.string "record_type", null: false
    t.bigint "record_id", null: false
    t.bigint "blob_id", null: false
    t.datetime "created_at", null: false
    t.index ["blob_id"], name: "index_active_storage_attachments_on_blob_id"
    t.index ["record_type", "record_id", "name", "blob_id"], name: "index_active_storage_attachments_uniqueness", unique: true
  end

  create_table "active_storage_blobs", charset: "utf8mb4", force: :cascade do |t|
    t.string "key", null: false
    t.string "filename", null: false
    t.string "content_type"
    t.text "metadata"
    t.string "service_name", null: false
    t.bigint "byte_size", null: false
    t.string "checksum", null: false
    t.datetime "created_at", null: false
    t.index ["key"], name: "index_active_storage_blobs_on_key", unique: true
  end

  create_table "active_storage_variant_records", charset: "utf8mb4", force: :cascade do |t|
    t.bigint "blob_id", null: false
    t.string "variation_digest", null: false
    t.index ["blob_id", "variation_digest"], name: "index_active_storage_variant_records_uniqueness", unique: true
  end

  create_table "licenses", charset: "utf8mb4", force: :cascade do |t|
    t.string "name"
    t.string "url"
    t.datetime "created_at", precision: 6, null: false
    t.datetime "updated_at", precision: 6, null: false
  end

  create_table "mail_adresses", charset: "utf8mb4", force: :cascade do |t|
    t.bigint "user_id", null: false
    t.string "address"
    t.integer "priority"
    t.integer "visibility"
    t.datetime "created_at", precision: 6, null: false
    t.datetime "updated_at", precision: 6, null: false
    t.index ["user_id"], name: "index_mail_adresses_on_user_id"
  end

  create_table "messages", charset: "utf8mb4", force: :cascade do |t|
    t.bigint "user_id", null: false
    t.string "sender_name"
    t.string "sender_email"
    t.text "text"
    t.datetime "dtime"
    t.string "language"
    t.string "ip"
    t.datetime "created_at", precision: 6, null: false
    t.datetime "updated_at", precision: 6, null: false
    t.index ["user_id"], name: "index_messages_on_user_id"
  end

  create_table "project_urls", charset: "utf8mb4", force: :cascade do |t|
    t.bigint "project_id", null: false
    t.string "url"
    t.bigint "urlTarget_id", null: false
    t.datetime "created_at", precision: 6, null: false
    t.datetime "updated_at", precision: 6, null: false
    t.index ["project_id"], name: "index_project_urls_on_project_id"
    t.index ["urlTarget_id"], name: "index_project_urls_on_urlTarget_id"
  end

  create_table "projects", charset: "utf8mb4", force: :cascade do |t|
    t.string "permalink"
    t.integer "priority"
    t.integer "nature"
    t.string "title"
    t.string "logo"
    t.string "header"
    t.text "text"
    t.bigint "license_id", null: false
    t.bigint "user_id", null: false
    t.integer "visibility"
    t.datetime "created_at", precision: 6, null: false
    t.datetime "updated_at", precision: 6, null: false
    t.index ["license_id"], name: "index_projects_on_license_id"
    t.index ["user_id"], name: "index_projects_on_user_id"
  end

  create_table "projects_technologies", id: false, charset: "utf8mb4", force: :cascade do |t|
    t.bigint "project_id", null: false
    t.bigint "technology_id", null: false
    t.integer "value", limit: 1
    t.index ["project_id"], name: "index_projects_technologies_on_project_id"
    t.index ["technology_id"], name: "index_projects_technologies_on_technology_id"
  end

  create_table "resumes", charset: "utf8mb4", force: :cascade do |t|
    t.bigint "user_id", null: false
    t.string "language"
    t.integer "priority"
    t.boolean "printable"
    t.string "format"
    t.datetime "created_at", precision: 6, null: false
    t.datetime "updated_at", precision: 6, null: false
    t.index ["user_id"], name: "index_resumes_on_user_id"
  end

  create_table "social_links", charset: "utf8mb4", force: :cascade do |t|
    t.string "site_name"
    t.string "pattern"
    t.string "regexp"
    t.string "link_title"
    t.datetime "created_at", precision: 6, null: false
    t.datetime "updated_at", precision: 6, null: false
  end

  create_table "tags", charset: "utf8mb4", force: :cascade do |t|
    t.bigint "project_id", null: false
    t.string "tag"
    t.datetime "created_at", precision: 6, null: false
    t.datetime "updated_at", precision: 6, null: false
    t.index ["project_id"], name: "index_tags_on_project_id"
  end

  create_table "technologies", charset: "utf8mb4", force: :cascade do |t|
    t.string "name"
    t.integer "nature"
    t.datetime "created_at", precision: 6, null: false
    t.datetime "updated_at", precision: 6, null: false
  end

  create_table "technologies_users", id: false, charset: "utf8mb4", force: :cascade do |t|
    t.bigint "user_id", null: false
    t.bigint "technology_id", null: false
    t.integer "value", limit: 1
    t.index ["technology_id"], name: "index_technologies_users_on_technology_id"
    t.index ["user_id"], name: "index_technologies_users_on_user_id"
  end

  create_table "texts", charset: "utf8mb4", force: :cascade do |t|
    t.bigint "user_id", null: false
    t.string "key"
    t.string "language"
    t.text "text"
    t.datetime "created_at", precision: 6, null: false
    t.datetime "updated_at", precision: 6, null: false
    t.index ["user_id"], name: "index_texts_on_user_id"
  end

  create_table "url_targets", charset: "utf8mb4", force: :cascade do |t|
    t.string "name"
    t.string "summary"
    t.datetime "created_at", precision: 6, null: false
    t.datetime "updated_at", precision: 6, null: false
  end

  create_table "user_social_links", charset: "utf8mb4", force: :cascade do |t|
    t.bigint "user_id", null: false
    t.bigint "social_link_id", null: false
    t.integer "priority"
    t.string "link"
    t.datetime "created_at", precision: 6, null: false
    t.datetime "updated_at", precision: 6, null: false
    t.index ["social_link_id"], name: "index_user_social_links_on_social_link_id"
    t.index ["user_id"], name: "index_user_social_links_on_user_id"
  end

  create_table "users", charset: "utf8mb4", force: :cascade do |t|
    t.string "username"
    t.string "full_name"
    t.string "first_name"
    t.string "last_name"
    t.string "tagline"
    t.string "bio"
    t.string "country"
    t.string "city"
    t.string "password"
    t.string "salt"
    t.boolean "admin"
    t.integer "visibility"
    t.datetime "created_at", precision: 6, null: false
    t.datetime "updated_at", precision: 6, null: false
  end

  add_foreign_key "active_storage_attachments", "active_storage_blobs", column: "blob_id"
  add_foreign_key "active_storage_variant_records", "active_storage_blobs", column: "blob_id"
  add_foreign_key "mail_adresses", "users"
  add_foreign_key "messages", "users"
  add_foreign_key "projects", "licenses"
  add_foreign_key "projects", "users"
  add_foreign_key "resumes", "users"
  add_foreign_key "tags", "projects"
  add_foreign_key "texts", "users"
  add_foreign_key "user_social_links", "social_links"
  add_foreign_key "user_social_links", "users"
end
