<?php if(get_option( 'wp_ecards_credit', false )) { ?>
    <input type="button" onclick="location.href='?page=wp-ecards-admin&giveCredit=0';" value="Disable link back to my site :(" class="button-secondary" />
<?php } else { ?>
    <input type="button" onclick="location.href='?page=wp-ecards-admin&giveCredit=1';" value="Enable link back to my site :)" class="button-primary" />
<?php } ?>