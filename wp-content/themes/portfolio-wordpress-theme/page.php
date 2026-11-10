<?php
/**
 * Default page template.
 * About, Projects, Contact and Privacy Policy get their designed content
 * automatically (see functions.php). Any text you add in the WordPress
 * editor appears below it; every other page just shows its editor content.
 */
get_header();

$pe_slug = get_post_field('post_name', get_queried_object_id());

$pe_intro = array(
    'about' => 'Four people, four crafts, one shared standard. Here is who we are and how we work.',
    'projects' => 'A selection of design, development and research work. Filter by discipline, or follow the coloured names to see who worked on what.',
    'contact' => 'Have a project, a question or just an idea you are not sure about? Write to us. A real person from the team will answer.',
);
?>

<?php while (have_posts()):
    the_post(); ?>

    <section class="page-hero">
        <div class="container">
            <p class="eyebrow reveal">PORTFOLIO / <?php the_title(); ?></p>
            <h1 class="page-title reveal"><?php the_title(); ?><span class="accent">.</span></h1>
            <?php if (isset($pe_intro[$pe_slug])): ?>
                <p class="page-lead reveal"><?php echo esc_html($pe_intro[$pe_slug]); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <?php
    if ('about' === $pe_slug) {
        pe_render_about();
    } elseif ('projects' === $pe_slug) {
        pe_render_projects();
    } elseif ('contact' === $pe_slug) {
        pe_render_contact();
    }

    $pe_has_content = trim(wp_strip_all_tags(get_the_content())) !== '';
    $pe_designed = in_array($pe_slug, array('about', 'projects', 'contact'), true);

    if ($pe_has_content || !$pe_designed): ?>
        <section class="content-section section-pad">
            <div class="container narrow-content">
                <div class="wp-content body-copy"><?php the_content(); ?></div>
            </div>
        </section>
    <?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>