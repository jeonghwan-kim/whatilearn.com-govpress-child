<?php
/**
 * @package GovPress
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title-list"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta entry-meta-list">
			<span class="post-date">
        <?php govpress_posted_on(); ?>
      </span>
      <span class="categories">
				<?php govpress_category(); ?>
      </span>
      <span class="tags">
				<?php govpress_tags(); ?>
      </span>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
</article><!-- #post-## -->
