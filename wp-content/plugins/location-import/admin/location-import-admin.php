<?php
  defined('ABSPATH') or die("No script kiddies please!");
?>
<style>

  .location-import > ul {
    list-style: none;
    padding:0;
    margin:0;
  }

  .location-import > ul > li {
    display: inline;
    border: solid;
    border-width: 1px 1px 0px 1px;
    margin: 0 0.5em 0 0;
    padding: 0 1em;
    background: white;
  }

  .location-import > ul > li a {
    color: black;
    text-decoration: none;
  }

  .location-import #content{
    border: 1px solid;
    padding: 1em;
  }

  .location-import #selected {
    padding-bottom: 1px;
    background: #f1f1f1;
    font-weight: bold;
  }

  .location-import .row-0{
    text-decoration: underline;
    font-weight: bold;
  }

  .location-import .verify-nav > li{
    display: inline;
    padding-right: 1em;
  }
</style>

<div class="wrap">
  <h2>Location Import Admin</h2>
</div>
<br>
<br>
<!-- Tabs -->
<div class="location-import">
<h3>Import Steps</h3>
<ul>
  <li <?php if(!isset($_FILES['file']) && !$_POST['data_insert']): ?>id="selected"<?php endif; ?>><a href="">Upload Spreadsheet</a></li>
  <li <?php if(isset($_FILES['file'])): ?>id="selected"<?php endif; ?>>Verify Data</li>
  <li <?php if(isset($_POST['data_insert'])): ?>id="selected"<?php endif; ?>>Insert to Database</li>
</ul>
<!-- Content -->
<div id="content">
<?php if(!isset($_FILES['file']) && !$_POST['data_insert']): ?>
  <form  method="post" enctype="multipart/form-data" >
    <fieldset>
      <legend>Upload a file (*.XLSX file):</legend>
      <input type="file" name="file" value=""  />
      <input type="submit" value="Upload" />
    </fieldset>
  </form>
<?php endif; ?>

<?php if(isset($_FILES['file'])): ?>
  <form  method="post" enctype="multipart/form-data">
  <?php if (isset($_FILES['file'])): ?>
    <?php
      require_once (ABSPATH . "/wp-content/plugins/location-import/inc/simplexlsx.class.php");
      $row = 0;
      //print_r($_FILES['file']); exit();
      $xlsx = new SimpleXLSX( $_FILES['file']['tmp_name'] );
      $rows = $xlsx->rows();
      location_import_process_records($rows)
    ?>
    <?php if (empty($headers)): ?>
      <h3>Invalid columns detected</h3>
    <?php else: ?>
      <form id="nextpage" method="post" >
        <input type="hidden" name="data_insert" value="1">
        <h2>Uploaded Data</h2>
        <ul class="verify-nav">
          <li><a href="/wp-admin/options-general.php?page=location-import-menu" onclick="return confirm('Are you sure you want to continue');" >Clear</a></li>
          <li><input type="submit" name="Insert Data" onclick="return confirm('Are you sure you want to continue');"></li>
        </ul>
        <?php
          // BUILD THE TABLE
          echo '<table>';
          //list($cols,) = $xlsx->dimension();
          foreach( $rows as $k => $r) {
            echo '<tr>';
            echo '<td><strong>' . $k . '</strong></td>';
            for( $i = 0; $i < 10; $i++) {
              echo '<td name="feed'.$row.''.$i.'" class="row-'.$row.'">'.( (isset($r[$i])) ? $r[$i] : '&nbsp;' ).'</td>';
            }
            echo '</tr>';
            $row++;
          }
          echo '</table>';

          $row = 0;

          //print_r($_FILES['file']); exit();

          foreach( $rows as $k => $r) {
            for( $i = 0; $i < 10; $i++) {
              echo '<input type="hidden" name="record['.$row.']['.$i.']" value="'.( (isset($r[$i])) ? $r[$i] : '&nbsp;').'"/>';
            }
            $row++;
          }

        ?>
      </form>
    <?php endif; ?>
  <?php endif; ?>
<?php endif; ?>


