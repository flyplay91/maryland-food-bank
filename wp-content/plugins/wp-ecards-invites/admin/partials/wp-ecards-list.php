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
 $tab = isset($_GET["tab"]) ? $_GET["tab"] : "ecards";
?>
<div class="wrap">
    <h1>WP Ecards</h1>
    Powered by <a href="https://ecardwidget.com/" target="_blank">EcardWidget.com</a><br><br>

    <div id="message" class="updated">
        <p>
            If you need help please <a href="mailto:tim@eiqinteractive.com">email me</a>. Also, I'd really appreciate a <a href="https://wordpress.org/plugins/wp-ecards-invites/#reviews">review on Wordpress</a> :)
        </p>
    </div>
    <h2 class="nav-tab-wrapper">
        <a href="?page=wp-ecards-admin&tab=ecards" class="nav-tab <?php if($tab == "ecards") echo "nav-tab-active"; ?>">Manage Ecards</a>
        <a href="?page=wp-ecards-admin&tab=options" class="nav-tab <?php if($tab == "options") echo "nav-tab-active"; ?>">Shortcodes / Embed</a>
        <?php if($tab == "ecards") { ?>
            <a href="#TB_inline?width=600&height=150&inlineId=modal-window-id" class="thickbox nav-tab" style="float:right">Logout</a>
        <?php } else { ?>
            <!-- <a href="?page=wp-ecards-admin&tab=ecards" class="nav-tab" style="float:right">Logout</a> -->
        <?php } ?>
    </h2>
    <br>
    <?php if($tab == "ecards") { ?>
        <?php
            $iframeRoute = "dashboard";
            if(isset($_GET["authed"]) && strlen($_GET["authed"])) {
                $iframeRoute = "d/createecard";
            }
        ?>
        <?php add_thickbox(); ?>

        <div id="modal-window-id" style="display:none;">

            <h2>Are you sure you want to logout and remove the authenication?</h2>
            <p>
                While logged out, your Ecards and Shortcodes will still work and function but you won't be able to
                manage your ecards until you login again.
            </p>
            <a href="#" class="deauth-btn">Yes, Continue logout</a>
        </div>

        <iframe id="ecardFrame" src="https://wp.ecardwidget.com/<?php echo $iframeRoute ?>?wpAuthPing&v=1.3.5" border="0" width="100%" style="height: 2000px; overflow:scroll;"></iframe>
        <script type="text/javascript">
            window.loggingOut = false;
            var loopCheck = 0;
            iFrameResize({
                log: false, // Enable console logging
                inPageLinks: true,
                onInit: function(i) {
                    loopCheck++
                    console.log("loopCheck", loopCheck)
                    setTimeout(() => { loopCheck--; }, 500);
                    if(loopCheck > 8) {
                        jQuery("iframe").remove()
                        console.log("Browser is blocking cross-site cookies.")
                        window.location.href = "?page=wp-ecards-admin&auth=true&loopStop";
                    }
                    // send key to ecard site
                    if(!window.loggingOut) i.iFrameResizer.sendMessage("<?php echo $apiKey; ?>");
                    window.iFrameResize = i.iFrameResizer;
                },
                onMessage: function(m) {
                    console.log("parent.message", m)

                    if(m.message == "wpLoggedOutMsg") {
                        window.location.href = "?page=wp-ecards-admin&auth=true&logged_out";
                    }

                    if(m.message == 'error') {
                        jQuery(".wrap").append(
                            '<div id="message" class="notice is-dismissible notice-error"><p>' +
                            "Sorry, there was a problem logging you in. Please try again or contact support.</p></div>"
                        )
                    }
                }
            }, '#ecardFrame')

            // Log out listener
            jQuery(function() {
                jQuery('.deauth-btn').click(function() {
                    window.loggingOut = true;
                    jQuery.get('?page=wp-ecards-admin&deauthorize=1').done(function() {
                        window.iFrameResize.sendMessage("logout");
                    })
                });
            })
        </script>
    <?php } else { ?>

        <h2>Shortcodes</h2>

        <?php
        if(sizeof($widgetList)) {
            echo "To add a widget to any page, just copy and paste any of the shortcodes below:<br><br>";
            foreach ($widgetList as $i => $row)
            {
                $title = strlen($row["name"]) ? $row["name"] : "My Ecards";
                echo "<b>".  $title .":</b> (<a target='_blank' href='https://ecardwidget.com/d/widget/".$row["id"]."/ecards'>Manage Ecards</a>)<br><input style='width:100%' value='[ecards id=" . $row["id"] . " poweredByLink=true]'><br><br>";
            }
        } else {
            echo "<h4>Aw snap! You haven't added any ecard widgets yet. <a href='?page=wp-ecards-admin&tab=ecards'>Click here to get started</a></h4>";
        }
        ?>

    <?php } ?>
</div>