<?php
$pp_style = isset($nasa_opt['pp_style']) && $nasa_opt['pp_style'] == 'full' ? 'full' : 'simple';
$class_content = 'columns large-6 medium-6 small-12 nasa-pp-right';
$class_content .= $pp_style == 'full' ? ' large-12' : ' large-6 right';
?>
<style>
    #nasa-popup {
        width: <?php echo isset($nasa_opt['pp_width']) ? (int) $nasa_opt['pp_width'] : 724; ?>px;
        background-color: <?php echo isset($nasa_opt['pp_background_color']) ? esc_url($nasa_opt['pp_background_color']) : 'transparent' ?>;
        background-image: url('<?php echo esc_url($nasa_opt['pp_background_image']); ?>');
        background-repeat: no-repeat;
        background-size: auto;
    }
    #nasa-popup,
    #nasa-popup .nasa-popup-wrap {
        height: <?php echo isset($nasa_opt['pp_height']) ? (int) $nasa_opt['pp_height'] : 501; ?>px;
    }
    
    .nasa-pp-left {
        min-height: 1px;
    }
</style>
<div id="nasa-popup" class="white-popup-block mfp-hide mfp-with-anim zoom-anim-dialog">
    <div class="row">
        <?php if($pp_style == 'simple'): ?>
            <div class="columns large-6 medium-6 small-12 nasa-pp-left"></div>
        <?php endif; ?>
        <div class="<?php echo esc_attr($class_content); ?>">
            <div class="nasa-popup-wrap nasa-relative">
                <div class="nasa-popup-wrap-content">
                    <?php
                    /**
                     * Content description
                     */
                    echo isset($nasa_opt['pp_content']) ? do_shortcode($nasa_opt['pp_content']) : '';
                    
                    /**
                     * Content contact form 7
                     */
                    echo (isset($nasa_opt['pp_contact_form']) && (int) $nasa_opt['pp_contact_form'] && shortcode_exists('contact-form-7')) ? do_shortcode('[contact-form-7 id="' . ((int) $nasa_opt['pp_contact_form']) . '"]') : '';
                    ?>
                </div>
                <hr class="nasa-popup-hr" />
                <p class="checkbox-label align-center">
                    <input type="checkbox" value="do-not-show" name="showagain" id="showagain" class="showagain" />
                    <label for="showagain"><?php esc_html_e("Don't show this popup again", 'elessi-theme'); ?></label>
                </p>
            </div>
        </div>
    </div>
</div>