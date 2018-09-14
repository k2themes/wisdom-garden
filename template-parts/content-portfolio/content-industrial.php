<?php
/**
 * Template part for displaying posts in loop
 *
 * @package k2_prefix
 */
?>
<div class="container content-container">
    <div class="row">
        <div id="primary" class="content-area col-12">
            <main id="main" class="site-main">
                <div class="post-type-inner">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <div class="post-type-content">
                            <div class="post-type-content-inner">
                                <?php the_content(); ?>
                            </div>
                        </div>

                    <?php endwhile; ?>
                </div>
            </main><!-- #main -->
        </div><!-- #primary -->
    </div>
</div>