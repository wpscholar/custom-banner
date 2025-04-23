<?php
/**
 * Admin functionality for the Custom Banner plugin
 *
 * @package Custom_Banner
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class Custom_Banner_Admin
 *
 * Handles the admin interface and settings
 */
class Custom_Banner_Admin {
    /**
     * Constructor
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }

    /**
     * Add menu item to WordPress admin
     */
    public function add_admin_menu() {
        add_options_page(
            esc_html__('Custom Banner Settings', 'custom-banner'),
            esc_html__('Custom Banner', 'custom-banner'),
            'manage_options',
            'custom-banner',
            array($this, 'settings_page')
        );
    }

    /**
     * Register plugin settings
     */
    public function register_settings() {
        register_setting('custom_banner_options', 'custom_banner_options', array($this, 'sanitize_settings'));
    }

    /**
     * Sanitize settings before saving
     *
     * @param array $input The input settings
     * @return array Sanitized settings
     */
    public function sanitize_settings($input) {
        $sanitized = array();

        if (isset($input['banner_text'])) {
            $sanitized['banner_text'] = wp_kses_post($input['banner_text']);
        }

        if (isset($input['text_color'])) {
            $sanitized['text_color'] = sanitize_hex_color($input['text_color']);
        }

        if (isset($input['background_color'])) {
            $sanitized['background_color'] = sanitize_hex_color($input['background_color']);
        }

        if (isset($input['button_text'])) {
            $sanitized['button_text'] = sanitize_text_field($input['button_text']);
        }

        if (isset($input['button_url'])) {
            $sanitized['button_url'] = esc_url_raw($input['button_url']);
        }

        if (isset($input['button_color'])) {
            $sanitized['button_color'] = sanitize_hex_color($input['button_color']);
        }

        if (isset($input['button_text_color'])) {
            $sanitized['button_text_color'] = sanitize_hex_color($input['button_text_color']);
        }

        if (isset($input['is_active'])) {
            $sanitized['is_active'] = (bool) $input['is_active'];
        }

        return $sanitized;
    }

    /**
     * Enqueue admin scripts and styles
     *
     * @param string $hook The current admin page.
     */
    public function enqueue_admin_scripts($hook) {
        if ('settings_page_custom-banner' !== $hook) {
            return;
        }

        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_script('custom-banner-admin', CUSTOM_BANNER_PLUGIN_URL . 'assets/js/admin.js', array('jquery', 'wp-color-picker'), CUSTOM_BANNER_VERSION, true);
    }

    /**
     * Render settings page
     */
    public function settings_page() {
        $options = get_option('custom_banner_options');
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            
            <form method="post" action="options.php">
                <?php
                settings_fields('custom_banner_options');
                ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="custom_banner_text"><?php esc_html_e('Banner Text', 'custom-banner'); ?></label>
                        </th>
                        <td>
                            <?php
                            wp_editor(
                                $options['banner_text'] ?? '',
                                'custom_banner_text',
                                array(
                                    'textarea_name' => 'custom_banner_options[banner_text]',
                                    'media_buttons' => false,
                                    'textarea_rows' => 3,
                                )
                            );
                            ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="custom_banner_button_text"><?php esc_html_e('Button Text', 'custom-banner'); ?></label>
                        </th>
                        <td>
                            <input type="text" 
                                   id="custom_banner_button_text" 
                                   name="custom_banner_options[button_text]" 
                                   value="<?php echo esc_attr($options['button_text'] ?? 'Shop All'); ?>" 
                                   class="regular-text" />
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="custom_banner_button_url"><?php esc_html_e('Button URL', 'custom-banner'); ?></label>
                        </th>
                        <td>
                            <input type="url" 
                                   id="custom_banner_button_url" 
                                   name="custom_banner_options[button_url]" 
                                   value="<?php echo esc_url($options['button_url'] ?? '#'); ?>" 
                                   class="regular-text" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="custom_banner_text_color"><?php esc_html_e('Text Color', 'custom-banner'); ?></label>
                        </th>
                        <td>
                            <input type="text" 
                                   id="custom_banner_text_color" 
                                   name="custom_banner_options[text_color]" 
                                   value="<?php echo esc_attr($options['text_color'] ?? '#ffffff'); ?>" 
                                   class="color-picker" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="custom_banner_background_color"><?php esc_html_e('Background Color', 'custom-banner'); ?></label>
                        </th>
                        <td>
                            <input type="text" 
                                   id="custom_banner_background_color" 
                                   name="custom_banner_options[background_color]" 
                                   value="<?php echo esc_attr($options['background_color'] ?? '#000000'); ?>" 
                                   class="color-picker" />
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="custom_banner_button_color"><?php esc_html_e('Button Color', 'custom-banner'); ?></label>
                        </th>
                        <td>
                            <input type="text" 
                                   id="custom_banner_button_color" 
                                   name="custom_banner_options[button_color]" 
                                   value="<?php echo esc_attr($options['button_color'] ?? '#ffffff'); ?>" 
                                   class="color-picker" />
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="custom_banner_button_text_color"><?php esc_html_e('Button Text Color', 'custom-banner'); ?></label>
                        </th>
                        <td>
                            <input type="text" 
                                   id="custom_banner_button_text_color" 
                                   name="custom_banner_options[button_text_color]" 
                                   value="<?php echo esc_attr($options['button_text_color'] ?? '#000000'); ?>" 
                                   class="color-picker" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="custom_banner_is_active"><?php esc_html_e('Enable Banner', 'custom-banner'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" 
                                   id="custom_banner_is_active" 
                                   name="custom_banner_options[is_active]" 
                                   value="1" 
                                   <?php checked(isset($options['is_active']) ? $options['is_active'] : true); ?> />
                        </td>
                    </tr>
                </table>
                
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}