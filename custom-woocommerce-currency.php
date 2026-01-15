<?php
/**
 * Plugin Name: Multi-Currency Switcher for WooCommerce
 * Plugin URI: https://github.com/roy-dela-torre/Custom-WooCommerce-Currency-Switcher
 * Description: Allow users to switch currencies with custom currency management in admin dashboard. Applies to products, cart, checkout, and emails.
 * Version: 1.0.3
 * Author: Chusie Kokoro
 * Author URI: https://portfolio-react-tailwind-gilt.vercel.app/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: custom-wc-currency
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * WC requires at least: 5.0
 * WC tested up to: 8.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('CWC_VERSION', '1.0.3');
define('CWC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CWC_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CWC_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Main Plugin Class
 */
class Custom_WC_Currency_Switcher {
    
    private static $instance = null;
    private $table_name;
    private $github_repo = 'roy-dela-torre/Custom-WooCommerce-Currency-Switcher';
    
    /**
     * Get singleton instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'custom_currencies';
        
        // Hook into WordPress
        add_action('plugins_loaded', array($this, 'init'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }
    
    /**
     * Initialize plugin
     */
    public function init() {
        // Check if WooCommerce is active
        if (!class_exists('WooCommerce')) {
            add_action('admin_notices', array($this, 'woocommerce_missing_notice'));
            return;
        }
        
        // Start session for currency storage (use init hook to ensure it's early enough)
        add_action('init', array($this, 'start_session'), 1);
        
        // Load admin functionality
        if (is_admin()) {
            add_action('admin_menu', array($this, 'add_admin_menu'));
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        }
        
        // Frontend functionality
        add_action('wp_enqueue_scripts', array($this, 'frontend_enqueue_scripts'));
        add_action('wp_footer', array($this, 'display_currency_switcher'));
        
        // AJAX handlers
        add_action('wp_ajax_cwc_switch_currency', array($this, 'ajax_switch_currency'));
        add_action('wp_ajax_nopriv_cwc_switch_currency', array($this, 'ajax_switch_currency'));
        add_action('wp_ajax_cwc_delete_currency', array($this, 'ajax_delete_currency'));
        
        // WooCommerce price filters - Display only
        add_filter('woocommerce_currency', array($this, 'change_currency_symbol'));
        add_filter('woocommerce_currency_symbol', array($this, 'change_currency_symbol_display'), 10, 2);
        add_filter('woocommerce_price_format', array($this, 'change_price_format'), 10, 1);
        
        // Convert display prices (product pages, archives)
        add_filter('woocommerce_product_get_price', array($this, 'convert_product_price'), 10, 2);
        add_filter('woocommerce_product_get_regular_price', array($this, 'convert_product_price'), 10, 2);
        add_filter('woocommerce_product_get_sale_price', array($this, 'convert_product_price'), 10, 2);
        add_filter('woocommerce_product_variation_get_price', array($this, 'convert_product_price'), 10, 2);
        add_filter('woocommerce_product_variation_get_regular_price', array($this, 'convert_product_price'), 10, 2);
        add_filter('woocommerce_product_variation_get_sale_price', array($this, 'convert_product_price'), 10, 2);
        
        // Store original price in cart, convert dynamically
        add_action('woocommerce_add_to_cart', array($this, 'store_original_price_in_cart'), 10, 6);
        add_action('woocommerce_before_calculate_totals', array($this, 'convert_cart_prices'), 20);
        
        // Cart and checkout display
        add_filter('woocommerce_cart_item_price', array($this, 'convert_cart_item_price'), 10, 3);
        add_filter('woocommerce_cart_item_subtotal', array($this, 'convert_cart_item_subtotal'), 10, 3);
        
        // Order totals
        add_filter('woocommerce_order_subtotal_to_display', array($this, 'convert_order_subtotal'), 10, 3);
        add_filter('woocommerce_get_formatted_order_total', array($this, 'convert_order_total'), 10, 2);
        
        // Email filters
        add_filter('woocommerce_email_order_items_args', array($this, 'email_order_items_args'));
        add_action('woocommerce_email_before_order_table', array($this, 'add_currency_info_to_email'), 10, 4);
    }
    
