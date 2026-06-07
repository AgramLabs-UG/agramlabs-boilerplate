<?php
/**
 * Named theme hook helpers.
 *
 * @package Agramlabs_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function agramlabs_starter_before_header(): void {
	do_action( 'agramlabs_starter_before_header' );
}

function agramlabs_starter_after_header(): void {
	do_action( 'agramlabs_starter_after_header' );
}

function agramlabs_starter_before_main(): void {
	do_action( 'agramlabs_starter_before_main' );
}

function agramlabs_starter_after_main(): void {
	do_action( 'agramlabs_starter_after_main' );
}

function agramlabs_starter_before_footer(): void {
	do_action( 'agramlabs_starter_before_footer' );
}

function agramlabs_starter_after_footer(): void {
	do_action( 'agramlabs_starter_after_footer' );
}
