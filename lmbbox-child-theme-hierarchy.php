<?php
/*
Plugin Name: LMB^Box Child Theme Hierarchy
Plugin URI: http://lmbbox.com/projects/child-theme-hierarchy/
Description: Allows child themes to use their template files before the parent theme's template files.
Version: 0.6
Author: Thomas Montague
Author URI: http://lmbbox.com/
*/

// BEGIN - Class lmbbox_child_theme_hierarchy_class
class lmbbox_child_theme_hierarchy_class {
	var $__plugin_file = 'lmbbox-child-theme-hierarchy.php';
	var $__plugin_name = 'LMB^Box Child Theme Hierarchy';
	var $__plugin_version = '0.6';
	var $__plugin_author = 'Thomas Montague';
	var $__plugin_title = NULL;

	// Class Constructor
	function __construct() {
		$this->__plugin_title = $this->__plugin_name . ' Version ' . $this->__plugin_version;

		// Add LMB^Box Child Theme Hierarchy Actions
//		add_action('get_header', array(&$this, 'get_header'), 0);
//		add_action('get_footer', array(&$this, 'get_footer'), 0);
//		add_action('get_sidebar', array(&$this, 'get_sidebar'), 0);
		add_action('admin_footer', array(&$this, 'page_templates'));

		// Add LMB^Box Child Theme Hierarchy Filters
		add_filter('404_template', array(&$this, 'template_404'), 0);
		add_filter('archive_template', array(&$this, 'template_archive'), 0);
		add_filter('attachment_template', array(&$this, 'template_attachment'), 0);
		add_filter('author_template', array(&$this, 'template_author'), 0);
		add_filter('category_template', array(&$this, 'template_category'), 0);
		add_filter('comments_template', array(&$this, 'template_comments'), 0);
		add_filter('comments_popup_template', array(&$this, 'template_comments_popup'), 0);
		add_filter('date_template', array(&$this, 'template_date'), 0);
		add_filter('home_template', array(&$this, 'template_home'), 0);
		add_filter('page_template', array(&$this, 'template_page'), 0);
		add_filter('paged_template', array(&$this, 'template_paged'), 0);
		add_filter('search_template', array(&$this, 'template_search'), 0);
		add_filter('single_template', array(&$this, 'template_single'), 0);
	}

	function lmbbox_child_theme_hierarchy_class() {
		$this->__construct();
	}

// index.php

	function get_header() {
		if (TEMPLATEPATH !== STYLESHEETPATH && file_exists(STYLESHEETPATH . '/header.php')) {
			load_template( STYLESHEETPATH . '/header.php');
		} elseif (file_exists( TEMPLATEPATH . '/header.php')) {
			load_template( TEMPLATEPATH . '/header.php');
		} else { load_template( ABSPATH . 'wp-content/themes/default/header.php'); }
	}

	function get_footer() {
		if (TEMPLATEPATH !== STYLESHEETPATH && file_exists(STYLESHEETPATH . '/footer.php')) {
			load_template( STYLESHEETPATH . '/footer.php');
		} elseif (file_exists( TEMPLATEPATH . '/footer.php')) {
			load_template( TEMPLATEPATH . '/footer.php');
		} else { load_template( ABSPATH . 'wp-content/themes/default/footer.php'); }
	}

	function get_sidebar() {
		if (TEMPLATEPATH !== STYLESHEETPATH && file_exists(STYLESHEETPATH . '/sidebar.php')) {
			load_template( STYLESHEETPATH . '/sidebar.php');
		} elseif (file_exists( TEMPLATEPATH . '/sidebar.php')) {
			load_template( TEMPLATEPATH . '/sidebar.php');
		} else { load_template( ABSPATH . 'wp-content/themes/default/sidebar.php'); }
	}

	// Template Filter Functions
	function get_query_template($type, $template) {
		if (TEMPLATEPATH !== STYLESHEETPATH && file_exists(STYLESHEETPATH . "/{$type}.php")) {
			return STYLESHEETPATH . "/{$type}.php";
		} else { return $template; }
	}

	function template_404($template) {
		return $this->get_query_template('404', $template);
	}

	function template_archive($template) {
		return $this->get_query_template('archive', $template);
	}

