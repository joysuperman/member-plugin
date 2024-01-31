<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://joymojumder.com/
 * @since      1.0.0
 *
 * @package    Team_Member
 * @subpackage Team_Member/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Team_Member
 * @subpackage Team_Member/admin
 * @author     joySuperman <hi@joymojumder.com>
 */
class Team_Member_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Team_Member_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Team_Member_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/team-member-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Team_Member_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Team_Member_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/team-member-admin.js', array( 'jquery' ), $this->version, false );

	}

	// Member Register Post Type Call Back
	public function register_team_member_post_type(){
		// Define labels
		$labels = array(
			'name' => 'Members',
			'singular_name' => 'Member',
		);

		// Define arguments
		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-groups',
			'supports' => array( 'title', 'editor', 'thumbnail' ),
		);

		// Register post type
		register_post_type('team_member', $args);
	}

	// Register Custom Taxonomy
	public function register_member_type_taxonomy() {
		// Define labels
		$labels = array(
			'name' => 'Member Types',
			'singular_name' => 'Member Type',
		);

		// Define arguments
		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
		);

		// Register taxonomy
		register_taxonomy('member_type', 'team_member', $args);
	}

	// Add custom meta box for position field
	public function add_team_member_position_meta_box() {
		add_meta_box(
			'team_member_position',
			'Position',
			array($this, 'render_team_member_position_meta_box'),
			'team_member',
			'normal',
			'default'
		);
	}

// Render meta box content
	public function render_team_member_position_meta_box($post) {
		$position = get_post_meta($post->ID, 'position', true);
		?>
        <label for="team_member_position">Position:</label>
        <input type="text" id="team_member_position" name="team_member_position" value="<?php echo esc_attr($position); ?>">
		<?php
	}

	// Save meta box data
	public function save_team_member_position_meta_data($post_id) {
		if (array_key_exists('team_member_position', $_POST)) {
			update_post_meta(
				$post_id,
				'position',
				sanitize_text_field($_POST['team_member_position'])
			);
		}
	}

}
