<?php

get_header();
heroSection( array(
        'title' => 'Nasi Kampovi',
        'subtitle' => 'Sve nase kampove mozete pronaci na mapi.'
    )
);

?>


<div class="container container--narrow page-section">
    <div class="acf-map">

        <?php
        while(have_posts()) {
            the_post();
            $mapLocation = get_field('campus_location');
            ?>
            <div class="markers" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng'] ?>">

            </div>
        <?php }
        echo paginate_links(); ?>

    </div>


</div>

<?php get_footer();

?>