<?php
//  if($_POST['data_insert']) {
//    if (!empty($_POST['record'])) {
//      location_import_process_records($_POST['record']);
//    }
//    else {
//      echo "No records found";
//    }
//  }
?>

</div>
</div>
<script>

</script>
<?php //end script

function location_import_process_records($records = array()) {
  $user_id = get_current_user_id();

  // Array ( [0] => Name [1] => Primary Service Type [2] => Hours [3] => Address [4] => City [5] => ZIP Code [6] => Public Number [7] => Email )
//   Array
// (
//     [Name] => 0
//     [Primary Service Type] => 1
//     [Hours] => 2
//     [Address] => 3
//     [City] => 4
//     [ZIP Code] => 5
//     [Public Number] => 6
//     [Email] => 7
//     [ ] => 9
// )

  $num_created = 0;
  $num_updated = 0;
  $headers = array_shift($records);
  $headers = location_import_process_headers($headers);
  foreach($records as $record){
    $data = location_import_get_record_values($headers, $record);
    $args = array(
      'post_name'      => sanitize_title($data['name']),
      'post_content' => '',
      'post_title'     => $data['name'],
      'post_status'    => 'publish',
      'post_type'      => 'partner_locations',
      'ping_status'    => 'closed',
      'comment_status' => 'closed'
    );
    if (!empty($data['hours'])) {
        $args['post_content'] = 'Hours open: ' . $data['hours'];
    }
    $location = array(
      'street'    => $data['address'],
      'apt'       => '',
      'city'      => $data['city'],
      'state'     => 'MD',
      'zipcode'   => $data['zip_code'],
      'country'   => 'USA'
    );
    if ($location_post_id = location_import_get_by_partner_id($data['partner_id'])) {
      echo "Updating: " . $location_post_id . ": " . $data['name'] ."<br />";
      $args['post_id'] = $location_post_id;
      $post_id = wp_update_post($args, $wp_error);
      $num_updated++;
    }
    else {
      echo "Inserting: " . $location_post_id . ": " . $data['name'] ."<br />";
      $post_id = wp_insert_post($args, $wp_error);
      $num_created++;
    }
    if (!empty($post_id)) {
      update_post_meta( $post_id, '_import_record', $record, true );
      update_post_meta( $post_id, '_partner_id', $data['partner_id']);
      gmw_update_post_location( $post_id, $location, $user_id, '', true );
      gmw_update_post_location_meta($post_id, 'website', $data['website']);
      gmw_update_post_location_meta($post_id, 'phone', $data['public_number']);
    }
  }
  // output # of records inserted
  echo $num_updated . " records updated and " . $num_created . " records created.";
}

function location_import_get_record_values($headers, $record) {
  $data = array();
  foreach ($headers as $index => $value) {
    $data[$value] = isset($record[$index]) ? $record[$index] : '';
  }
  return $data;
}

function location_import_get_by_partner_id($partner_id = 0) {

  if (!empty($partner_id)) {
    $query = new WP_Query(array(
      'post_type' => array( 'partner_locations'),
      'meta_key' => '_partner_id',
      'meta_value' => $partner_id,
      'meta_compare' => '='
    ));
    if($query->have_posts()) {
      while($query->have_posts()) {
        $query->the_post();

        return get_the_ID();
      }
    }
  }
  return FALSE;
}
function location_import_process_headers($headers) {
  $allowed = array ('partner_id', 'name', 'hours', 'public_number', 'website', 'primary_service_type', 'address', 'city', 'zip_code', 'state', 'county', 'address_single_field');
  foreach ($headers as $key => $value) {
    $headers[$key] = header_to_key($value);
    if (!empty($headers[$key]) && !in_array($headers[$key], $allowed)) {
      return FALSE;
    }
  }
  return $headers;
}
function header_to_key($str, array $noStrip = [])
{
        // non-alpha and non-numeric characters become spaces
        $str = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $str);
        $str = trim($str);
        $str = str_replace(" ", "_", $str);
        $str = strtolower($str);

        return $str;
}

?>