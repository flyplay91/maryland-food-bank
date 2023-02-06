<?php defined('ABSPATH') or die("No script kiddies please!"); ?>

<div class="wrap">

<h2>Purge Locations</h2>

</div>
<?php

    global $wpdb;

    // Count number of locations without coords
    $allposts = get_posts( array('post_type'=>'partner_locations','post_status' => 'any','numberposts'=>-1) );
    $total = count($allposts);
    echo "<br><br>";

    echo "There are <b>" . $total . "</b> posts for partner locations";

    echo "<br><br><br>";

    echo "<form method=\"post\" action\"\"><input type=\"hidden\" name=\"purge\" value=\"purge\" ><input type=\"submit\" value=\"Purge all location data\" onclick=\"return confirm('Are you sure you want to continue');\"></form>";

    echo "<br>";

    echo "<small>Warning: This will delete all location data. Only do this if you plan to upload entirely new data and no longer need the old data.</small>";

    echo "<br><br>";

    echo "<a href=\"admin.php?page=purge-locations\">Refresh</a>";

    echo "<br><br>";



// Form submission to pull coordinates

if($_POST['purge']=='purge'){

    echo "<hr>";
    $allposts = get_posts( array('post_type'=>'partner_locations','post_status' => 'any','numberposts'=>-1) );
    $total = count($allposts);

    foreach ($allposts as $eachpost) {
        gmw_delete_post_location($eachpost->ID);
        wp_delete_post( $eachpost->ID, true );
    }


    echo "You have successfully purged all <b>" . $total . "</b> of the location data";

    echo "<br><br>";

    echo "<a href=\"admin.php?page=purge-locations\">Refresh</a>";

    echo "<br><br>";

}

?>