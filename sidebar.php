<?php
/**
 * Classic fallback sidebar.
 *
 * @package Agramlabs_Starter
 */

if ( 'none' === agramlabs_starter_get_sidebar_layout() ) {
	return;
}
?>
<aside class="sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'agramlabs-starter' ); ?>">
	<?php dynamic_sidebar( 'primary-sidebar' ); ?>
</aside>
