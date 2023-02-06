<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://ecardwidget.com
 * @since      1.0.0
 *
 * @package    Wp_Ecards
 * @subpackage Wp_Ecards/admin/partials
 */
?>
<!-- <?php add_thickbox(); ?>
<a href="http://example.com?TB_iframe=true&width=600&height=550" class="thickbox">View the WordPress Codex!</a> -->


<div class="wrap">

	<h1>WP Ecards</h1>
    Powered by <a href="https://ecardwidget.com/" target="_blank">EcardWidget.com</a><br><br>

    <div id="message" class="updated">
        <p>Only one more step! Just login or register below. You will then be able to embed your ecards on your Wordpress site. If you need help please <a href="mailto:tim@eiqinteractive.com">email me</a></p>
    </div>

    <div id="message" class="notice is-dismissible" style="display: none"><p></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>


    <!-- <?php include 'wp-ecards-thanks-button.php'; ?> -->

    <form id="authForm" action="?page=wp-ecards-admin&route=save_key" method="POST">
        <input id='key' name='key' type='hidden' value=''>
    </form>

    <iframe id="myFrame" src="https://wp.ecardwidget.com/api/wplanding?wpAuthPing&v=1.3.5" border="0" width="100%" style="height: 715px; overflow:scroll;"></iframe>

    <script type="text/javascript">
        iFrameResize({
            log: false, // Enable console logging
            inPageLinks: true,
            onMessage: function(messageData) {
                var apiKey = messageData.message;
                jQuery("#authForm #key").val(apiKey);
                jQuery.ajax({
                    url: jQuery("#authForm").attr("action"),
                    type: 'post',
                    dataType: 'json',
                    data: jQuery("#authForm").serialize(),
                    statusCode: {
                        200: function() {
                            jQuery(".notice p").text("Successfully authenticated.");
                            jQuery(".notice").addClass("notice-success");
                            jQuery(".notice").show();
                            window.location.href = "?page=wp-ecards-admin&authed=true";
                        },
                        404: function() {
                            jQuery(".notice p").text("Authentication failed.");
                            jQuery(".notice").addClass("notice-error");
                            jQuery(".notice").show();
                        }
                    }
                });
            }
        }, '#myFrame')
    </script>

</div>