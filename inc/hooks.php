<?php
/**
 * Named theme hook helpers.
 *
 * @package Agramlabs_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function agramlabs_before_header(): void {
	do_action( 'agramlabs_before_header' );
}

function agramlabs_after_header(): void {
	do_action( 'agramlabs_after_header' );
}

function agramlabs_before_main(): void {
	do_action( 'agramlabs_before_main' );
}

function agramlabs_after_main(): void {
	do_action( 'agramlabs_after_main' );
}

function agramlabs_before_footer(): void {
	do_action( 'agramlabs_before_footer' );
}

function agramlabs_after_footer(): void {
	do_action( 'agramlabs_after_footer' );
}
