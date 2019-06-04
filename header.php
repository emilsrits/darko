<?php
/**
 * Template for displaying header
 *
 * @package Darko
 */

$navigation_transparency = get_theme_mod( 'darko_navigation_transparency' );
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="wrapper">
        <header <?php echo ( $navigation_transparency && $navigation_transparency != false ) ? 'class="nav-transparent"' : ''; ?>>
            <?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>
            <?php get_template_part( 'template-parts/header/header', 'image' ); ?>
        </header>