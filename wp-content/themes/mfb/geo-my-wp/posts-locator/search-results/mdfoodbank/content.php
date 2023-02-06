<?php
/**
 * MDFoodBank - Results Page.
 * @version 1.0
 * @author WebConnection
 */
?>

<?php if ( $gmw_form->has_locations() ) : ?>
	<!-- Map -->
	<section>
		<div class="map-overlay" onClick="style.pointerEvents='none'"></div>
		<?php gmw_results_map( $gmw ); ?>
	</section>
	<!--  Main results wrapper - wraps the paginations, map and results -->

	<?php
		$results = array();
		// prepare posts array. Necessary for the div/table output below.
		while ($gmw_query->have_posts()) {
			$gmw_query->the_post();
			global $post;
			$posts[$post->ID] = $post;
			$results[$post->ID] = array(
				'post' => $post
			);
		}
	?>
	<div id="need-food-returns" class="gmw-results">
		<div class="gmw-results-list">
			<?php foreach ($results as $result): ?>
				<?php $post = $result['post']; ?>
				<div class="return open-sans">
					<div class="col-clear">
						<div class="address">
							<p>
								<h3><?php echo stripslashes(get_the_title($post->ID)); ?></h3>
								<?php $distance = gmw_get_distance_to_location( $post); ?>
								<?php if (!empty($distance)): ?>
									<div class="gmw-driving-distance gmw-pt-driving-distance">
										<span class="label">Driving Distance:</span> <span class="distance"><?php print $distance; ?></span>
									</div>
								<?php endif; ?>
								<div class="address-wrapper">
									<?php gmw_search_results_address( $post, $gmw ); ?>
								</div>
								<p>
									<?php gmw_search_results_location_meta( $post, $gmw, false); ?>
								</p>
								<p>
									<div class="details">
										<?php echo apply_filters('the_content', get_post_field('post_content', $post->ID)) ?>
									</div>
								</p>
								<div class="button-group">
									<?php gmw_search_results_directions_link( $post, $gmw ); ?>
								</div>
							</p>
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
					<?php foreach ($results as $result): ?>
						<?php $post = $result['post']; ?>
						<tr>
							<td class="result-left"></td>
							<td class="result-name">
								<h3><?php echo stripslashes(get_the_title($post->ID)); ?></h3>
							</td>
							<td class="result-address">
								<div class="address-wrapper">
									<?php gmw_search_results_address( $post, $gmw ); ?>
								</div>
								<p>
									<?php gmw_search_results_location_meta( $post, $gmw, false); ?>
								</p>
							</td>
							<td class="result-hours">
								<?php echo apply_filters('the_content', get_post_field('post_content', $post->ID)) ?>
							</td>
							<td class="result-details">
									<?php $distance = gmw_get_distance_to_location( $post); ?>
									<?php if (!empty($distance)): ?>
										<div class="gmw-driving-distance gmw-pt-driving-distance">
											<span class="label">Driving Distance:</span> <span class="distance"><?php print $distance; ?></span>
										</div>
									<?php endif; ?>
									<?php gmw_search_results_directions_link( $post, $gmw ); ?>
							</td>
							<td class="result-right"></td>
						</tr>
						<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div> <!--  results wrapper -->

	<div id="gmw-pt-pagination" class="gmw-pt-pagination-wrapper gmw-pt-bottom-pagination-wrapper clearfix">
		<?php gmw_per_page( $gmw, $gmw['total_results'], 'paged' ); ?>
		<?php gmw_pagination( $gmw, 'paged', $gmw['max_pages'] ); ?>
	</div>
<?php else: ?>
	<div class="section">
		<div class="compartment">
			<h3 style="text-align: center;">No results were found within that distance. Please select a wider range and try again.</h3>
		</div>
	</div>
<?php endif; ?>