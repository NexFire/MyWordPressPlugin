<?php 
wp_enqueue_style('custom-css', plugins_url('style.css', __FILE__));
get_header(); 
?>

<main role="main">
    <?php while (have_posts()): the_post(); ?>
        <h1><?php the_title(); ?></h1>
        <div><?php the_post_thumbnail(); ?></div>
        <div>
            <?php the_content(); ?>
        </div>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>


