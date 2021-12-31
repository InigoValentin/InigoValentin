# This file should contain all the record creation needed to seed the database with its default values.
# The data can then be loaded with the bin/rails db:seed command (or created alongside the database with db:setup).
#
# Examples:
#
#   movies = Movie.create([{ name: 'Star Wars' }, { name: 'Lord of the Rings' }])
#   Character.create(name: 'Luke', movie: movies.first)

license = License.new(id: 1, name: "GPLv3", url: "https://www.gnu.org/licenses/gpl-3.0.en.html")
license.save
license.logo.attach(io: File.open("custom_data/attachments/license/1/logo/1.svg"), filename: 'GPLv3.svg')
license.save

#tag = Tag.new(project_id: 1, tag: "tag.js")
#tag.save
#tag = Tag.new(project_id: 1, tag: "tag.html5")
#tag.save
#tag = Tag.new(project_id: 2, tag: "tag.html5")
#tag.save
#tag = Tag.new(project_id: 2, tag: "tag.js")
#tag.save
#tag = Tag.new(project_id: 2, tag: "tag.css3")
#tag.save
#tag = Tag.new(project_id: 2, tag: "tag.android")
#tag.save
#tag = Tag.new(project_id: 2, tag: "tag.ios")
#tag.save
#tag = Tag.new(project_id: 2, tag: "tag.java")
#tag.save
#tag = Tag.new(project_id: 2, tag: "tag.swift")
#tag.save
#tag = Tag.new(project_id: 2, tag: "tag.php")
#tag.save
#tag = Tag.new(project_id: 3, tag: "tag.ruby")
#tag.save
#tag = Tag.new(project_id: 3, tag: "tag.rails")
#tag.save
#tag = Tag.new(project_id: 3, tag: "tag.mysql")
#tag.save
#tag = Tag.new(project_id: 3, tag: "tag.html5")
#tag.save
#tag = Tag.new(project_id: 3, tag: "tag.js")
#tag.save
#tag = Tag.new(project_id: 4, tag: "tag.html5")
#tag.save
#tag = Tag.new(project_id: 4, tag: "tag.css3")
#tag.save
#tag = Tag.new(project_id: 4, tag: "tag.js")
#tag.save
#tag = Tag.new(project_id: 4, tag: "tag.php")
#tag.save
#tag = Tag.new(project_id: 4, tag: "tag.sqlite")
#tag.save

technology = Technology.new(id: 1, name: "PHP", nature: "1")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/1/logo/1.png"), filename: 'php.png')
technology.save
technology = Technology.new(id: 2, name: "JavaScript", nature: "1")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/2/logo/1.png"), filename: 'javascript.png')
technology.save
technology = Technology.new(id: 3, name: "Java", nature: "1")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/3/logo/1.png"), filename: 'java.png')
technology.save
technology = Technology.new(id: 4, name: "Swift", nature: "1")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/4/logo/1.png"), filename: 'swift.png')
technology.save
technology = Technology.new(id: 5, name: "Ruby", nature: "1")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/5/logo/1.png"), filename: 'ruby.png')
technology.save
technology = Technology.new(id: 6, name: "Python", nature: "1")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/6/logo/1.png"), filename: 'python.png')
technology.save
technology = Technology.new(id: 7, name: "C", nature: "1")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/7/logo/1.png"), filename: 'c.png')
technology.save
technology = Technology.new(id: 8, name: "C++", nature: "1")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/8/logo/1.png"), filename: 'cpp.png')
technology.save
technology = Technology.new(id: 9, name: "Bash", nature: "1")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/9/logo/1.png"), filename: 'bash.png')
technology.save
technology = Technology.new(id: 10, name: "Powershell", nature: "1")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/10/logo/1.png"), filename: 'powershell.png')
technology.save
technology = Technology.new(id: 11, name: "Rails", nature: "2")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/11/logo/1.png"), filename: 'rails.png')
technology.save
technology = Technology.new(id: 12, name: "MySQL", nature: "3")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/12/logo/1.png"), filename: 'mysql.png')
technology.save
technology = Technology.new(id: 13, name: "SQLite", nature: "3")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/13/logo/1.png"), filename: 'sqlite.png')
technology.save
technology = Technology.new(id: 14, name: "Oracle Database", nature: "3")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/14/logo/1.png"), filename: 'oracledb.png')
technology.save
technology = Technology.new(id: 15, name: "HTML5", nature: "4")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/15/logo/1.png"), filename: 'html5.png')
technology.save
technology = Technology.new(id: 16, name: "CSS3", nature: "4")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/16/logo/1.png"), filename: 'css3.png')
technology.save
technology = Technology.new(id: 17, name: "GNU/Linux", nature: "5")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/17/logo/1.png"), filename: 'gnulinux.png')
technology.save
technology = Technology.new(id: 18, name: "MS Windows", nature: "5")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/18/logo/1.png"), filename: 'windows.png')
technology.save
technology = Technology.new(id: 19, name: "Android", nature: "5")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/19/logo/1.png"), filename: 'android.png')
technology.save
technology = Technology.new(id: 20, name: "iOS", nature: "5")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/20/logo/1.png"), filename: 'ios.png')
technology.save
technology = Technology.new(id: 21, name: "GIT", nature: "6")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/21/logo/1.png"), filename: 'git.png')
technology.save
technology = Technology.new(id: 22, name: "Apache", nature: "6")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/22/logo/1.png"), filename: 'apache.png')
technology.save
technology = Technology.new(id: 23, name: "Maven", nature: "6")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/23/logo/1.png"), filename: 'maven.png')
technology.save
technology = Technology.new(id: 24, name: "WebLogic", nature: "6")
technology.save
technology.logo.attach(io: File.open("custom_data/attachments/technology/24/logo/1.png"), filename: 'weblogic.png')
technology.save

