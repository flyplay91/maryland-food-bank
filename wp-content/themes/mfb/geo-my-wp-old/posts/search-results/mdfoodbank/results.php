<?php
/**
 * MDFoodBank - Results Page.
 * @version 1.0
 * @author WebConnection
 */
?>

<!-- Map -->
<section>
	<div class="map-overlay" onClick="style.pointerEvents='none'"></div>
	<?php gmw_results_map( $gmw ); ?>
	<img class="gmw-map-loader" src="<?php echo GMW_URL; ?>/images/map-loader.gif" style="position:absolute;top:45%;left:33%;"/>
</section>
<!--  Main results wrapper - wraps the paginations, map and results -->

<?php
	$results = array();
	// prepare posts array
	while ($gmw_query->have_posts()) {
		$gmw_query->the_post();

		if (empty($post->state)){
			if (preg_match('/\s([A-Z]{2})\s/', $post->address, $matches)){
				$post->state = $matches[1];
			}
		}
		$posts[$post->ID] = $post;
		$post_hours[$post->ID] = array();

		// Get Hours
		$fields = get_post_custom($post->ID);

		$j = preg_replace('/a\:[\d]+/', '', $fields['_wppl_days_hours'][0]);
		$j = preg_replace('/s\:[\d]+/', '', $j);
		$j = preg_replace('/i\:[\d]+/', '', $j);
		$j = preg_replace('/\;/', '', $j);
		$j = preg_replace('/\:\{/', '{', $j);
		$j = preg_replace('/\{\:/', '{', $j);
		$j = preg_replace('/\}\:/', '}', $j);
		$j = preg_replace('/\}\}/', '}', $j);
		$j = preg_replace('/\{\{/', '{', $j);
		$j = preg_replace('/\:\"hours\"/', ',"hours"', $j);

		$json = '[]';
		if (preg_match_all('/\{([^\}]+)\}/', $j, $matches)){
			$json = '[' . implode(',', $matches[0]) . ']';
		}

		$results[$post->ID] = array(
			'post' => $post,
			'hours' => json_decode($json),
		);

	}
