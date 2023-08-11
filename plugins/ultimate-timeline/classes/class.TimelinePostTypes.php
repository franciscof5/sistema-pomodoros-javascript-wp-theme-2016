<?php 

/**
 * Register Custom Post Type
 * new PostTypes( 'post_type', array(), array('plural_name' => 'PluralName') );
 */
class TimelinePostTypes {

	public $type;
	public $options = array();
	public $labels = array();

	/**
	 * To Register a custom post type
	 * @param string $type    Name for fustom post type // Must Be lowercase
	 * @param array  $options [Array of options to register a custom post type]
	 * @param array  $labels  [Array of labels to be used for custom post type]
	 */
	function __construct( $type, $options = array(), $labels = array() ) {
		$this->type = $type;


		$default_options = array(
				'public'             => false,
			    'publicly_queryable' => false,
			    'show_ui'            => true,
			    'show_in_menu'       => true,
			    'query_var'          => false,
			    'rewrite'            => false,
			    'capability_type'    => 'post',
			    'has_archive'        => true,
			    'hierarchical'       => false,
			    'menu_position'      => null,
			    'supports'           => array( 'title'),
			    'menu_icon'		 => 'dashicons-list-view'
			);

		$required_labels = array(
				'singular_name'      => ucfirst($this->type),
				'plural_name'        => ucfirst($this->type),
			);

		


		$this->options = $options + $default_options;
		$this->labels = $labels + $required_labels;

		$this->options['labels'] = $this->labels + $this->default_labels();

		$this->register();
		return;
	}

	public function register() {
		register_post_type($this->type, $this->options);
	}

	public function default_labels() {
		return array(
		    'name'               => $this->labels['plural_name'],
		    'singular_name'      => $this->labels['singular_name'],
		    'add_new'            => 'Add New ' . $this->labels['singular_name'],
		    'add_new_item'       => 'Add New ' . $this->labels['singular_name'],
		    'edit_item'          => 'Edit ' . $this->labels['singular_name'],
		    'new_item'           => 'New ' . $this->labels['singular_name'],
		    'all_items'          => 'All ' . $this->labels['plural_name'],
		    'view_item'          => 'View ' . $this->labels['singular_name'],
		    'search_items'       => 'Search ' . $this->labels['plural_name'],
		    'not_found'          => 'No ' . strtolower($this->labels['singular_name']) . ' found',
		    'not_found_in_trash' => 'No ' . strtolower($this->labels['singular_name']) . ' found in Trash',
		    'parent_item_colon'  => '',
		    'menu_name'          => $this->labels['plural_name']
		  );
	}
}