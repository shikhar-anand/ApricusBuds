<?php
/**
 * The template for '404 - Not Found' pages.
 *
 * Template Name: Error 404 Page
 */

$template_router = WPDDL_Integration_Theme_Template_Router::get_instance();
$template_router->get_header();
the_ddlayout();
$template_router->get_footer();