target = UrlTarget.new(id: 1, name: "urltarget.1.name", summary: "urltarget.1.summary")
target.save
target.logo.attach(io: File.open("custom_data/attachments/urlTarget/1/logo/1.svg"), filename: 'website.svg')
target.save
target = UrlTarget.new(id: 2, name: "urltarget.2.name", summary: "urltarget.2.summary")
target.save
target.logo.attach(io: File.open("custom_data/attachments/urlTarget/2/logo/1.svg"), filename: 'github.svg')
target.save
target = UrlTarget.new(id: 3, name: "urltarget.3.name", summary: "urltarget.3.summary")
target.save
target.logo.attach(io: File.open("custom_data/attachments/urlTarget/3/logo/1.svg"), filename: 'googleplay.svg')
target.save
target = UrlTarget.new(id: 4, name: "urltarget.4.name", summary: "urltarget.4.summary")
target.save
target.logo.attach(io: File.open("custom_data/attachments/urlTarget/4/logo/1.svg"), filename: 'appstore.svg')
target.save

text = Text.new(user_id: nil, key: "urltarget.1.name", language: "es", text: "Sitio web")
text.save
text = Text.new(user_id: nil, key: "urltarget.1.name", language: "en", text: "Website")
text.save
text = Text.new(user_id: nil, key: "urltarget.1.name", language: "eu", text: "Web horria")
text.save
text = Text.new(user_id: nil, key: "urltarget.1.summary", language: "es", text: "Ir al sitio web.")
text.save
text = Text.new(user_id: nil, key: "urltarget.1.summary", language: "en", text: "Go to website.")
text.save
text = Text.new(user_id: nil, key: "urltarget.1.summary", language: "eu", text: "Web horria.")
text.save
text = Text.new(user_id: nil, key: "urltarget.2.name", language: "es", text: "Github")
text.save
text = Text.new(user_id: nil, key: "urltarget.2.name", language: "en", text: "Github")
text.save
text = Text.new(user_id: nil, key: "urltarget.2.name", language: "eu", text: "Github")
text.save
text = Text.new(user_id: nil, key: "urltarget.2.summary", language: "es", text: "Ver el código fuente en Github.")
text.save
text = Text.new(user_id: nil, key: "urltarget.2.summary", language: "en", text: "Checkout source code on Github.")
text.save
text = Text.new(user_id: nil, key: "urltarget.2.summary", language: "eu", text: "Kodea Github-n.")
text.save
text = Text.new(user_id: nil, key: "urltarget.3.name", language: "es", text: "Google Play")
text.save
text = Text.new(user_id: nil, key: "urltarget.3.name", language: "en", text: "Google Play")
text.save
text = Text.new(user_id: nil, key: "urltarget.3.name", language: "eu", text: "Google Play")
text.save
text = Text.new(user_id: nil, key: "urltarget.3.summary", language: "es", text: "Ver app en Google Play.")
text.save
text = Text.new(user_id: nil, key: "urltarget.3.summary", language: "en", text: "See on Google Play.")
text.save
text = Text.new(user_id: nil, key: "urltarget.3.summary", language: "eu", text: "Google Play-n.")
text.save
text = Text.new(user_id: nil, key: "urltarget.4.name", language: "es", text: "App Store")
text.save
text = Text.new(user_id: nil, key: "urltarget.4.name", language: "en", text: "App Store")
text.save
text = Text.new(user_id: nil, key: "urltarget.4.name", language: "eu", text: "App Store")
text.save
text = Text.new(user_id: nil, key: "urltarget.4.summary", language: "es", text: "Ver app en App Store.")
text.save
text = Text.new(user_id: nil, key: "urltarget.4.summary", language: "en", text: "See on Google Play.")
text.save
text = Text.new(user_id: nil, key: "urltarget.4.summary", language: "eu", text: "Google App Store-n.")
text.save

