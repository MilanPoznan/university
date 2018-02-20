<?php

function university_files() {

    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyA8J2CghOvVSvd38E3ArzYGW5oy3SeBHKk', NULL, '1.0', true);
    wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_stylesheet_uri());

}

add_action('wp_enqueue_scripts', 'university_files');

function university_features() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');


    add_image_size('profesor-landsape', '400', '260', true);
    add_image_size('profesor-portrait', '480', '650', true);
    add_image_size('hero-image', '1500', '350', true );
}

function heroSection( $args = NULL ) {

    if (!$args['title']) {
        $args['title'] = get_the_title();
    }

    if (!$args['subtitle']) {
        $args['subtitle'] = get_field('hero_subtitle');
    }
    if (!$args['photo']) {
        if (get_field('hero_image_background')) {
            $args['photo'] = get_field('hero_image_background')['sizes']['hero-image'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/hero.jpeg');
        }
    }

    ?>
    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
        <div class="page-banner__intro">
          <p> <?php echo $args['subtitle']; ?></p>
        </div>
      </div>
    </div>
    <?php
}

add_action('after_setup_theme', 'university_features');

//Nesto nije kako treba
function university_adjust_queries( $query ) {
if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query() ) {
        $today = date('Ymd');
        // var_dump($today);die();
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_qery', array(
            array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric',
            )
        ));
    }
    if (!is_admin() AND is_post_type_archive('program') AND $query->is_main_query() ) {

        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', '-1');
    }

}
//pre_get_posts daje zadnju rec, znaci pre nego sto da postove ureadi funkciju
add_action('pre_get_posts', 'university_adjust_queries');

function my_acf_init() {

	acf_update_setting('google_api_key', 'AIzaSyA8J2CghOvVSvd38E3ArzYGW5oy3SeBHKk');
}

add_action('acf/init', 'my_acf_init');
