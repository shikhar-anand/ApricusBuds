<?php
/**
 * The template for displaying Wordpress Archives.
 *
 * Template Name: Wordpress Archives
 */

$template_router = WPDDL_Integration_Theme_Template_Router::get_instance();
$template_router->get_header();
the_ddlayout();
$template_router->get_footer();