text = Text.new(user_id: nil, key: "sociallink.2.title", language: "es", text: "Ir a mi perfil en Github")
text.save
text = Text.new(user_id: nil, key: "sociallink.2.title", language: "en", text: "Check out my Github profile")
text.save
text = Text.new(user_id: nil, key: "sociallink.2.title", language: "eu", text: "Ir a mi perfil en Github")
text.save
text = Text.new(user_id: nil, key: "sociallink.3.title", language: "es", text: "Escríbeme por Telegram")
text.save
text = Text.new(user_id: nil, key: "sociallink.3.title", language: "en", text: "Drop me a line over Telegram")
text.save
text = Text.new(user_id: nil, key: "sociallink.3.title", language: "eu", text: "Escríbeme por Telegram")
text.save
text = Text.new(user_id: nil, key: "sociallink.4.title", language: "es", text: "Ver mi perfil en LinkedIn")
text.save
text = Text.new(user_id: nil, key: "sociallink.4.title", language: "en", text: "See my LinkedIn profile")
text.save
text = Text.new(user_id: nil, key: "sociallink.4.title", language: "eu", text: "Ver mi perfil en LinkedIn")
text.save
text = Text.new(user_id: nil, key: "sociallink.5.title", language: "es", text: "Ver mi perfil en Facebook")
text.save
text = Text.new(user_id: nil, key: "sociallink.5.title", language: "en", text: "See my Facebook profile")
text.save
text = Text.new(user_id: nil, key: "sociallink.5.title", language: "eu", text: "Ver mi perfil en Facebook")
text.save
text = Text.new(user_id: nil, key: "sociallink.6.title", language: "es", text: "Ver mi perfil en Twitter")
text.save
text = Text.new(user_id: nil, key: "sociallink.6.title", language: "en", text: "See my Twitter profile")
text.save
text = Text.new(user_id: nil, key: "sociallink.6.title", language: "eu", text: "Ver mi perfil en Twitter")
text.save

slink = SocialLink.new(id: 1, site_name: "eMail", pattern: "mailto:*", regexp: "^\S+@\S+\.\S+$", link_title: "sociallink.1.title")
slink.save
slink.logo.attach(io: File.open("custom_data/attachments/socialLink/1/logo/1.svg"), filename: 'email.svg')
slink.save
slink = SocialLink.new(id: 2, site_name: "Github", pattern: "https://github.com/*", regexp: "^.+$", link_title: "sociallink.2.title")
slink.save
slink.logo.attach(io: File.open("custom_data/attachments/socialLink/2/logo/1.svg"), filename: 'github.svg')
slink.save
slink = SocialLink.new(id: 3, site_name: "Telegram", pattern: "https://t.me/*", regexp: "^.+$", link_title: "sociallink.3.title")
slink.save
slink.logo.attach(io: File.open("custom_data/attachments/socialLink/3/logo/1.svg"), filename: 'telegram.svg')
slink.save
slink = SocialLink.new(id: 4, site_name: "LinkedIn", pattern: "https://www.linkedin.com/in/*", regexp: "^.+$", link_title: "sociallink.4.title")
slink.save
slink.logo.attach(io: File.open("custom_data/attachments/socialLink/4/logo/1.svg"), filename: 'linkedin.svg')
slink.save
slink = SocialLink.new(id: 5, site_name: "Facebook", pattern: "https://facebook.com/*", regexp: "^.+$", link_title: "sociallink.5.title")
slink.save
slink.logo.attach(io: File.open("custom_data/attachments/socialLink/5/logo/1.svg"), filename: 'facebook.svg')
slink.save
slink = SocialLink.new(id: 6, site_name: "Twitter", pattern: "https://twitter.com/*", regexp: "^.+$", link_title: "sociallink.6.title")
slink.save
slink.logo.attach(io: File.open("custom_data/attachments/socialLink/6/logo/1.svg"), filename: 'twitter.svg')
slink.save