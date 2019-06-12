http_path = "/" #root level target path
css_dir = "assets/css" #targets our default style.css file at the root level of our theme
sass_dir = "assets/sass" #targets our sass directory
images_dir = "assets/images" #targets our pre existing image directory
javascripts_dir = "assets/js" #targets our JavaScript directory

# You can select your preferred output style here (can be overridden via the command line):
# output_style = :expanded or :nested or :compact or :compressed
output_style = :expanded

# To enable relative paths to assets via compass helper functions.
# note: this is important in wordpress themes for sprites

relative_assets = true

require 'fileutils'
on_stylesheet_saved do |file|
  if File.exists?(file) && File.basename(file) == "style.css"
    puts "Moving: #{file}"
    FileUtils.mv(file, File.dirname(file) + "/../../" + File.basename(file))
  end
end