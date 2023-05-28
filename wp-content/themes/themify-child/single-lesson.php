<?php
/**
 * The Template for displaying a single lesson
 *
 */

function enqueue_parent_theme_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_styles' );


get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
  <?php 
    $lesson_title = get_field('lesson_title');
    $lesson_desc = get_field('lesson_description');
    $lesson_img = get_field('lesson_image');
    $lesson_teachingBy = get_field('lesson_teachingBy');
    $lesson_subjects = get_the_terms( get_the_ID(), 'subjects' );

  ?>
  <div class="featured-area fullcover">
    <div class="post-content-inner-wrapper">
      <div class="post-content-inner">
        <h2 class="post-title entry-title"><?php echo $lesson_title; ?></h2>
      </div>
    </div>
  </div>
  <div id="layout" class="pagewidth">
    <main id="content" class="list-post">
      <p class="post tf_clearfix post-572 lesson type-lesson status-publish hentry subjects-subject2 has-post-title has-post-date has-post-category has-post-tag has-post-comment has-post-author "><?php echo $lesson_desc; ?></p>
      <!-- <img src="<?php echo $lesson_img['url']; ?>" alt="<?php echo $lesson_img['alt']; ?>"> -->
      <?php if ($lesson_teachingBy): ?>
        <p>Teaching by: 
          <?php foreach ($lesson_teachingBy as $teacher): ?>
            <a href="<?php echo get_permalink($teacher->ID); ?>"><?php echo $teacher->post_title; ?></a>
            <?php if ($teacher !== end($lesson_teachingBy)) echo ', '; ?>
          <?php endforeach; ?>
        </p>
      <?php endif; ?>
      
      <?php if ($lesson_subjects && !is_wp_error($lesson_subjects)): ?>
        <p>Subjects:</p>
        <ul>
          <?php foreach ($lesson_subjects as $term): ?>
            <li><?php echo $term->name; ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </main>
  </div>

        
        
 
<?php endwhile; // end of the loop. ?>



<?php get_footer(); ?>
