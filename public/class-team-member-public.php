<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://joymojumder.com/
 * @since      1.0.0
 *
 * @package    Team_Member
 * @subpackage Team_Member/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Team_Member
 * @subpackage Team_Member/public
 * @author     joySuperman <hi@joymojumder.com>
 */
class Team_Member_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/team-member-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/team-member-public.js', array( 'jquery' ), $this->version, false );

	}


	// Shortcode: team_members
	public function team_members_shortcode($atts) {
		// Shortcode attributes
		$atts = shortcode_atts(array(
			'count' => -1,
			'image_position' => 'top',
			'show_see_all' => true,
		), $atts);

		// Query team members
		$args = array(
			'post_type' => 'team_member',
			'posts_per_page' => $atts['count'],
		);
		$team_members = new WP_Query($args);

		// Output HTML based on image position
		ob_start();
		if ($team_members->have_posts()) {
			$column_class = 'team-members-grid';
			$column_count = $atts['count'];
			echo '<div class="' . $column_class . '" style="grid-template-columns: repeat(' . $column_count . ', 1fr);">';
			while ($team_members->have_posts()) {
				$team_members->the_post();
				if ($atts['image_position'] === 'top') {
					$this->render_member_with_image_on_top(get_post());
				} else {
					$this->render_member_with_image_on_bottom(get_post());
				}
			}
			echo '</div>';

			// Display "See all" link if true
			if ($atts['show_see_all'] == true) {
				$archive_link = get_post_type_archive_link('team_member');
				echo '<div class="archive-btn"><a href="' . esc_url($archive_link) . '" class="see-all">See all</a></div>';
			}

			// Reset post data
			wp_reset_postdata();
		}
		return ob_get_clean();
	}

	// Render member with image on top
	private function render_member_with_image_on_top($post) {
		$image = get_the_post_thumbnail($post->ID, 'thumbnail');
		$name = get_the_title($post);
		$position = get_post_meta($post->ID, 'position', true);
		$bio = get_the_excerpt($post);
		$permalink = get_permalink($post);

		$html = '<div class="team-member">';
		$html .= '<a href="'. esc_url($permalink) .'" class="team-member-image">' . $image . '</a>';
		$html .= '<div class="team-member-details">';
		$html .= '<a href="'. esc_url($permalink) .'">' . $name . '</a>';
		$html .= '<p>' . $position . '</p>';
		$html .= '</div>';
		$html .= '</div>';

		echo $html;

	}

	// Render member with image on bottom
	private function render_member_with_image_on_bottom($post) {
		$name = get_the_title($post);
		$position = get_post_meta($post->ID, 'position', true);
		$bio = get_the_excerpt($post);
		$image = get_the_post_thumbnail($post->ID, 'thumbnail');
		$permalink = get_permalink($post);

		$html = '<div class="team-member">';
		$html .= '<div class="team-member-details">';
		$html .= '<a href="'. esc_url($permalink) .'">' . $name . '</a>';
		$html .= '<p>' . $position . '</p>';
		$html .= '</div>';
		$html .= '<a href="'. esc_url($permalink) .'" class="team-member-image">' . $image . '</a>';
		$html .= '</div>';

		echo $html;

	}
}
