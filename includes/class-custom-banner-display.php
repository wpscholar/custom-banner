<?php
/**
 * Frontend display functionality for the Custom Banner plugin
 *
 * @package Custom_Banner
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class Custom_Banner_Display
 *
 * Handles the frontend display of the custom banner
 */
class Custom_Banner_Display {
    /**
     * Constructor
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_body_open', array($this, 'display_banner'));
    }

    /**
     * Enqueue frontend scripts and styles
     */
    public function enqueue_scripts() {
        wp_enqueue_style(
            'custom-banner',
            CUSTOM_BANNER_PLUGIN_URL . 'assets/css/custom-banner.css',
            array(),
            CUSTOM_BANNER_VERSION
        );
    }

    /**
     * Display the banner
     */
    public function display_banner() {
        $options = get_option('custom_banner_options');
        
        if (!isset($options['is_active']) || !$options['is_active']) {
            return;
        }
        
        $banner_text = $options['banner_text'] ?? '';
        $text_color = $options['text_color'] ?? '#ffffff';
        $background_color = $options['background_color'] ?? '#000000';
        $button_text = $options['button_text'] ?? 'Shop All';
        $button_url = $options['button_url'] ?? '#';
        $button_color = $options['button_color'] ?? '#ffffff';
        $button_text_color = $options['button_text_color'] ?? '#000000';
        
        if (empty($banner_text)) {
            return;
        }
        
        ?>
        <div class="custom-banner" style="background-color: <?php echo esc_attr($background_color); ?>">
            <div class="custom-banner-content">
                <div class="custom-banner-text" style="color: <?php echo esc_attr($text_color); ?>">
                    <?php echo wp_kses_post($banner_text); ?>
                </div>
                <?php if (!empty($button_text)) : ?>
                    <a href="<?php echo esc_url($button_url); ?>" 
                       class="custom-banner-button" 
                       style="background-color: <?php echo esc_attr($button_color); ?>; color: <?php echo esc_attr($button_text_color); ?>">
                        <?php echo esc_html($button_text); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}