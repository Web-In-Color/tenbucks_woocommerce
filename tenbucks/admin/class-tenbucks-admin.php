<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.tenbucks.io
 * @since      1.0.0
 *
 * @package    Tenbucks
 * @subpackage Tenbucks/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tenbucks
 * @subpackage Tenbucks/admin
 * @author     Your Name <email@example.com>
 */
class Tenbucks_Admin {

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
		 * defined in Tenbucks_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tenbucks_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tenbucks-admin.css', array(), $this->version, 'all' );

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
		 * defined in Tenbucks_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tenbucks_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tenbucks-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add Tenbucks admin menu
	 *
	 * @since    1.0.0
	 */
	public function admin_menu()
	{
		$page = add_menu_page('tenbucks', 'tenbucks', 'manage_woocommerce', 'tenbucks', array($this, 'get_content'), $this->get_asset_path('logo.png'), 58.42);
		add_action('admin_print_styles-' . $page, array($this, 'enqueue_styles'));
		add_action('admin_print_scripts-' . $page, array($this, 'enqueue_scripts'));
	}

	/**
	 * Get admin menu content
	 *
	 * @since 1.0.0
	 */
	public function get_content()
	{
		// First check if WooCommerce is active...
		if (!is_plugin_active( 'woocommerce/woocommerce.php' )) {
			return print('<h2 class="clear">'.__('Please install WooCommerce before using this plugin.', 'wic-bridge').'</h2>');
		}

		$wc_data = get_plugin_data(WP_PLUGIN_DIR.'/woocommerce/woocommerce.php');

		if (version_compare ( $wc_data['Version'] , '2.4.0', '<')) {
			return print('<h2 class="clear">'.__('Please update your WooCommerce plugin before using this plugin.', 'wic-bridge').'</h2>');
		}

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wic-server.php';
		$is_ssl = is_ssl();
		$shop_url = get_site_url();
		$display_iframe = false;
		$api_doc_link = sprintf('<a href="%s" target="_blank">%s</a>', 'http://docs.woothemes.com/document/woocommerce-rest-api/', __('See how', 'wic-bridge'));
		$is_api_active = get_option('woocommerce_api_enabled') === 'yes';
		$lang_infos = explode('-', get_bloginfo('language'));
		$query = array(
			'url' => $shop_url,
			'timestamp' => (int)microtime(true),
			'platform' => 'WooCommerce',
			'email' => get_bloginfo('admin_email'),
			'username' => get_bloginfo('name'),
			'locale' => $lang_infos[0],
			'country' => $lang_infos[1],
		);

		if (!$is_ssl)
		{
			$ssl_message = __('You\'re not using SSL. For safety reasons, our iframe use <strong>https protocol</strong> to secure every transactions', 'wic-bridge');
			$pp_url = 'http://store.webincolor.fr/conditions-generales-de-ventes';
			$pp_link = sprintf('<a href="%s" target="_blank">%s</a>', $pp_url, __('More informations about our privacy policy', 'wic-bridge'));
			$this->add_notice($ssl_message.'. '.$pp_link.'.', 'info');
		}

		// If API is disabled.
		if (!$is_api_active) {
			$this->add_notice(__('WooCommerce API is not enabled. Please activate it and create an API read/write access before using this plugin.', 'wic-bridge').' '.$api_doc_link, 'error');
		} else {
			$api_details = array();
			preg_match('/\/wc-api\/v(\d)\/$/',  get_woocommerce_api_url('/'), $api_details);
			$api_url = $api_details[0];
			$api_version = (int)$api_details[1];

			if ($api_version > 1) {
				$query['api_version'] = $api_version;
				$display_iframe = true;
				$standalone_url = WIC_Server::getUrl('/', $query, true);
				$iframe_url = WIC_Server::getUrl('/', $query);

				if (get_option('wic_show_fcn')) {
					$message = __('On your first connexion, you\'ll have to set your credential for API access. Please create a <strong>Read/Write</strong> access in order to use our apps. <a href="#" id="wic_update_fcn">Do not show this again</a>', 'wic-bridge');
					$this->add_notice($message, 'info');
				}
			} else {
				$this->add_notice(__('Your WooCommerce version is obsolete, please update it before using this plugin.', 'wic-bridge'), 'error');
			}
		}

		// Debug Mod prevent JSON responses to be correctly parsed
		if (WP_DEBUG)
		{
			$message = __('WP_DEBUG is active. This can prevent our WooCommerce responses to be parsed correctly and cause malfunctioning.', 'wic-bridge');
			$this->add_notice($message, 'error');
		}

		require_once plugin_dir_path( dirname( __FILE__ ) ). 'admin/partials/tenbucks-admin-display.php';
	}

	/**
	 * Add a notification to admin page
	 *
	 * @param string $message message to show
	 * @param string $type type of notice (alert, success, ...)
	 */
	private function add_notice($message, $type)
	{
		$this->notice[] = array(
			'message' => $message,
			'type' => $type
		);
	}

	/**
	 * Get the path to an asset
	 *
	 * @param string $filename file to add
	 * @return string url of the file
	 * @throws Exception
	 */
	public function get_asset_path($filename)
	{
		$extension = substr($filename, -3);
		$asset_dir = plugin_dir_path( dirname( __FILE__ ) ).'/admin';

		switch ($extension)
		{
			case '.js':
				$dirname = 'js';
				break;

			case 'css':
				$dirname = 'css';
				break;

			case 'jpg':
			case 'png':
			case 'gif':
			case 'svg':
				$dirname = 'img';
				break;

			default :
				throw new Exception('Unknow file extension');
		}

		return plugin_dir_url(__FILE__).$dirname.'/'.$filename;
	}

	public function post_process()
	{
		if (isset($_POST['wic_hide_fcn'])) {
			update_option('wic_show_fcn', false);
			wp_die(json_encode(array(
				'success' => true,
				'message' => __('Settings updated', 'wic-bridge')
			)));
		}
	}
}
