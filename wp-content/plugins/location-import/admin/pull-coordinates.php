<?php defined('ABSPATH') or die("No script kiddies please!"); ?>

<div class="wrap">

<h2>Pull Coordinates</h2>

</div>
<?php 

    global $wpdb;

    // Count number of locations without coords

    $query = "SELECT COUNT(*) as COUNT
                FROM wp_places_locator p
                WHERE p.lat is null AND p.long is null";
    
    $results = $wpdb->get_results($query);

    foreach( $results as $result ){
		$data[] = $result->COUNT;
    }

    // Display data & build form
    
    echo "Number of locations with out GEO coordinates (Longitude & Latitude): ";

    echo "<span style=\"color: red;\"><b>" . $data[0] . "<b></span>";

    echo "<br><br><br>";

    echo "<form method=\"post\" action\"\"><input type=\"hidden\" name=\"pull\" value=\"pull\" ><input type=\"submit\" value=\"Pull coordinates\" onclick=\"return confirm('Are you sure you want to continue');\"></form>";

    echo "<br><br>";

    echo "<a href=\"admin.php?page=pull-coordinates\">Refresh</a>";

    echo "<br><br>";

    echo "<small>Please allow the script to process up to 5 seconds. We can only process 5 records per second and will process 25 at a time.</small>";

// Form submission to pull coordinates

if($_POST['pull']=='pull'){
    
    echo "<hr>";
    
    // Pull 25 locations that do not have coordinates
    $query = "SELECT post_id, address 
                    FROM wp_places_locator p
                    WHERE p.lat is null AND p.long is null limit 25";
    
    $results = $wpdb->get_results($query);

    
    foreach( $results as $result ){
		
        $lcs[] = $result;
        
    }
    
    $b = 0;
    
    foreach( $lcs as $lc ){
        
        $locations[$b]['post_id'] = $lc->post_id;
        $locations[$b]['address'] = $lc->address;
        
        $b++;
    }

    $x = 1;
    
    // Pull coordinates from Google
    
    foreach($locations as $location){
        
    if($x<26){ // Limite to 25
        
        $address = $location['address'];
        $post_id = $location['post_id'];
        
        $address = str_replace(',', '', $address);
        $address = str_replace('US', '', $address);
        $address = str_replace('MD', '', $address);
        $address = str_replace('  ', ' ', $address);
        $address = urlencode($address);

        $url = "http://maps.google.com/maps/api/geocode/json?address=" . $address . "&sensor=false&region=US";
        
        $response = file_get_contents($url);
        $response = json_decode($response, true);  
        //echo $response;

        $lat = $response['results'][0]['geometry']['location']['lat'];
        $long = $response['results'][0]['geometry']['location']['lng'];
        
        //Update actual record with new coordinates
        
        $query = "UPDATE wp_places_locator SET `lat` = '" . $lat . "', `long` = '" . $long . "' WHERE `post_id` = '" . $location['post_id'] ."'";
        
        $update_coords = $wpdb->query( $wpdb->prepare( $query ) );
        
      
        }
        
        // Delay
        
        if($x == 5 || $x == 10 || $x == 15 || $x == 20 || $x == 25){
            sleep(1); //delay to not hit rate limit, one per second to be safe
        }

        $x++;
        
        
    }

// Output
    
echo "<br><br>";
echo $x-1 . " records updated.";
echo "<br><br>";
    
    
// Pull again
    
    echo "<form method=\"post\" action\"\"><input type=\"hidden\" name=\"pull\" value=\"pull\" ><input type=\"submit\" value=\"Pull again\" onclick=\"return confirm('Are you sure you want to continue');\"></form>";
    
}
    
?>