	function template_attachment($template) {
		global $posts;
		$type = explode('/', $posts[0]->post_mime_type);

		if (TEMPLATEPATH !== STYLESHEETPATH && file_exists(STYLESHEETPATH . "/{$type[0]}.php")) {
			return STYLESHEETPATH . "/{$type[0]}.php";
		} elseif (TEMPLATEPATH !== STYLESHEETPATH && file_exists(STYLESHEETPATH . "/{$type[1]}.php")) {
			return STYLESHEETPATH . "/{$type[1]}.php";
		} elseif (TEMPLATEPATH !== STYLESHEETPATH && file_exists(STYLESHEETPATH . "$type[0]_$type[1]")) {
			return STYLESHEETPATH . "$type[0]_$type[1]";
		} else { return $this->get_query_template('attachment', $template); }
	}

	function template_author($template) {
		return $this->get_query_template('author', $template);
	}

	function template_category($template) {
		if (TEMPLATEPATH !== STYLESHEETPATH && file_exists(STYLESHEETPATH . '/category-' . get_query_var('cat') . '.php')) {
			return STYLESHEETPATH . '/category-' . get_query_var('cat') . '.php';
		} elseif (TEMPLATEPATH !== STYLESHEETPATH && file_exists(STYLESHEETPATH . '/category.php')) {
			return STYLESHEETPATH . '/category.php';
		} else { return $template; }
	}

	function template_comments($template) {
		return $this->get_query_template('comments', $template);
	}

	function template_comments_popup($template) {
		return $this->get_query_template('comments_popup', $template);
	}

	function template_date($template) {
		return $this->get_query_template('date', $template);
	}

	function template_home($template) {
		if (TEMPLATEPATH !== STYLESHEETPATH && file_exists(STYLESHEETPATH . '/home.php')) {
			return STYLESHEETPATH . '/home.php';
		} elseif (TEMPLATEPATH !== STYLESHEETPATH && file_exists(STYLESHEETPATH . '/index.php')) {
			return STYLESHEETPATH . '/index.php';
		} else { return $template; }
	}

	function template_page($template) {
		global $wp_query;

		$id = (int) $wp_query->post->ID;
		$template2 = get_post_meta($id, '_wp_page_template', true);

		if (TEMPLATEPATH !== STYLESHEETPATH && 'default' != $template2 && file_exists(STYLESHEETPATH . "/{$template2}")) {
			return STYLESHEETPATH . "/{$template2}";
		} elseif (TEMPLATEPATH !== STYLESHEETPATH && 'default' == $template2 && file_exists(STYLESHEETPATH . '/page.php')) {
			return STYLESHEETPATH . '/page.php';
		} else { return $template; }
	}

	function template_paged($template) {
		return $this->get_query_template('paged', $template);
	}

	function template_search($template) {
		return $this->get_query_template('search', $template);
	}

	function template_single($template) {
		return $this->get_query_template('single', $template);
	}

	// Update Admin Page Write "Page Templates" Select
	function page_templates() {
		global $post;

		if ($_SERVER['SCRIPT_NAME'] == '/wp-admin/page.php') {
			$page_templates = get_page_templates();
			$template_dir = @dir(STYLESHEETPATH);
			if ($template_dir) {
				while(($file = $template_dir->read()) !== false) {
					if (!preg_match('|^\.+$|', $file) && preg_match('|\.php$|', $file)) {
						$template_data = implode('', file(STYLESHEETPATH . '/' . $file));

						preg_match( '|Template Name:(.*)$|mi', $template_data, $name );
						preg_match( '|Description:(.*)$|mi', $template_data, $description );

						$name = $name[1];
						$description = $description[1];

						if (!empty($name)) { $page_templates[trim($name)] = $file; }
					}
				}
			}

			$page_template_select = "<option value='default'>" . __('Default Template') . '</option>';
			ksort($page_templates);
			foreach (array_keys($page_templates) as $template) {
				$selected = ($post->page_template == $page_templates[$template]) ? " selected='selected'" : '';
				$page_template_select .= "<option value='{$page_templates[$template]}' {$selected}>{$template}</option>";
			}

?>
<!-- BEGIN - <?php echo $this->__plugin_title; ?> //-->
<script type="text/javascript" language="javascript">document.forms["post"].page_template.innerHTML = "<?php echo $page_template_select; ?>";</script>
<!-- END - <?php echo $this->__plugin_title; ?> //-->
<?php

		}
	}
}
// END - Class lmbbox_child_theme_hierarchy_class

// BEGIN - LMB^Box Child Theme Hierarchy Activation Calls
$lmbbox_child_theme_hierarchy = new lmbbox_child_theme_hierarchy_class;
// END - LMB^Box Child Theme Hierarchy Activation Calls

?>
