<?php

get_header();
heroSection();
?>


<div class="container container--narrow page-section">
<?php
$today = date('Ymd');
$homepageEvents = new WP_Query(array(
'posts_per_page' => -1,
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
)
));


  while($homepageEvents->have_posts()) {
    $homepageEvents->the_post();

        get_template_part('components/events');
        
 }
  echo paginate_links();
?>
<p>Looking for past events? Click <a href="<?php echo site_url('/past-events')?>">here</a></p>
</div>

<?php get_footer();

?>
