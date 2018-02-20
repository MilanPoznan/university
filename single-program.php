<?php

    //Treba za objasnjenje wp_reset_postdata()
    the_id();
  get_header();

  while(have_posts()) {
    the_post();
    heroSection();
    ?>


    <div class="container container--narrow page-section">
          <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Programs Home</a> <span class="metabox__main"><?php the_title(); ?></span></p>
      </div>

      <div class="generic-content"><?php the_content(); ?></div>
      <?php

      $relatedProfesors = new WP_Query(array(
          'post_per_page' => -1,
          'post_type' => 'profesor',
          'orderby' => 'title',
          'order' => 'ASC',
          'meta_query' => array(
              array(
                  'key' => 'related_programs',
                  'compare' => 'like',
                  'value' => '"' . get_the_ID() . '"'
              )
          )

      ));

      if ($relatedProfesors->have_posts()) {
          echo "<h2>Related Profesors</h2>";
          while ($relatedProfesors->have_posts()) {
             $relatedProfesors->the_post();
             ?>
             <li> <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); the_title(); ?></a> </li>
             <?php
          }
      }
      // get the id imamo 2 puta i tu ga buni, funkcija resetuje globalni query, kada runujem 2 ili vise querija na jednoj stranici uglavnom ce trebati ova funckija
      wp_reset_postdata();


          $today = date('Ymd');
          $upcomingEvents = new WP_Query(array(
          'posts_per_page' => 2,
          'post_type' => 'event',
          'meta_key' => 'event_date',
          'order_by' => 'meta_value_num',
          'order' => 'ASC',
          'meta_query' => array(
              array(
                  'key' => 'event_date',
                  'compare' => '>=',
                  'value' => $today,
                  'type' => 'numeric'
              ),
              array(
                  'key' => 'related_programs',
                  'compare' => 'LIKE',
                  'value'=> '"' . get_the_ID() .'"'

              )
          )
        ));


        if ($upcomingEvents->have_posts()) {
            echo '<h2> Upcoming ' . get_the_title() . ' Events</h2>';
            while($upcomingEvents->have_posts()) {
              $upcomingEvents->the_post();

                get_template_part('components/events');
                
           }
        }
          ?>

    </div>



  <?php }

  get_footer();

?>