    /**
     * Plugin activation
     */
    public function activate() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_name} (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            currency_name varchar(100) NOT NULL,
            currency_symbol varchar(10) NOT NULL,
            currency_code varchar(10) NOT NULL,
            multiplier decimal(10,6) NOT NULL DEFAULT 1.000000,
            is_default tinyint(1) NOT NULL DEFAULT 0,
            status tinyint(1) NOT NULL DEFAULT 1,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        // Insert default currency if table is empty
        $count = $wpdb->get_var("SELECT COUNT(*) FROM {$this->table_name}");
        if ($count == 0) {
            $default_currency = get_woocommerce_currency();
            $default_symbol = get_woocommerce_currency_symbol($default_currency);
            
            $wpdb->insert(
                $this->table_name,
                array(
                    'currency_name' => 'Default Currency',
                    'currency_symbol' => $default_symbol,
                    'currency_code' => $default_currency,
                    'multiplier' => 1.000000,
                    'is_default' => 1,
                    'status' => 1
                ),
                array('%s', '%s', '%s', '%f', '%d', '%d')
            );
        }
    }
    
    /**
     * Plugin deactivation
     */
    public function deactivate() {
        // Clean up if needed
    }
    
    /**
     * Start session
     */
    public function start_session() {
        if (!session_id() && !headers_sent()) {
            session_start();
        }
    }
    
    /**
     * WooCommerce missing notice
     */
    public function woocommerce_missing_notice() {
        ?>
        <div class="notice notice-error">
            <p><?php _e('Custom WooCommerce Currency Switcher requires WooCommerce to be installed and active.', 'multi-currency-switcher-for-woocommerce'); ?></p>
        </div>
        <?php
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            __('Currency Switcher', 'multi-currency-switcher-for-woocommerce'),
            __('Currency Switcher', 'multi-currency-switcher-for-woocommerce'),
            'manage_options',
            'cwc-currencies',
            array($this, 'admin_page'),
            'dashicons-money-alt',
            56
        );
        
        add_submenu_page(
            'cwc-currencies',
            __('Add New Currency', 'multi-currency-switcher-for-woocommerce'),
            __('Add New', 'multi-currency-switcher-for-woocommerce'),
            'manage_options',
            'cwc-add-currency',
            array($this, 'add_currency_page')
        );
    }
    
    /**
     * Admin page - List currencies
     */
    public function admin_page() {
        global $wpdb;
        
        // Handle manual table creation
        if (isset($_GET['create_table']) && check_admin_referer('cwc_create_table_nonce', '_wpnonce')) {
            $this->activate();
            echo '<div class="notice notice-success is-dismissible"><p>' . __('Database table created/verified successfully!', 'multi-currency-switcher-for-woocommerce') . '</p></div>';
        }
        
        // Handle form submissions
        if (isset($_POST['cwc_action']) && check_admin_referer('cwc_action_nonce')) {
            if ($_POST['cwc_action'] === 'add_currency') {
                $this->save_currency();
            } elseif ($_POST['cwc_action'] === 'edit_currency') {
                $this->update_currency();
            }
        }
        
        // Check if table exists
        $table_exists = $wpdb->get_var("SHOW TABLES LIKE '{$this->table_name}'") === $this->table_name;
        
        if (!$table_exists) {
            ?>
            <div class="wrap">
                <h1><?php _e('Currency Switcher', 'multi-currency-switcher-for-woocommerce'); ?></h1>
                <div class="notice notice-error">
                    <p><?php _e('Database table does not exist. Please create it first.', 'multi-currency-switcher-for-woocommerce'); ?></p>
                </div>
                <p>
                    <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=cwc-currencies&create_table=1'), 'cwc_create_table_nonce'); ?>" class="button button-primary"><?php _e('Create Database Table', 'multi-currency-switcher-for-woocommerce'); ?></a>
                </p>
            </div>
            <?php
            return;
        }
        
        // Get all currencies
        $currencies = $wpdb->get_results("SELECT * FROM {$this->table_name} ORDER BY is_default DESC, id DESC");
        
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php _e('Currency Switcher', 'multi-currency-switcher-for-woocommerce'); ?></h1>
            <a href="<?php echo admin_url('admin.php?page=cwc-add-currency'); ?>" class="page-title-action"><?php _e('Add New', 'multi-currency-switcher-for-woocommerce'); ?></a>
            
            <?php if (empty($currencies)) : ?>
                <div class="notice notice-warning" style="margin-top: 20px;">
                    <p><?php _e('No currencies found. Click "Add New" to add your first currency, or recreate the database table if needed.', 'multi-currency-switcher-for-woocommerce'); ?></p>
                    <p>
                        <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=cwc-currencies&create_table=1'), 'cwc_create_table_nonce'); ?>" class="button"><?php _e('Recreate Database Table', 'multi-currency-switcher-for-woocommerce'); ?></a>
                    </p>
                </div>
            <?php endif; ?>
            
            <table class="wp-list-table widefat fixed striped" style="margin-top: 20px;">
                <thead>
                    <tr>
                        <th><?php _e('ID', 'multi-currency-switcher-for-woocommerce'); ?></th>
                        <th><?php _e('Currency Name', 'multi-currency-switcher-for-woocommerce'); ?></th>
                        <th><?php _e('Symbol', 'multi-currency-switcher-for-woocommerce'); ?></th>
                        <th><?php _e('Code', 'multi-currency-switcher-for-woocommerce'); ?></th>
                        <th><?php _e('Multiplier', 'multi-currency-switcher-for-woocommerce'); ?></th>
                        <th><?php _e('Default', 'multi-currency-switcher-for-woocommerce'); ?></th>
                        <th><?php _e('Status', 'multi-currency-switcher-for-woocommerce'); ?></th>
                        <th><?php _e('Actions', 'multi-currency-switcher-for-woocommerce'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($currencies)) : ?>
                        <tr>
                            <td colspan="8"><?php _e('No currencies found.', 'multi-currency-switcher-for-woocommerce'); ?></td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($currencies as $currency) : ?>
                            <tr>
                                <td><?php echo esc_html($currency->id); ?></td>
                                <td><?php echo esc_html($currency->currency_name); ?></td>
                                <td><?php echo esc_html($currency->currency_symbol); ?></td>
                                <td><?php echo esc_html($currency->currency_code); ?></td>
                                <td><?php echo esc_html($currency->multiplier); ?></td>
                                <td><?php echo $currency->is_default ? '✓' : ''; ?></td>
                                <td><?php echo $currency->status ? __('Active', 'multi-currency-switcher-for-woocommerce') : __('Inactive', 'multi-currency-switcher-for-woocommerce'); ?></td>
                                <td>
                                    <a href="<?php echo admin_url('admin.php?page=cwc-add-currency&edit=' . $currency->id); ?>" class="button button-small"><?php _e('Edit', 'multi-currency-switcher-for-woocommerce'); ?></a>
                                    <?php if (!$currency->is_default) : ?>
                                        <button class="button button-small cwc-delete-currency" data-id="<?php echo esc_attr($currency->id); ?>"><?php _e('Delete', 'multi-currency-switcher-for-woocommerce'); ?></button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    
    /**
     * Add/Edit currency page
     */
    public function add_currency_page() {
        global $wpdb;
        
        $edit_mode = false;
        $currency_data = null;
        
        if (isset($_GET['edit'])) {
            $edit_mode = true;
            $currency_id = intval($_GET['edit']);
            $currency_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id = %d", $currency_id));
            
            if (!$currency_data) {
                echo '<div class="notice notice-error"><p>' . __('Currency not found.', 'multi-currency-switcher-for-woocommerce') . '</p></div>';
                return;
            }
        }
        
        ?>
        <div class="wrap">
            <h1><?php echo $edit_mode ? __('Edit Currency', 'multi-currency-switcher-for-woocommerce') : __('Add New Currency', 'multi-currency-switcher-for-woocommerce'); ?></h1>
            
            <form method="post" action="<?php echo admin_url('admin.php?page=cwc-currencies'); ?>">
                <?php wp_nonce_field('cwc_action_nonce'); ?>
                <input type="hidden" name="cwc_action" value="<?php echo $edit_mode ? 'edit_currency' : 'add_currency'; ?>">
                <?php if ($edit_mode) : ?>
                    <input type="hidden" name="currency_id" value="<?php echo esc_attr($currency_data->id); ?>">
                <?php endif; ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="currency_name"><?php _e('Currency Name', 'multi-currency-switcher-for-woocommerce'); ?> *</label>
                        </th>
                        <td>
                            <input type="text" name="currency_name" id="currency_name" class="regular-text" value="<?php echo $edit_mode ? esc_attr($currency_data->currency_name) : ''; ?>" required>
                            <p class="description"><?php _e('Example: US Dollar, Euro, British Pound', 'multi-currency-switcher-for-woocommerce'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="currency_symbol"><?php _e('Currency Symbol', 'multi-currency-switcher-for-woocommerce'); ?> *</label>
                        </th>
                        <td>
                            <input type="text" name="currency_symbol" id="currency_symbol" class="regular-text" value="<?php echo $edit_mode ? esc_attr($currency_data->currency_symbol) : ''; ?>" required>
                            <p class="description"><?php _e('Example: $, €, £', 'multi-currency-switcher-for-woocommerce'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="currency_code"><?php _e('Currency Code', 'multi-currency-switcher-for-woocommerce'); ?> *</label>
                        </th>
                        <td>
                            <input type="text" name="currency_code" id="currency_code" class="regular-text" value="<?php echo $edit_mode ? esc_attr($currency_data->currency_code) : ''; ?>" required maxlength="10">
                            <p class="description"><?php _e('Example: USD, EUR, GBP (3-letter ISO code)', 'multi-currency-switcher-for-woocommerce'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="multiplier"><?php _e('Multiplier', 'multi-currency-switcher-for-woocommerce'); ?> *</label>
                        </th>
                        <td>
                            <input type="number" name="multiplier" id="multiplier" class="regular-text" value="<?php echo $edit_mode ? esc_attr($currency_data->multiplier) : '1.000000'; ?>" step="0.000001" min="0" required>
                            <p class="description"><?php _e('Conversion rate from default currency. Example: If 1 USD = 0.85 EUR, enter 0.85', 'multi-currency-switcher-for-woocommerce'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="is_default"><?php _e('Set as Default', 'multi-currency-switcher-for-woocommerce'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" name="is_default" id="is_default" value="1" <?php echo ($edit_mode && $currency_data->is_default) ? 'checked' : ''; ?>>
                            <p class="description"><?php _e('Make this the default currency', 'multi-currency-switcher-for-woocommerce'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="status"><?php _e('Status', 'multi-currency-switcher-for-woocommerce'); ?></label>
                        </th>
                        <td>
                            <select name="status" id="status">
                                <option value="1" <?php echo ($edit_mode && $currency_data->status == 1) ? 'selected' : ''; ?>><?php _e('Active', 'multi-currency-switcher-for-woocommerce'); ?></option>
                                <option value="0" <?php echo ($edit_mode && $currency_data->status == 0) ? 'selected' : ''; ?>><?php _e('Inactive', 'multi-currency-switcher-for-woocommerce'); ?></option>
                            </select>
                        </td>
                    </tr>
                </table>
                
                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo $edit_mode ? __('Update Currency', 'multi-currency-switcher-for-woocommerce') : __('Add Currency', 'multi-currency-switcher-for-woocommerce'); ?>">
                    <a href="<?php echo admin_url('admin.php?page=cwc-currencies'); ?>" class="button"><?php _e('Cancel', 'multi-currency-switcher-for-woocommerce'); ?></a>
                </p>
            </form>
        </div>
        <?php
    }
    
    /**
     * Save new currency
     */
    private function save_currency() {
        global $wpdb;
        
        $currency_name = sanitize_text_field($_POST['currency_name']);
        $currency_symbol = sanitize_text_field($_POST['currency_symbol']);
        $currency_code = strtoupper(sanitize_text_field($_POST['currency_code']));
        $multiplier = floatval($_POST['multiplier']);
        $is_default = isset($_POST['is_default']) ? 1 : 0;
        $status = intval($_POST['status']);
        
        // If setting as default, remove default from others
        if ($is_default) {
            $wpdb->update(
                $this->table_name,
                array('is_default' => 0),
                array(),
                array('%d')
            );
        }
        
        $result = $wpdb->insert(
            $this->table_name,
            array(
                'currency_name' => $currency_name,
                'currency_symbol' => $currency_symbol,
                'currency_code' => $currency_code,
                'multiplier' => $multiplier,
                'is_default' => $is_default,
                'status' => $status
            ),
            array('%s', '%s', '%s', '%f', '%d', '%d')
        );
        
        if ($result) {
            echo '<div class="notice notice-success is-dismissible"><p>' . __('Currency added successfully!', 'multi-currency-switcher-for-woocommerce') . '</p></div>';
        } else {
            $error_message = $wpdb->last_error ? $wpdb->last_error : __('Unknown database error', 'multi-currency-switcher-for-woocommerce');
            echo '<div class="notice notice-error is-dismissible"><p>' . sprintf(__('Error adding currency: %s', 'multi-currency-switcher-for-woocommerce'), esc_html($error_message)) . '</p></div>';
        }
    }
    
    /**
     * Update existing currency
     */
    private function update_currency() {
        global $wpdb;
        
        $currency_id = intval($_POST['currency_id']);
        $currency_name = sanitize_text_field($_POST['currency_name']);
        $currency_symbol = sanitize_text_field($_POST['currency_symbol']);
        $currency_code = strtoupper(sanitize_text_field($_POST['currency_code']));
        $multiplier = floatval($_POST['multiplier']);
        $is_default = isset($_POST['is_default']) ? 1 : 0;
        $status = intval($_POST['status']);
        
        // If setting as default, remove default from others
        if ($is_default) {
            $wpdb->update(
                $this->table_name,
                array('is_default' => 0),
                array(),
                array('%d')
            );
        }
        
        $result = $wpdb->update(
            $this->table_name,
            array(
                'currency_name' => $currency_name,
                'currency_symbol' => $currency_symbol,
                'currency_code' => $currency_code,
                'multiplier' => $multiplier,
                'is_default' => $is_default,
                'status' => $status
            ),
            array('id' => $currency_id),
            array('%s', '%s', '%s', '%f', '%d', '%d'),
            array('%d')
        );
        
        if ($result !== false) {
            echo '<div class="notice notice-success is-dismissible"><p>' . __('Currency updated successfully!', 'multi-currency-switcher-for-woocommerce') . '</p></div>';
        } else {
            $error_message = $wpdb->last_error ? $wpdb->last_error : __('No changes made or unknown error', 'multi-currency-switcher-for-woocommerce');
            echo '<div class="notice notice-error is-dismissible"><p>' . sprintf(__('Error updating currency: %s', 'multi-currency-switcher-for-woocommerce'), esc_html($error_message)) . '</p></div>';
        }
    }
    
    /**
     * Admin enqueue scripts
     */
    public function admin_enqueue_scripts($hook) {
        if (strpos($hook, 'cwc-currencies') === false && strpos($hook, 'cwc-add-currency') === false) {
            return;
        }
        
        wp_enqueue_script('cwc-admin-js', CWC_PLUGIN_URL . 'assets/admin.js', array('jquery'), CWC_VERSION, true);
        wp_localize_script('cwc-admin-js', 'cwc_admin', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cwc_admin_nonce'),
            'confirm_delete' => __('Are you sure you want to delete this currency?', 'multi-currency-switcher-for-woocommerce')
        ));
        
        wp_enqueue_style('cwc-admin-css', CWC_PLUGIN_URL . 'assets/admin.css', array(), CWC_VERSION);
    }
    
    /**
     * Frontend enqueue scripts
     */
    public function frontend_enqueue_scripts() {
        wp_enqueue_script('cwc-frontend-js', CWC_PLUGIN_URL . 'assets/frontend.js', array('jquery'), CWC_VERSION, true);
        wp_localize_script('cwc-frontend-js', 'cwc_frontend', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cwc_frontend_nonce')
        ));
        
        wp_enqueue_style('cwc-frontend-css', CWC_PLUGIN_URL . 'assets/frontend.css', array(), CWC_VERSION);
    }
    
    /**
     * Display currency switcher on frontend
     */
    public function display_currency_switcher() {
        global $wpdb;
        
        $currencies = $wpdb->get_results("SELECT * FROM {$this->table_name} WHERE status = 1 ORDER BY is_default DESC");
        
        if (empty($currencies)) {
            return;
        }
        
        $current_currency = $this->get_current_currency();
        
        ?>
        <div class="cwc-currency-switcher">
            <div class="cwc-switcher-toggle">
                <span class="cwc-current-currency"><?php echo esc_html($current_currency->currency_symbol . ' ' . $current_currency->currency_code); ?></span>
            </div>
            <div class="cwc-switcher-dropdown">
                <ul>
                    <?php foreach ($currencies as $currency) : ?>
                        <li>
                            <a href="#" class="cwc-currency-option" data-id="<?php echo esc_attr($currency->id); ?>">
                                <span class="cwc-symbol"><?php echo esc_html($currency->currency_symbol); ?></span>
                                <span class="cwc-name"><?php echo esc_html($currency->currency_name); ?></span>
                                <span class="cwc-code">(<?php echo esc_html($currency->currency_code); ?>)</span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php
    }
    
    /**
     * AJAX switch currency
     */
    public function ajax_switch_currency() {
        check_ajax_referer('cwc_frontend_nonce', 'nonce');
        
        $currency_id = intval($_POST['currency_id']);
        
        if ($currency_id > 0) {
            // Store in session
            $_SESSION['cwc_selected_currency'] = $currency_id;
            
            // Also store in cookie as backup (30 days)
            setcookie('cwc_selected_currency', $currency_id, time() + (30 * 24 * 60 * 60), '/');
            
            wp_send_json_success(array(
                'message' => __('Currency switched successfully', 'multi-currency-switcher-for-woocommerce'),
                'currency_id' => $currency_id
            ));
        } else {
            wp_send_json_error(array('message' => __('Invalid currency', 'multi-currency-switcher-for-woocommerce')));
        }
    }
    
    /**
     * AJAX delete currency
     */
    public function ajax_delete_currency() {
        check_ajax_referer('cwc_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => __('Permission denied', 'multi-currency-switcher-for-woocommerce')));
        }
        
        global $wpdb;
        $currency_id = intval($_POST['currency_id']);
        
        // Check if it's not default
        $currency = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id = %d", $currency_id));
        
        if ($currency && !$currency->is_default) {
            $result = $wpdb->delete($this->table_name, array('id' => $currency_id), array('%d'));
            
            if ($result) {
                wp_send_json_success(array('message' => __('Currency deleted successfully', 'multi-currency-switcher-for-woocommerce')));
            } else {
                wp_send_json_error(array('message' => __('Error deleting currency', 'multi-currency-switcher-for-woocommerce')));
            }
        } else {
            wp_send_json_error(array('message' => __('Cannot delete default currency', 'multi-currency-switcher-for-woocommerce')));
        }
    }
    
    /**
     * Get current currency
     */
    private function get_current_currency() {
        global $wpdb;
        
        // Try to get from session first
        $currency_id = isset($_SESSION['cwc_selected_currency']) ? intval($_SESSION['cwc_selected_currency']) : 0;
        
        // If not in session, try cookie
        if ($currency_id == 0 && isset($_COOKIE['cwc_selected_currency'])) {
            $currency_id = intval($_COOKIE['cwc_selected_currency']);
            // Store in session for this request
            $_SESSION['cwc_selected_currency'] = $currency_id;
        }
        
        if ($currency_id > 0) {
            $currency = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id = %d AND status = 1", $currency_id));
            if ($currency) {
                return $currency;
            }
        }
        
        // Return default currency
        $default = $wpdb->get_row("SELECT * FROM {$this->table_name} WHERE is_default = 1 LIMIT 1");
        return $default ? $default : $wpdb->get_row("SELECT * FROM {$this->table_name} WHERE status = 1 LIMIT 1");
    }
    
    /**
     * Change currency symbol
     */
    public function change_currency_symbol($currency) {
        $current = $this->get_current_currency();
        return $current ? $current->currency_code : $currency;
    }
    
    /**
     * Change currency symbol display
     */
    public function change_currency_symbol_display($currency_symbol, $currency) {
        $current = $this->get_current_currency();
        return $current ? $current->currency_symbol : $currency_symbol;
    }
    
    /**
     * Change price format to add proper spacing
     */
    public function change_price_format($format) {
        $current = $this->get_current_currency();
        
        // If we have a custom currency, ensure proper spacing
        if ($current) {
            // Add space between symbol and price
            // Format: %1$s = currency symbol, %2$s = price
            $format = '%1$s %2$s';
        }
        
        return $format;
    }
    
    /**
     * Convert product price for display (product pages, archives)
     */
    public function convert_product_price($price, $product) {
        // Skip conversion in cart/checkout to prevent double conversion
        if (is_cart() || is_checkout()) {
            return $price;
        }
        
        if (empty($price) || !is_numeric($price)) {
            return $price;
        }
        
        $current = $this->get_current_currency();
        
        if ($current && $current->multiplier != 1) {
            return $price * $current->multiplier;
        }
        
        return $price;
    }
    
    /**
     * Store original price when adding to cart
     */
    public function store_original_price_in_cart($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data) {
        $cart = WC()->cart->get_cart();
        
        if (isset($cart[$cart_item_key])) {
            $product = wc_get_product($variation_id ? $variation_id : $product_id);
            
            // Remove our filter temporarily to get the unconverted base price
            remove_filter('woocommerce_product_get_price', array($this, 'convert_product_price'), 10);
            remove_filter('woocommerce_product_get_regular_price', array($this, 'convert_product_price'), 10);
            remove_filter('woocommerce_product_get_sale_price', array($this, 'convert_product_price'), 10);
            
            $base_price = $product->get_price();
            
            // Re-add filters
            add_filter('woocommerce_product_get_price', array($this, 'convert_product_price'), 10, 2);
            add_filter('woocommerce_product_get_regular_price', array($this, 'convert_product_price'), 10, 2);
            add_filter('woocommerce_product_get_sale_price', array($this, 'convert_product_price'), 10, 2);
            
            // Store original base price (in default currency)
            WC()->cart->cart_contents[$cart_item_key]['cwc_base_price'] = $base_price;
        }
    }
    
    /**
     * Convert cart prices based on stored base prices
     */
    public function convert_cart_prices($cart) {
        if (is_admin() && !defined('DOING_AJAX')) {
            return;
        }
        
        $current = $this->get_current_currency();
        
        foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
            // Get the base price (original unconverted price)
            if (isset($cart_item['cwc_base_price'])) {
                $base_price = $cart_item['cwc_base_price'];
            } else {
                // Fallback: get product base price without conversion
                $product = $cart_item['data'];
                remove_filter('woocommerce_product_get_price', array($this, 'convert_product_price'), 10);
                $base_price = $product->get_price();
                add_filter('woocommerce_product_get_price', array($this, 'convert_product_price'), 10, 2);
                
                // Store for future use
                WC()->cart->cart_contents[$cart_item_key]['cwc_base_price'] = $base_price;
            }
            
            // Apply current currency conversion to base price
            if ($current && $current->multiplier != 1) {
                $converted_price = $base_price * $current->multiplier;
            } else {
                $converted_price = $base_price;
            }
            
            // Set the converted price in cart
            $cart_item['data']->set_price($converted_price);
        }
    }
    
    /**
     * Convert cart item price
     */
    public function convert_cart_item_price($price, $cart_item, $cart_item_key) {
        // Price is already formatted HTML, so we return it as is
        // The conversion happens at product price level
        return $price;
    }
    
    /**
     * Convert cart item subtotal
     */
    public function convert_cart_item_subtotal($subtotal, $cart_item, $cart_item_key) {
        // Subtotal is already formatted HTML with converted prices
        return $subtotal;
    }
    
    /**
     * Convert order subtotal
     */
    public function convert_order_subtotal($subtotal, $compound, $order) {
        return $subtotal;
    }
    
    /**
     * Convert order total
     */
    public function convert_order_total($formatted_total, $order) {
        return $formatted_total;
    }
    
    /**
     * Email order items args
     */
    public function email_order_items_args($args) {
        return $args;
    }
    
    /**
     * Add currency info to email
     */
    public function add_currency_info_to_email($order, $sent_to_admin, $plain_text, $email) {
        $current = $this->get_current_currency();
        
        if ($current && !$current->is_default) {
            if ($plain_text) {
                echo "\n" . sprintf(__('Currency: %s (%s)', 'multi-currency-switcher-for-woocommerce'), $current->currency_name, $current->currency_code) . "\n";
                echo sprintf(__('Exchange Rate: %s', 'multi-currency-switcher-for-woocommerce'), $current->multiplier) . "\n\n";
            } else {
                echo '<p style="margin: 10px 0; padding: 10px; background: #f5f5f5; border-left: 3px solid #0073aa;">';
                echo '<strong>' . sprintf(__('Currency: %s (%s)', 'multi-currency-switcher-for-woocommerce'), esc_html($current->currency_name), esc_html($current->currency_code)) . '</strong><br>';
                echo sprintf(__('Exchange Rate: %s', 'multi-currency-switcher-for-woocommerce'), esc_html($current->multiplier));
                echo '</p>';
            }
        }
    }
}

// Initialize plugin
function cwc_init() {
    return Custom_WC_Currency_Switcher::get_instance();
}

// Start the plugin
add_action('plugins_loaded', 'cwc_init', 0);

