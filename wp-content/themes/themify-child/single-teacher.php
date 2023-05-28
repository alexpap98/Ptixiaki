<?php
/**
 * The Template for displaying a single teacher
 *
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); 
    // init Values for teacher 
    $name = get_field('teacher_name');
    $teachingArea = get_the_terms( get_the_ID(), 'teaching_areas' );
    $image =  get_field('teacher_image'); 
  
    $lessons = get_posts(array(
      'post_type' => 'lesson',
      'meta_query' => array(
        array(
          'key' => 'lesson_teachingBy',
          'value' => '"' . get_the_ID() . '"',
          'compare' => 'LIKE'
        )
      )
    ));
    $email = get_field('teacher_email'); 
    $social = []; 

    // get a group field by id (εχω δευτερο group για τα social)
    $mediaGroup = acf_get_field_group('group_6461132e7b3db');

    if ($mediaGroup) :
      //εαν το βρει παιρνει ολα τα custom fields απο το ACF
      $media = acf_get_fields($mediaGroup['ID']);
      //εαν υπαρχουν 
      if ($media) :
        foreach($media as $link):
          //για το καθε ενα αν ειναι λινκ (θα είναι, απλα για σιγουρια!)
          if ($link['type'] === 'link'):
            //παιρνουμε τα στοιχεια του field 
            // πχ array (size=3)
            //    'title' => string 'title' 
            //    'url' => string 'url'
            //    'target' => string 'url_target'
            $currField = get_field($link['name']);
            // αν το βρει 
            if ($currField) : 
              // παιρνει το slug του field το property (name) για το fontawesome 
              // το slug ειναι ίδιο με το αυτο που εχει https://fontawesome.com/icons ωστε να μπαινουν αυτοματα τα icons
              // και το προσθέτει
              $currField["faID"] = $link["name"];
              // πλεον το currentField θα είναι καπως έτσι
              //  array (size=3)
              //    'title' => string 'title' 
              //    'url' => string 'url'
              //    'target' => string 'url_target'
              //    'faID' => string 'the name of the field'
              array_push($social, $currField);
              // τα βάζω σε ενα πινακα για να τα δείξω μετα
            endif;
          endif;
        endforeach;
      endif;
    endif;
?>

<div class="teacherContainer">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <div class="teacherInnerContainer">
    <!-- NAME -->
    <h2 class="teacherName"><?php  echo($name); ?></h2>
    <div class="teacherArea">
      <div class="teacherArea">
      <p><strong>Teaching areas: </strong>
      <?php 
        if ( $teachingArea && ! is_wp_error( $teachingArea ) ) {
          $term_names = array();
          foreach ( $teachingArea as $term ) {
            $term_names[] = $term->name;
          }
          echo implode( ', ', $term_names );
        }else{
          echo(' - ');
        }
      ?>
        </p>
      </div>
      <!-- img desc Container -->
    <div class="imgDescContainer">
      <div class="imgContainer">
        <!-- img -->
        <img src=<?php echo($image); ?>  alt="Oops"></img>
      </div>
      <!-- desc -->
      <div class="teacherDesc">
        <?php the_field('teacher_description'); ?>
      </div>
    </div>
    <dl>

      <dt>
      <span class="material-icons md-18">auto_stories</span>
        Μαθήματα που διδάσκει:
      </dt>
      <?php
        if( $lessons ): 
      ?>
      <dd>

        <?php 
          $numItems = count($lessons);
          $i = 0;
          foreach( $lessons as $lesson ): 
        ?>
            <a href="<?php echo get_permalink( $lesson->ID ); ?>"><?php echo get_field('lesson_title', $lesson->ID); ?></a>
        <?php 
          if(++$i !== $numItems) {
            echo ", ";
          }
          endforeach; 
        ?>
      </dd>
      <?php else :
        echo('<dd> - </dd>');
      endif; ?>
      <dt>
        <span class="material-icons md-18">email</span>
        E-mail
      </dt>
      <?php
        if( $lessons ): 
      ?>
        <dd>
          <a href = "mailto:<?php echo($email); ?> "><?php echo($email); ?> </a>
        </dd>
      <?php else :
        echo('<dd> - </dd>');
      endif; ?>
      <dt>
        <span class="material-icons md-18">public</span>
        Social
      </dt>
      <?php
        if($social){
          ?>
            <dd>
              <?php
                foreach ($social as $link) {
                  ?>
                    <a class="socialIcon" href="<?php echo( $link["url"] ); ?>" target="_blank"> <!-- target blank γιατι ανοίγει την καρτέλα απο τα social -->
                      <div class="innerIcon">
                        <?php 
                          echo('<i class="fa fa-'. $link["faID"] .'" aria-hidden="true"></i>');
                        ?>
                      </div> 
                    </a>
                  <?php
                }
              ?>
            </dd>
          <?php
        }else{
          echo('<dd> - </dd>');
        }
      ?>
      

    </dl>


    
  </div>
</div>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
