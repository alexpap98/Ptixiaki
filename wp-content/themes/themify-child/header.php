<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<script src="https://use.fontawesome.com/f6e28583ab.js"></script>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php themify_body_start(); // hook ?>

	<div id="pagewrap" class="hfeed site">

		<div id="headerwrap">

			<?php themify_header_before(); // hook ?>

			<header id="header" class="pagewidth tf_clearfix">

				<?php themify_header_start(); // hook ?>

				<?php echo themify_logo_image(),themify_site_description(); ?>

				<div id="menu-wrapper">
					
					<?php if ( ! themify_check( 'setting-exclude_search_form' ) ) : ?>
						<div id="searchform-wrap">
							<?php get_search_form(); ?>
						</div>
						<!-- /#searchform-wrap -->
					<?php endif; ?>

					
					

					
             		<nav id="main-nav-wrap" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement">
						<ul id="main-nav" class="main-nav tf_clearfix tf_box" data-init="true" data-edge="true">
							<?php
							// Retrieve the subjects
							$subjects = get_terms( array(
							'taxonomy' => 'subjects',
							'hide_empty' => false,
							) );

							// Loop through the subjects
							foreach ( $subjects as $subject ) :
							$subject_url = get_term_link( $subject );
							?>
							<li id="subject_<?php echo esc_attr( $subject->term_id ); ?>" class="menu-item menu-item-type-taxonomy menu-item-object-subjects menu-item-has-children">
								<a href="<?php echo esc_url( $subject_url ); ?>"><?php echo esc_html( $subject->name ); ?></a>

								<?php
								// Retrieve the lessons for this subject
								$lessons = get_posts( array(
								'post_type' => 'lesson',
								'tax_query' => array(
									array(
									'taxonomy' => 'subjects',
									'field' => 'term_id',
									'terms' => $subject->term_id,
									),
								),
								) );

								// If there are any lessons, display them as a submenu
								if ( ! empty( $lessons ) ) :
								?>
								<ul class="sub-menu">
									<?php
									// Loop through the lessons
									foreach ( $lessons as $lesson ) :
									$lesson_url = get_permalink( $lesson );
									?>
									<li id="lesson_<?php echo esc_attr( $lesson->ID ); ?>" class="menu-item menu-item-type-post_type menu-item-object-page">
										<a href="<?php echo esc_url( $lesson_url ); ?>"><?php echo esc_html( $lesson->post_title ); ?></a>
									</li>
									<?php
									endforeach;
									?>
								</ul>
								<?php
								endif;
								?>
							</li>
							<?php
							endforeach;
							?>
							<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children has-sub-menu" aria-haspopup="true">
								<a>Teachers <span class="child-arrow"></span></a>
								<ul class="sub-menu">
									<?php
									$teaching_areas = get_terms( 
										array(
											'taxonomy' => 'teaching_areas',
											'hide_empty' => false,
										) 
									);

									foreach ( $teaching_areas as $teaching_area ) {
										$args = array(
											'post_type' => 'teacher',
											'tax_query' => array(
												array(
													'taxonomy' => 'teaching_areas',
													'field'    => 'term_id',
													'terms'    => $teaching_area->term_id,
												),
											),
										);
										$teachers = get_posts($args);
									?>
									<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children has-sub-menu" aria-haspopup="true">
										<a href="<?php echo get_term_link( $teaching_area ); ?>"><?php echo $teaching_area->name; ?><span class="child-arrow"></span></a>
										<?php if ( ! empty( $teachers ) ) :?>
											<ul class="sub-menu">
											<?php foreach ( $teachers as $teacher ) { ?>
												<li class="menu-item menu-item-type-post_type">
													<a href="<?php echo get_permalink( $teacher ); ?>"><?php echo $teacher->post_title; ?></a>
												</li>
											<?php } ?>
											</ul>
										<?php endif ?>
									</li>
									<?php } ?>
								</ul>
							</li>
						</ul>
					</nav>

					<!-- /#main-nav -->

				</div>
				<!-- /#menu-wrapper -->
				
				<a id="menu-icon" href="#mobile-menu"><span class="menu-icon-inner"></span></a>

				<div id="mobile-menu" class="sidemenu sidemenu-off tf_scrollbar">

					<?php themify_mobile_menu_start(); // hook ?>

					<div class="slideout-widgets">
						<?php dynamic_sidebar( 'slideout-widgets' ); ?>
						<a id="menu-icon-close" href="#mobile-menu"></a>
					</div>
					<!-- /.slideout-widgets -->

					<?php themify_mobile_menu_end(); // hook ?>

				</div>
				<!-- /#mobile-menu -->
				<?php themify_header_end(); // hook ?>

			</header>
			<!-- /#header -->

			<?php themify_header_after(); // hook ?>

		</div>
		<!-- /#headerwrap -->

		<div id="body" class="tf_clearfix">

			<?php themify_layout_before(); //hook 
