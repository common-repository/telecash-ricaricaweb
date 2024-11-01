<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php if ( 'tcrw_section-basic' == $section['id'] ) : ?>

	<p>Your Telecash Account data.</p>

<?php elseif ( 'tcrw_section-advanced' == $section['id'] ) : ?>

	<p>Operative parameters.</p>

<?php elseif ( 'tcrw_section-instances' == $section['id'] ) : ?>

	<p>You can define multiple instances of RIcaricaweb for different services.</p>

<?php endif; ?>
