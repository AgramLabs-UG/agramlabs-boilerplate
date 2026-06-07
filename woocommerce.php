<?php
/**
 * WooCommerce fallback template.
 *
 * @package Agramlabs_Starter
 */

echo do_blocks( '<!-- wp:template-part {"slug":"header","tagName":"header"} /-->' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

if ( function_exists( 'woocommerce_content' ) ) {
	woocommerce_content();
}

echo do_blocks( '<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