?>
<div id="need-food-returns" class="gmw-results">
	<div class="gmw-results-list">
		<?php $cnt = $gmw['post_count']-1; ?>
		<?php foreach ($results as $result): ?>
			<?php $post = $result['post']; ?>
			<?php $hours = $result['hours']; ?>
			<?php $cnt++; ?>
			<div class="return open-sans">
				<div class="col-clear">
					<div class="address">
						<p>
							<h3><?php echo $cnt ?>) <?php echo stripslashes(get_the_title($post->ID)); ?></h3>
							<?php gmw_pt_driving_distance($gmw, $post, $class='wppl-driving-distance', $title = __( 'Distance Away: ', 'GMW' )); ?>
							<?php // Stopped using custom fields due to plugin update ?>
							<?php $args = array('info'  => 'street', 'post_id' => $post->ID,  'divider' => ',' ); ?>
							<?php gmw_post_info( $args ); ?><br />
							<?php $args = array('info'  => 'city,state', 'post_id' => $post->ID,  'divider' => ', ' ); ?>
							<?php gmw_post_info( $args ); ?>
							<?php $args = array('info'  => 'zipcode', 'post_id' => $post->ID,  'divider' => '' ); ?>
							<?php gmw_post_info( $args ); ?>

							<?php //echo htmlentities(str_replace("\\'", "'", $post->street)); ?>
							<?php //echo (!empty($post->apt)) ? htmlentities(str_replace("\\'", "'", $post->apt)) . '<br />' : ''; ?>
							<?php //echo htmlentities(str_replace("\\'", "'", $post->city)) . ', ' . $post->state . ' ' . $post->zipcode; ?>
							<?php echo (!empty($post->phone)) ? '<br />' . $post->phone : ''; ?>
							<?php echo (!empty($post->fax)) ? '<br />Fax: ' . $post->fax : ''; ?>
							<br /><?php //gmw_pt_directions($gmw, $post, $title='Get Directions'); ?>
							<p>
								<div class="details">
									<?php echo apply_filters('the_content', get_post_field('post_content', $post->ID)) ?>
								</div>
							</p>
							<div class="button-group">
								<a class="button" href="http://maps.google.com/maps?f=d&region=US&doflg=ptm&geocode=&saddr=&daddr=<?php $args = array('info'  => 'street', 'post_id' => $post->ID,  'divider' => '' ); gmw_post_info( $args ); ?>, <?php $args = array('info'  => 'city', 'post_id' => $post->ID,  'divider' => '' ); gmw_post_info( $args ); ?>&ie=UTF8&z=12" target="_blank">Get Directions</a>
								<?php echo (!empty($post->email)) ? '<a class="button" href="mailto:' . $post->email . '">Send E-Mail</a>' : ''; ?>
								<?php echo (!empty($post->website)) ? '<a class="button" href="' . $post->website . '" target="_blank">Visit Website</a>' : ''; ?>
							</div>
						</p>
						<?php if (!empty($hours)) :?>
							<p class="operation-hours">
								<?php foreach ($hours as $dh) : ?>
								<?php if (!empty($dh->days)) : ?>
								<?php echo $dh->days . ' ' . $dh->hours . '<br>'; ?>
								<?php endif; ?>
								<?php endforeach; ?>
							</p>
						<?php endif; ?>
					</div>
				</div>
			</div>

		<?php endforeach; ?>
	</div>

	<div class="gmw-results-table">
		<table>
			<thead>
				<tr>
					<th></th>
					<th>Location Name</th>
					<th>Address/Phone</th>
					<th>Hours</th>
					<th>Distance Away</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php $cnt = $gmw['post_count']-1; ?>
				<?php foreach ($results as $result): ?>
					<?php $post = $result['post']; ?>
					<?php $hours = $result['hours']; ?>
					<?php $cnt++; ?>
					<tr>
						<td class="result-left"></td>
						<td class="result-name">
							<h3><?php echo $cnt ?>. <?php echo stripslashes(get_the_title($post->ID)); ?></h3>
							<?php echo (!empty($post->email)) ? '<a href="mailto:' . $post->email . '">Send E-Mail</a>' : ''; ?>
							<?php echo (!empty($post->website)) ? '<a href="' . $post->website . '" target="_blank">Visit Website</a>' : ''; ?>
						</td>
						<td class="result-address">
							<p>
							<?php $args = array('info'  => 'street', 'post_id' => $post->ID,  'divider' => ',' ); ?>
							<?php gmw_post_info( $args ); ?><br />
							<?php $args = array('info'  => 'city,state', 'post_id' => $post->ID,  'divider' => ', ' ); gmw_post_info( $args ); ?> <?php $args = array('info'  => 'zipcode', 'post_id' => $post->ID,  'divider' => '' ); ?>
							<?php gmw_post_info( $args ); ?>
							<?php //echo htmlentities(str_replace("\\'", "'", $post->street)); ?>
							<?php //echo (!empty($post->apt)) ? htmlentities(str_replace("\\'", "'", $post->apt)) . '<br />' : ''; ?>
							<?php //echo htmlentities(str_replace("\\'", "'", $post->city)) . ', ' . $post->state . ' ' . $post->zipcode; ?>
							<?php echo (!empty($post->phone)) ? '<br />' . $post->phone : ''; ?>
							<?php echo (!empty($post->fax)) ? '<br />Fax: ' . $post->fax : ''; ?>
							</p>
						</td>
						<td class="result-hours">
							<?php if (!empty($hours)) :?>
								<?php foreach ($hours as $dh) : ?>
									<?php if (!empty($dh->days)) : ?>
										<?php echo $dh->days . ' ' . $dh->hours . '<br>'; ?>
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
							<?php echo apply_filters('the_content', get_post_field('post_content', $post->ID)) ?>
						</td>
						<td class="result-details">
								<?php gmw_pt_driving_distance($gmw, $post, $class='wppl-driving-distance', $title = __( 'Driving Distance: ', 'GMW' )); ?>
								<?php //gmw_pt_directions($gmw, $post, $title='Get Directions'); ?>
								<div class="button-group">
									<a class="button" href="http://maps.google.com/maps?f=d&region=US&doflg=ptm&geocode=&saddr=&daddr=<?php $args = array('info'  => 'street', 'post_id' => $post->ID,  'divider' => '' ); gmw_post_info( $args ); ?>, <?php $args = array('info'  => 'city', 'post_id' => $post->ID,  'divider' => '' ); gmw_post_info( $args ); ?>&ie=UTF8&z=12" target="_blank">Get Directions</a>
								</div>
						</td>
						<td class="result-right"></td>
					</tr>
					<?php endforeach; ?>
			</tbody>
		</table>
	</div>

</div> <!--  results wrapper -->

<div id="gmw-pt-pagination" class="gmw-pt-pagination-wrapper gmw-pt-bottom-pagination-wrapper clearfix">
	<?php gmw_pt_per_page_dropdown( $gmw, '' ); ?><?php gmw_pt_paginations( $gmw ); ?>
</div>



