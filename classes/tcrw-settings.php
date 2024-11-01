<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'tcrw_Settings' ) ) {

	/**
	 * Handles plugin settings and user profile meta fields
	 */
	class tcrw_Settings extends tcrw_Module {
		protected $settings;
		protected static $default_settings;
		protected static $readable_properties  = array( 'settings' );
		protected static $writeable_properties = array( 'settings' );

		const REQUIRED_CAPABILITY = 'administrator';


		/*
		 * General methods
		 */

		/**
		 * Constructor
		 *
		 * @mvc Controller
		 */
		protected function __construct() {
			$this->register_hook_callbacks();
			self::manage_requests();
		}

		/**
		 * Public setter for protected variables
		 *
		 * Updates settings outside of the Settings API or other subsystems
		 *
		 * @mvc Controller
		 *
		 * @param string $variable
		 * @param array  $value This will be merged with tcrw_Settings->settings, so it should mimic the structure of the tcrw_Settings::$default_settings. It only needs the contain the values that will change, though. See tc_ricaricaweb->upgrade() for an example.
		 */
		public function __set( $variable, $value ) {

			if ( $variable != 'settings' ) {
				return;
			}

			$this->settings = self::validate_settings( $value );
			update_option( 'tcrw_settings', $this->settings );
		}

		/**
		 * Register callbacks for actions and filters
		 *
		 * @mvc Controller
		 */
		public function register_hook_callbacks() {
			add_action( 'admin_menu',               __CLASS__ . '::register_settings_pages' );
//			add_action( 'show_user_profile',        __CLASS__ . '::add_user_fields' );
//			add_action( 'edit_user_profile',        __CLASS__ . '::add_user_fields' );
//			add_action( 'personal_options_update',  __CLASS__ . '::save_user_fields' );
//			add_action( 'edit_user_profile_update', __CLASS__ . '::save_user_fields' );

			add_action( 'init',                     array( $this, 'init' ) );
			add_action( 'admin_init',               array( $this, 'register_settings' ) );

/*
			add_filter(
				'plugin_action_links_' . plugin_basename( dirname( __DIR__ ) ) . '/bootstrap.php',
				__CLASS__ . '::add_plugin_action_links'
			);
*/

//			add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), 'tcrw_Settings::add_plugin_action_links' );
			add_filter( 'plugin_action_links_tc_ricaricaweb/tcrw_ricaricaweb.php', 'tcrw_Settings::add_plugin_action_links' );

		}

		/**
		 * Prepares site to use the plugin during activation
		 *
		 * @mvc Controller
		 *
		 * @param bool $network_wide
		 */
		public function activate( $network_wide ) {

			global $wpdb;
			$sql = file_get_contents(plugin_dir_path( __FILE__ )."setup/install.sql");
			if ($wpdb->query($sql)===false) {
				add_notice( 'Unable to create the database table, please, try installing it manually from <strong>/classes/setup/install.sql</strong> file.', 'error' );
			}

		}

		/**
		 * Rolls back activation procedures when de-activating the plugin
		 *
		 * @mvc Controller
		 */
		public function deactivate() {

/*
			global $wpdb;
			$sql = file_get_contents("uninstall.sql");
			if (!$wpdb->query($sql)) {
				add_notice( 'Unable to delete the database table, please, try uninstalling it manually from <strong>uninstall.sql</strong> file.', 'error' );
			}
*/

		}

		/**
		 * Initializes variables
		 *
		 * @mvc Controller
		 */
		public function init() {
			self::$default_settings = self::get_default_settings();
			$this->settings         = self::get_settings();
		}

		/**
		 * Executes the logic of upgrading from specific older versions of the plugin to the current version
		 *
		 * @mvc Model
		 *
		 * @param string $db_version
		 */
		public function upgrade( $db_version = 0 ) {
			/*
			if( version_compare( $db_version, 'x.y.z', '<' ) )
			{
				// Do stuff
			}
			*/
		}

		/**
		 * Checks that the object is in a correct state
		 *
		 * @mvc Model
		 *
		 * @param string $property An individual property to check, or 'all' to check all of them
		 * @return bool
		 */
		protected function is_valid( $property = 'all' ) {
			// Note: __set() calls validate_settings(), so settings are never invalid

			return true;
		}


		/*
		 * Plugin Settings
		 */

		/**
		 * Establishes initial values for all settings
		 *
		 * @mvc Model
		 *
		 * @return array
		 */
		protected static function get_default_settings() {

			$basic = array(
				//'tc_merchant' => '',
				'tc_merchant_email' => ''
			);

			$advanced = array(
				'tc_debug' => '0',
				'tc_URL' => 'https://secure.tcserver.it/cgi-bin/ppage_nd.cgi'
			);

			$instances_settings = array(
				'tc_country' => '39',
				'tc_lng' => 'ITA',
				'tc_disable_paypal' => 0,
			);

			return array(
				'db-version' => '0',
				'basic'      => $basic,
				'advanced'   => $advanced,
				'instances'    => array("tc_instances" => ""),
				'translations'    => array("tc_translations" => ""),
				'instances_settings'    => $instances_settings
			);

		}

		/**
		 * Retrieves all of the settings from the database
		 *
		 * @mvc Model
		 *
		 * @return array
		 */
		protected static function get_settings() {
			$settings = shortcode_atts(
				self::$default_settings,
				get_option( 'tcrw_settings', array() )
			);

			return $settings;
		}

		/**
		 * Adds links to the plugin's action link section on the Plugins page
		 *
		 * @mvc Model
		 *
		 * @param array $links The links currently mapped to the plugin
		 * @return array
		 */
		public static function add_plugin_action_links( $links ) {
			$newlinks = array(
				'<a href="http://www.telecash.it/plugins/wordpress/ricaricaweb/faq/">Help</a>',
				'<a href="options-general.php?page=telecash">Settings</a>'
			);
			return array_merge($links,$newlinks);
		}

		/**
		 * Adds pages to the Admin Panel menu
		 *
		 * @mvc Controller
		 */
		public static function register_settings_pages() {
			add_menu_page(
				"Telecash Ricaricaweb",
				"Telecash",
				self::REQUIRED_CAPABILITY,
				'telecash',
				__CLASS__ . '::markup_settings_page',
				''
			);
/*
			add_submenu_page(
//				'options-general.php',
				'telecash',
				tcrw_NAME,
				tcrw_NAME,
				self::REQUIRED_CAPABILITY,
				'tcrw_settings',
				__CLASS__ . '::markup_settings_page'
			);
*/
		}

		/**
		 * Creates the markup for the Settings page
		 *
		 * @mvc Controller
		 */
		public static function markup_settings_page() {
			if ( current_user_can( self::REQUIRED_CAPABILITY ) ) {
				echo self::render_template( 'tcrw-settings/page-settings.php' );
			} else {
				wp_die( 'Access denied.' );
			}
		}

		/**
		 * Registers settings sections, fields and settings
		 *
		 * @mvc Controller
		 */
		public function register_settings() {


			/*
			 * Basic Section
			 */
			add_settings_section(
				'tcrw_section-basic',
				'Basic Settings',
				__CLASS__ . '::markup_section_headers',
				'tcrw_settings'
			);

/*
			add_settings_field(
				'tc_merchant',
				'Your Telecash Merchant ID',
				array( $this, 'markup_fields' ),
				'tcrw_settings',
				'tcrw_section-basic',
				array( 'label_for' => 'tc_merchant' )
			);
*/
			add_settings_field(
				'tc_merchant_email',
				'Your email address for notifications',
				array( $this, 'markup_fields' ),
				'tcrw_settings',
				'tcrw_section-basic',
				array( 'label_for' => 'tc_merchant_email' )
			);


			/*
			 * Advanced Section
			 */
			add_settings_section(
				'tcrw_section-advanced',
				'Advanced Settings',
				__CLASS__ . '::markup_section_headers',
				'tcrw_settings'
			);

			add_settings_field(
				'tc_URL',
				'Telecash payment gateway URL',
				array( $this, 'markup_fields' ),
				'tcrw_settings',
				'tcrw_section-advanced',
				array( 'label_for' => 'tc_URL' )
			);

			add_settings_field(
				'tc_debug',
				'Enable debug mode',
				array( $this, 'markup_fields' ),
				'tcrw_settings',
				'tcrw_section-advanced',
				array( 'label_for' => 'tc_debug' )
			);


			add_settings_section(
				'tcrw_section-instances',
				'Instances of Ricaricaweb',
				__CLASS__ . '::markup_section_headers',
				'tcrw_settings-2'
			);

			add_settings_section(
				'tcrw_section-translations',
				'Translations of Ricaricaweb strings',
				__CLASS__ . '::markup_section_headers',
				'tcrw_settings-3'
			);

			add_settings_field(
				'tc_instances',
				'',
				array( $this, 'markup_fields' ),
				'tcrw_settings-2',
				'tcrw_section-instances',
				array( 'label_for' => 'tc_instances', 'class' => 'notitle' )
			);

			add_settings_field(
				'tc_translations',
				'',
				array( $this, 'markup_fields' ),
				'tcrw_settings-3',
				'tcrw_section-translations',
				array( 'label_for' => 'tc_translations', 'class' => 'notitle' )
			);

			// The settings container
			register_setting(
				'tcrw_settings',
				'tcrw_settings',
				array( $this, 'validate_settings' )
			);
			register_setting(
				'tcrw_settings-2',
				'tcrw_settings',
				array( $this, 'validate_settings' )
			);
			register_setting(
				'tcrw_settings-3',
				'tcrw_settings',
				array( $this, 'validate_settings' )
			);
		}

		/**
		 * Adds the section introduction text to the Settings page
		 *
		 * @mvc Controller
		 *
		 * @param array $section
		 */
		public static function markup_section_headers( $section ) {
			echo self::render_template( 'tcrw-settings/page-settings-section-headers.php', array( 'section' => $section ), 'always' );
		}

		/**
		 * Delivers the markup for settings fields
		 *
		 * @mvc Controller
		 *
		 * @param array $field
		 */
		public function markup_fields( $field ) {
			echo self::render_template( 'tcrw-settings/page-settings-fields.php', array( 'settings' => $this->settings, 'field' => $field ), 'always' );
		}

		/**
		 * Validates submitted setting values before they get saved to the database. Invalid data will be overwritten with defaults.
		 *
		 * @mvc Model
		 *
		 * @param array $new_settings
		 * @return array
		 */
		public function validate_settings( $new_settings ) {

			$new_settings = shortcode_atts( $this->settings, $new_settings );
			array_walk($new_settings, "sanitize_text_field");

			if ( ! is_string( $new_settings['db-version'] ) ) {
				$new_settings['db-version'] = tcrw_ricaricaweb::VERSION;
			}

			if ($new_settings['advanced']['tc_URL']=="")
				$new_settings['advanced']['tc_URL'] = self::$default_settings['advanced']['tc_URL'];

			if (sanitize_text_field($_REQUEST['tcrw_settings']['advanced']['tc_debug'])=="1")
				$new_settings['advanced']['tc_debug']=1;
			else
				$new_settings['advanced']['tc_debug']=0;

			$instances = $_REQUEST['tcrw_settings']['instances'];
			foreach ($instances as $k => $instance) {
				if ($instance["tc_usetcjs"]=="on")
					$instances[$k]["tc_usetcjs"]="1";
				else
					$instances[$k]["tc_usetcjs"]="0";
				if ($instance["tc_set_phone_credit"]=="on")
					$instances[$k]["tc_set_phone_credit"]="1";
				else
					$instances[$k]["tc_set_phone_credit"]="0";
				if ($instance["tc_require_customer_email"]=="on")
					$instances[$k]["tc_require_customer_email"]="1";
				else
					$instances[$k]["tc_require_customer_email"]="0";
				if ($instance["tc_doublenum"]=="on")
					$instances[$k]["tc_doublenum"]="1";
				else
					$instances[$k]["tc_doublenum"]="0";

				if (!in_array($instance["tc_lng"],array("ITA","FRA","ENG","SPA","DEU")))
					$instances[$k]["tc_lng"]="ITA";
				if (!in_array($instance["tc_disable_paypal"],array("0","1","2")))
					$instance["tc_disable_paypal"]="0";
				if (!in_array($instance["tc_set_order_detail"],array("0","1","2","3")))
					$instance["tc_set_order_detail"]="0";

				if (!in_array($instance["tc_form_layout"],array("0","1","2","3","4","5","6","7","8","9","19","11","12")))
					$instance["tc_form_layout"]="3";

				if ($instance["tc_merchant"]=="")
					unset($instances[$k]);
			}

			if (count($instances)>0)
				$new_settings['instances'] = $instances;

			$translations = $_REQUEST['tcrw_settings']['translations'];
			array_walk_recursive($translations, "sanitize_text_field");

			if (count($translations)>0)
				$new_settings['translations'] = $translations;

			return $new_settings;

		}


		/**
		* Mange all plugin actions and requests
		*
		* @mvc Controller
		*
		*/
		public function manage_requests() {

//			if ($_REQUEST["add_tc_alias"]!=""&&$_REQUEST["add_tc_merchant"]!="") {
			if ($_REQUEST["add_tc_merchant"]!="") {

				$tc_country = (sanitize_text_field($_REQUEST["add_tc_country"])!="")?sanitize_text_field($_REQUEST["add_tc_country"]):"39";
				$tc_lng = (in_array($_REQUEST["add_tc_lng"],array("ITA","FRA","ENG","SPA","DEU")))?$_REQUEST["add_tc_lng"]:"ITA";
				$tc_disable_paypal = (in_array($_REQUEST["add_tc_disable_paypal"],array("0","1","2")))?$_REQUEST["add_tc_disable_paypal"]:"0";
				$tc_usetcjs = ($_REQUEST["add_tc_usetcjs"]=="1")?"1":"0";
				$tc_doublenum = ($_REQUEST["add_tc_doublenum"]=="1")?"1":"0";
				$tc_set_phone_credit = ($_REQUEST["add_tc_set_phone_credit"]=="1")?"1":"0";
				$tc_require_customer_email = ($_REQUEST["tc_require_customer_email"]=="1")?"1":"0";
				$add_tc_set_order_detail = (in_array($_REQUEST["add_tc_set_order_detail"],array("0","1","2","3")))?$_REQUEST["add_tc_set_order_detail"]:"";
				$curropts = get_option("tcrw_settings");
				$ikey = md5(sanitize_text_field($_REQUEST["add_tc_merchant"]).sanitize_text_field($_REQUEST["add_tc_alias"]).time());
				$tc_coupon_enable = ($_REQUEST["add_tc_coupon_enable"]=="1")?"1":"0";
				$tc_coupon_enable_default = ($_REQUEST["add_tc_coupon_enable_default"]=="1")?"1":"0";
				$tc_coupon_default = sanitize_text_field($_REQUEST["add_tc_coupon_default"]);
				$tc_coupon_default_hidden = ($_REQUEST["add_tc_coupon_default_hidden"]=="1")?"1":"0";
				$tc_form_layout = (in_array($_REQUEST["add_tc_form_layout"],array("0","1","2","3","4","5","6","7","8","9","10","11","12")))?$_REQUEST["add_tc_form_layout"]:"";
				//$curropts['instances']['tc_instances'][$ikey] = array(
				$curropts['instances'][$ikey] = array(
					"tc_merchant" => sanitize_text_field($_REQUEST["add_tc_merchant"]),
					"tc_alias" => sanitize_text_field($_REQUEST["add_tc_alias"]),
					"tc_country" => $tc_country,
					"tc_lng" => $tc_lng,
					"tc_disable_paypal" => $tc_disable_paypal,
					"tc_usetcjs" => $tc_usetcjs,
					"tc_doublenum" => $tc_doublenum,
					"tc_taglio" => sanitize_text_field($_REQUEST["add_tc_taglio"]),
					"tc_set_order_detail" => $add_tc_set_order_detail,
					"tc_set_order_item" => sanitize_text_field($_REQUEST["add_tc_set_order_item"]),
					"tc_set_phone_credit" => $tc_set_phone_credit,
					"tc_require_customer_email" => $tc_require_customer_email,
					"tc_template" => sanitize_text_field($_REQUEST["add_tc_template"]),
					"tc_coupon_enable" => $tc_coupon_enable,
					"tc_coupon_enable_default" => $tc_coupon_enable_default,
					"tc_coupon_default" => $tc_coupon_default,
					"tc_coupon_default_hidden" => $tc_coupon_default_hidden,
					"tc_form_layout" => $tc_form_layout
				);
				update_option("tcrw_settings", $curropts);

			}

			if ($_REQUEST["drop_instance"]!="") {
				$curropts = get_option("tcrw_settings");
				//unset($curropts['instances']['tc_instances'][$_REQUEST["drop_instance"]]);
				unset($curropts['instances'][sanitize_text_field($_REQUEST["drop_instance"])]);
				update_option("tcrw_settings", $curropts);
			}

		}

		public function validHexColor($hexcolor="")
		{
			return preg_grep("/^(#[a-f0-9]{3}([a-f0-9]{3})?)$/i", $hexcolor);
		}

		/*
		 * User Settings
		 */

		/**
		 * Adds extra option fields to a user's profile
		 *
		 * @mvc Controller
		 *
		 * @param object
		 */
		public static function add_user_fields( $user ) {
			echo self::render_template( 'tcrw-settings/user-fields.php', array( 'user' => $user ) );
		}

		/**
		 * Validates and saves the values of extra user fields to the database
		 *
		 * @mvc Controller
		 *
		 * @param int $user_id
		 */
		public static function save_user_fields( $user_id ) {
			$user_fields = self::validate_user_fields( $user_id, $_POST );

//			update_user_meta( $user_id, 'tc_merchant', $user_fields[ 'tc_merchant' ] );
//			update_user_meta( $user_id, 'tc_merchant_email', $user_fields[ 'tc_merchant_email' ] );

		}

		/**
		 * Validates submitted user field values before they get saved to the database
		 *
		 * @mvc Model
		 *
		 * @param int   $user_id
		 * @param array $user_fields
		 * @return array
		 */
		public static function validate_user_fields( $user_id, $user_fields ) {

//			if ($user_fields[''])

			if ( $user_fields[ 'tcrw_user-example-field1' ] == false ) {
				$user_fields[ 'tcrw_user-example-field1' ] = true;
				add_notice( 'Example Field 1 should be true', 'error' );
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				$current_field2 = get_user_meta( $user_id, 'tcrw_user-example-field2', true );

				if ( $current_field2 != $user_fields[ 'tcrw_user-example-field2' ] ) {
					$user_fields[ 'tcrw_user-example-field2' ] = $current_field2;
					add_notice( 'Only administrators can change Example Field 2.', 'error' );
				}
			}

			return $user_fields;
		}

	} // end tcrw_Settings
}
