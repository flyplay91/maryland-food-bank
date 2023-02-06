<tr id="entry-id-<?php echo $entry->getRuid(); ?>" class="cn-entry">
<?php //var_dump($atts); ?>

	<td><?php $entry->getNameBlock( array( 'format' => $atts['name_format'], 'link' => $atts['link'] ) ); echo ', ' . $entry->getTitle(); ?></td>
	<td><?php echo $entry->getDepartment(); ?></td>

</tr>
