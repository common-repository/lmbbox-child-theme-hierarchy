=== LMB^Box Child Theme Hierarchy ===
Contributors: lmbbox
Donate link: 
Tags: theme, template, hierarchy
Requires at least: 2.3.2
Tested up to: 2.5
Stable tag: 0.6

Allows child themes to use their template files before the parent theme's template files.

== Description ==

Allows child themes to use their template files before the parent theme's template files.

== Installation ==

1. Upload `lmbbox-child-theme-hierarchy.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. N/A

== Change Log ==

= 0.6 =

Since WordPress 2.5 removed all dbx_* action hooks, had to move action hook to admin_footer for page_templates function. Modified page_templates function to only output is $_SERVER['SCRIPT_NAME'] == '/wp-admin/page.php'.

= 0.5 =

Worked on adding header.php, footer.php and sidebar.php mapping.

= 0.2 =

Inital Version
