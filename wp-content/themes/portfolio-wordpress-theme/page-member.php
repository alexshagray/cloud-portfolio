<?php
/* Template Name: Member Profile */

get_header();

$slug = get_post_field('post_name', get_the_ID());
$members = portfolio_elegant_member_data();

if (!isset($members[$slug])) {
    $slug = key($members);
}

$m = $members[$slug];

$member_slugs = array_keys($members);
$current_index = array_search($slug, $member_slugs, true);
$count = count($member_slugs);

// Previous / next wrap around, so every profile always has both links.
$previous_slug = $member_slugs[($current_index + $count - 1) % $count];
$next_slug = $member_slugs[($current_index + 1) % $count];

$my_projects = array();
foreach (pe_projects() as $pi => $project) {
    if (in_array($slug, $project['members'], true)) {
        $my_projects[$pi] = $project;
    }
}
?>

<div class="member-profile <?php echo esc_attr($slug); ?>">

    <section class="page-hero member-hero">
        <div class="container">

            <a class="back-link reveal" href="<?php echo esc_url(home_url('/')); ?>#members">← ALL MEMBERS</a>

            <p class="eyebrow reveal">
                THE COLLECTIVE / MEMBER <?php echo esc_html($m['number']); ?>
            </p>

            <h1 class="page-title reveal">
                <?php echo esc_html($m['name']); ?><span class="accent">.</span>
            </h1>

            <p class="member-role-large reveal">
                <?php echo esc_html($m['role']); ?>
            </p>

            <p class="member-tagline reveal"><?php echo esc_html($m['tagline']); ?></p>

        </div>
    </section>


    <section class="section-pad">

        <div class="container">

            <div class="row g-5 align-items-start">

                <div class="col-lg-5">

                    <div class="profile-art reveal">

                        <span><?php echo esc_html($m['number']); ?></span>

                        <?php if (has_post_thumbnail()): ?>

                            <?php
                            the_post_thumbnail(
                                'large',
                                array(
                                    'class' => 'profile-photo',
                                    'loading' => 'lazy',
                                    'alt' => esc_attr($m['name'])
                                )
                            );
                            ?>

                        <?php else: ?>

                            <strong>
                                <?php echo esc_html(mb_substr($m['name'], 0, 1)); ?>
                            </strong>

                        <?php endif; ?>

                    </div>

                </div>


                <div class="col-lg-7 pt-lg-2">

                    <div class="section-kicker reveal">
                        A LITTLE INTRODUCTION
                    </div>

                    <h2 class="section-heading reveal">
                        The person<br>
                        <span class="muted-heading">behind the work.</span>
                    </h2>

                    <p class="body-copy mt-4 reveal">
                        <?php echo esc_html($m['bio']); ?>
                    </p>

                    <?php if (!empty($m['bio2'])): ?>
                        <p class="body-copy reveal">
                            <?php echo esc_html($m['bio2']); ?>
                        </p>
                    <?php endif; ?>

                    <?php
                    // Anything added in the WordPress editor appears below the bio.
                    while (have_posts()):
                        the_post();
                        if (trim(wp_strip_all_tags(get_the_content())) !== ''):
                            ?>
                            <div class="wp-content body-copy reveal"><?php the_content(); ?></div>
                            <?php
                        endif;
                    endwhile;
                    ?>

                    <div class="row g-4 mt-4">

                        <div class="col-md-6 reveal">
                            <div class="section-kicker">QUICK FACTS</div>
                            <dl class="fact-list">
                                <?php foreach ($m['facts'] as $label => $value): ?>
                                    <div>
                                        <dt><?php echo esc_html($label); ?></dt>
                                        <dd><?php echo esc_html($value); ?></dd>
                                    </div>
                                <?php endforeach; ?>
                            </dl>
                        </div>

                        <div class="col-md-6 reveal" data-delay="1">
                            <div class="section-kicker">SKILLS &amp; EXPERTISE</div>
                            <ul class="skill-bars">
                                <?php foreach ($m['levels'] as $skill => $level): ?>
                                    <li>
                                        <div class="skill-row">
                                            <span><?php echo esc_html($skill); ?></span><span><?php echo (int) $level; ?>%</span>
                                        </div>
                                        <div class="skill-track"><i style="--w:<?php echo (int) $level; ?>%"></i></div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    </div>

                    <div class="skill-list reveal">

                        <?php foreach ($m['skills'] as $skill): ?>

                            <span>
                                <?php echo esc_html($skill); ?>
                            </span>

                        <?php endforeach; ?>

                    </div>

                    <div class="mt-5 reveal">

                        <a class="btn btn-burgundy"
                            href="<?php echo esc_url(add_query_arg('for', $slug, pe_page_url('contact'))); ?>#contact-form">
                            Work with <?php echo esc_html($m['first']); ?> <span>↗</span>
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <?php if ($my_projects): ?>
        <section class="dark-section section-pad">
            <div class="container">
                <div class="section-topline reveal">
                    <div class="section-kicker">WORK</div>
                    <span class="small-note">PROJECTS WITH <?php echo esc_html(strtoupper($m['first'])); ?></span>
                </div>
                <div class="row g-4 mt-3">
                    <?php foreach ($my_projects as $pi => $project): ?>
                        <div class="col-lg-4">
                            <?php pe_project_card($project, $pi); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>


    <section class="member-pager-section">
        <div class="container">
            <div class="member-pagination">

                <a class="pager-link <?php echo esc_attr($previous_slug); ?>"
                    href="<?php echo esc_url(pe_member_url($previous_slug)); ?>">
                    <span>← PREVIOUS MEMBER</span>
                    <strong><?php echo esc_html($members[$previous_slug]['name']); ?></strong>
                </a>

                <a class="pager-link pager-next <?php echo esc_attr($next_slug); ?>"
                    href="<?php echo esc_url(pe_member_url($next_slug)); ?>">
                    <span>NEXT MEMBER →</span>
                    <strong><?php echo esc_html($members[$next_slug]['name']); ?></strong>
                </a>

            </div>
        </div>
    </section>

</div>

<?php get_footer(); ?>