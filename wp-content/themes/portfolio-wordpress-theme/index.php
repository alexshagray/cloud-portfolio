<?php
/**
 * Fallback template: 404 page, blog posts, archives and search results.
 */
get_header();
?>

<?php if (is_404()): ?>

    <section class="page-hero page-hero-center">
        <div class="container text-center">
            <p class="big-404" aria-hidden="true">404</p>
            <h1 class="page-title">This page wandered off<span class="accent">.</span></h1>
            <p class="page-lead mx-auto">The link may be broken or the page may have moved. Let's get you back on track.</p>
            <div class="d-flex flex-wrap gap-3 justify-content-center mt-4">
                <a class="btn btn-burgundy" href="<?php echo esc_url(home_url('/')); ?>">Go home <span>↗</span></a>
                <a class="btn btn-outline-light btn-ghost" href="<?php echo esc_url(pe_page_url('projects')); ?>">See
                    projects <span>↗</span></a>
            </div>
        </div>
    </section>

<?php else: ?>

    <section class="page-hero">
        <div class="container">
            <p class="eyebrow">PORTFOLIO / JOURNAL</p>
            <h1 class="page-title">
                <?php
                if (is_search()) {
                    echo 'Results for ' . esc_html(get_search_query());
                } elseif (is_archive()) {
                    echo wp_kses_post(get_the_archive_title());
                } else {
                    echo 'Journal';
                }
                ?><span class="accent">.</span>
            </h1>
        </div>
    </section>

    <section class="content-section section-pad">
        <div class="container narrow-content">
            <?php if (have_posts()): ?>
                <?php while (have_posts()):
                    the_post(); ?>
                    <article <?php post_class('post-row'); ?>>
                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="body-copy"><?php the_excerpt(); ?></div>
                    </article>
                <?php endwhile; ?>
                <div class="pagination-wrap"><?php the_posts_pagination(); ?></div>
            <?php else: ?>
                <p class="body-copy">Nothing here yet.</p>
                <a class="btn btn-burgundy" href="<?php echo esc_url(home_url('/')); ?>">Back home <span>↗</span></a>
            <?php endif; ?>
        </div>
    </section>

<?php endif; ?>

<?php get_footer(); ?>