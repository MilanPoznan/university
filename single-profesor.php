<?php

  get_header();

  while(have_posts()) {
    the_post();
    heroSection();
    ?>


    <div class="container container--narrow page-section">

        <div class="generic-content">
            <?php the_post_thumbnail(); ?>
            <?php the_content(); ?>
        </div>



      <?php

      $relatedPrograms = get_field( 'related_programs' );

      if ($relatedPrograms) {
          echo "<h2>Related Programs</h2>";
          foreach ($relatedPrograms as $program ) { ?>

              <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
          <?php }

      }
      ?>
    </div>



  <?php }

  get_footer();

?>
