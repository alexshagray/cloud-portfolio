<?php
/**
 * Portfolio: Modern & Elegant. Theme functions.
 *
 * Sections:
 *  1. Setup & assets
 *  2. Editable content (members, projects, values, process, FAQ)
 *  3. Customizer options
 *  4. Helpers & reusable markup
 *  5. Page content renderers (About, Projects, Contact, Privacy)
 *  6. First-run setup (creates pages automatically)
 *  7. Contact form
 *  8. SEO / social tags
 */

if (!defined('ABSPATH')) {
    exit;
}

define('PE_VERSION', '2.0.0');

/* ==========================================================================
   1. SETUP & ASSETS
   ========================================================================== */

function portfolio_elegant_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');

    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'portfolio-elegant')
    ));
}
add_action('after_setup_theme', 'portfolio_elegant_setup');


/** Use the file's modified time as the version, so edits are never cached. */
function pe_asset_version($relative_path)
{
    $file = get_stylesheet_directory() . $relative_path;
    return file_exists($file) ? (string) filemtime($file) : PE_VERSION;
}

function portfolio_elegant_assets()
{
    wp_enqueue_style(
        'portfolio-bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        array(),
        '5.3.3'
    );

    wp_enqueue_style(
        'portfolio-fonts',
        'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:ital,opsz,wght@1,9..144,400;1,9..144,600&family=Manrope:wght@400;500;600;700;800&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'portfolio-theme',
        get_stylesheet_directory_uri() . '/assets/css/theme.css',
        array('portfolio-bootstrap'),
        pe_asset_version('/assets/css/theme.css')
    );

    wp_enqueue_script(
        'portfolio-bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        array(),
        '5.3.3',
        true
    );

    wp_enqueue_script(
        'portfolio-theme',
        get_stylesheet_directory_uri() . '/assets/js/theme.js',
        array(),
        pe_asset_version('/assets/js/theme.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'portfolio_elegant_assets');


/** Faster Google Fonts loading. */
function pe_resource_hints($urls, $relation_type)
{
    if ('preconnect' === $relation_type) {
        $urls[] = 'https://fonts.googleapis.com';
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
    }
    return $urls;
}
add_filter('wp_resource_hints', 'pe_resource_hints', 10, 2);


/* ==========================================================================
   2. EDITABLE CONTENT
   Change the text below and the whole website updates.
   Replace the placeholder bios, skills and projects with your real ones.
   ========================================================================== */

/**
 * The four members. The array key MUST match the member page slug.
 */
function portfolio_elegant_member_data()
{
    return array(
        'member-1' => array(
            'number' => '01',
            'name' => 'Rein Ejercito',
            'first' => 'Rein',
            'role' => 'Programmer',
            'tagline' => 'Building scalable logic behind seamless digital experiences.',
            'bio' => 'Welcome to my personal portfolio. Here you can discover my background, skills, interests, and projects. I enjoy exploring technology and developing creative digital solutions.',
            'bio2' => 'I enjoy the moment a rough idea becomes something you can click, scroll and share. Curiosity leads the way, and careful, readable code keeps it standing.',
            'skills' => array('Creativity', 'System Development', 'Leadership'),
            'levels' => array(
                'Creativity' => 92,
                'System development' => 88,
                'Leadership' => 90,
                'Learning new tools' => 85,
            ),
            'facts' => array(
                'Focus' => 'Creative system implementation',
                'Working style' => 'Try it, test it, improve it',
                'Currently exploring' => 'Interactive, motion-driven interfaces',
            ),
            'accent' => '#C75A78'
        ),

        'member-2' => array(
            'number' => '02',
            'name' => 'Michelle Macas',
            'first' => 'Michelle',
            'role' => 'Project Manager',
            'tagline' => 'Aligning scope, driving schedules, delivering results.',
            'bio' => 'Explore my personal journey, creative interests, skills, and accomplishments. I enjoy expressing ideas through design, collaboration, and meaningful digital experiences.',
            'bio2' => 'I care about the small decisions: spacing, colour, and the tone of a layout. Good design should feel effortless to the person using it, even when it took many drafts to get there.',
            'skills' => array('Creativity', 'Design', 'Communication'),
            'levels' => array(
                'Creativity' => 94,
                'Visual design' => 90,
                'Communication' => 88,
                'Attention to detail' => 92,
            ),
            'facts' => array(
                'Focus' => 'Project control & Scheduling',
                'Working style' => 'Sketch loose, refine carefully',
                'Currently exploring' => 'Colour systems and typography',
            ),
            'accent' => '#B49AE8'
        ),

        'member-3' => array(
            'number' => '03',
            'name' => 'Ashlee Heather Ranay',
            'first' => 'Ashlee',
            'role' => 'Systems Analyst',
            'tagline' => 'Optimizing systems, simplifying workflows, elevating outcomes.',
            'bio' => 'Discover my experiences, professional interests, skills, and selected works. I value continuous learning, research, and working with others to create meaningful results.',
            'bio2' => 'I bring patience and structure to every project: asking the right questions, gathering evidence and turning findings into clear next steps for the group.',
            'skills' => array('Creativity', 'Research', 'Collaboration'),
            'levels' => array(
                'Creativity' => 88,
                'Research' => 93,
                'Collaboration' => 91,
                'Analysis & planning' => 86,
            ),
            'facts' => array(
                'Focus' => 'Analysis & Development',
                'Working style' => 'Question first, then build',
                'Currently exploring' => 'Turning data into clear stories',
            ),
            'accent' => '#91B99C'
        ),

        'member-4' => array(
            'number' => '04',
            'name' => 'Mark Nalugon',
            'first' => 'Mark',
            'role' => 'Technical Writer',
            'tagline' => 'Empowering users through accurate, intuitive documentation.',
            'bio' => 'Welcome to my portfolio, featuring my skills, projects, and personal development. I am interested in technology, problem-solving, and exploring new ideas.',
            'bio2' => 'I like taking things apart to understand them. Whether it is a bug, a gadget or a new tool, I work through it step by step and share what I learn with the team.',
            'skills' => array('Creativity', 'Technology', 'Documentation'),
            'levels' => array(
                'Creativity' => 86,
                'Technology' => 92,
                'Documentation' => 94,
                'Adaptability' => 88,
            ),
            'facts' => array(
                'Focus' => 'Documentation & Verification',
                'Working style' => 'Break it down, solve it step by step',
                'Currently exploring' => 'New tools that make teamwork easier',
            ),
            'accent' => '#75A9D8'
        )
    );
}

/**
 * Project showcase. 'members' lists member slugs, so each project also
 * appears on those members' pages. Leave 'link' empty to hide the button.
 */
function pe_projects()
{
    return array(
        array(
            'title' => 'Portfolio',
            'category' => 'Development',
            'year' => '2026',
            'summary' => 'A custom WordPress theme with member profiles, an animated welcome and a working contact form, made by all four of us.',
            'tags' => array('WordPress', 'PHP', 'Design'),
            'members' => array('member-1', 'member-2', 'member-3', 'member-4'),
            'link' => '',
        ),
        array(
            'title' => 'Integrated Web and Mobile Emergency Medical Response Management System for MDRRMO Opol',
            'category' => 'Development',
            'year' => '2026',
            'summary' => 'A digital platform designed to streamline dispatch workflows, improve incident response times, and centralize emergency operations for the Municipal Disaster Risk Reduction and Management Office (MDRRMO) in Opol, Misamis Oriental.',
            'tags' => array('Web', 'PHP', 'Responsive'),
            'members' => array('member-1', 'member-2', 'member-3', 'member-4'),
            'link' => '',
        ),
        array(
            'title' => 'FIREGUARD: An IOT-Based Flame and Smoke Detection and Early Warning System',
            'category' => 'Research',
            'year' => '2025',
            'summary' => 'an IoT-based safety system designed to provide real-time hazard monitoring, early flame and smoke detection, and immediate emergency alerting to minimize fire damage and response latency.',
            'tags' => array('Survey', 'Analysis', 'Report'),
            'members' => array('member-3', 'member-4', 'member-2', 'member-1'),
            'link' => '',
        ),
    );
}

function pe_values()
{
    return array(
        array('Make it clear', 'If someone has to think about how to use it, we are not finished yet. Clarity comes before decoration.'),
        array('Make it together', 'Every project passes through four sets of eyes. Disagreement is how good ideas get sharper.'),
        array('Make it honest', 'We show our process, credit our sources and say so when something did not work the first time.'),
        array('Make it last', 'We would rather ship something simple and solid than something flashy that breaks on a small screen.'),
    );
}

function pe_process()
{
    return array(
        array('01', 'Understand', 'We start with questions: who is this for, what do they need, and what does success look like?'),
        array('02', 'Design', 'Sketches, wireframes and prototypes let us argue about ideas before we commit to building them.'),
        array('03', 'Build', 'Design and development happen side by side, so nothing gets lost between the idea and the result.'),
        array('04', 'Refine', 'We test with real people, fix what confuses them and polish until it feels finished.'),
    );
}

function pe_disciplines()
{
    return array(
        array('Design', 'Brand identities, interfaces and layouts that look considered and feel effortless.'),
        array('Development', 'Responsive, accessible websites and small web apps, built to be fast and easy to maintain.'),
        array('Research', 'Surveys, analysis and clear reports that tell the team what is actually worth building.'),
    );
}

function pe_faq()
{
    return array(
        array('Are you open to collaborations?', 'Yes. We enjoy working with students, creators and small organisations. Tell us about your idea using the form and we will reply with next steps.'),
        array('How quickly will you reply?', 'We aim to answer every message within two to three working days. If it is urgent, say so in your message.'),
        array('Can I ask for just one member?', 'Of course. Choose the member in the topic list, or mention their name in your message, and we will connect you directly.'),
        array('What kind of projects do you take on?', 'Branding and interface design, websites, small web apps and research-based reports. If you are not sure whether it fits, just ask.'),
    );
}


/* ==========================================================================
   3. CUSTOMIZER  (Appearance > Customize > Group Details)
   ========================================================================== */

function pe_defaults()
{
    return array(
        'brand_name' => 'PORTFOLIO',
        'group_name' => 'Portfolio Group',
        'tagline' => 'Four minds. Different strengths. One creative direction.',
        'contact_email' => get_option('admin_email'),
        'availability' => 'Open to collaborations and creative projects',
        'instagram' => '',
        'facebook' => '',
        'github' => '',
        'linkedin' => '',
    );
}

function pe_opt($key)
{
    $defaults = pe_defaults();
    $default = isset($defaults[$key]) ? $defaults[$key] : '';
    $value = get_theme_mod('pe_' . $key, $default);
    return ('' === $value) ? $default : $value;
}

function pe_customize($wp_customize)
{
    $wp_customize->add_section('pe_group', array(
        'title' => __('Group Details', 'portfolio-elegant'),
        'priority' => 20,
    ));

    $fields = array(
        'brand_name' => array('Logo text in the menu', 'text'),
        'group_name' => array('Group name (footer & emails)', 'text'),
        'tagline' => array('Footer tagline', 'text'),
        'contact_email' => array('Contact email (form messages are sent here)', 'text'),
        'availability' => array('Availability note', 'text'),
        'instagram' => array('Instagram URL', 'url'),
        'facebook' => array('Facebook URL', 'url'),
        'github' => array('GitHub URL', 'url'),
        'linkedin' => array('LinkedIn URL', 'url'),
    );

    $defaults = pe_defaults();

    foreach ($fields as $key => $field) {
        if ('url' === $field[1]) {
            $sanitize = 'esc_url_raw';
        } elseif ('contact_email' === $key) {
            $sanitize = 'sanitize_email';
        } else {
            $sanitize = 'sanitize_text_field';
        }

        $wp_customize->add_setting('pe_' . $key, array(
            'default' => $defaults[$key],
            'sanitize_callback' => $sanitize,
        ));
        $wp_customize->add_control('pe_' . $key, array(
            'label' => $field[0],
            'section' => 'pe_group',
            'type' => $field[1],
        ));
    }
}
add_action('customize_register', 'pe_customize');


/* ==========================================================================
   4. HELPERS & REUSABLE MARKUP
   ========================================================================== */

function pe_page_url($slug)
{
    $page = get_page_by_path($slug);
    return $page ? get_permalink($page) : home_url('/' . $slug . '/');
}

function pe_member_url($slug)
{
    return pe_page_url($slug);
}

function pe_member_thumb($slug, $size, $class)
{
    $page = get_page_by_path($slug);
    if ($page && has_post_thumbnail($page->ID)) {
        $members = portfolio_elegant_member_data();
        return get_the_post_thumbnail($page->ID, $size, array(
            'class' => $class,
            'loading' => 'lazy',
            'alt' => esc_attr($members[$slug]['name']),
        ));
    }
    return '';
}

/** One member card (home page, About page). */
function pe_member_card($slug)
{
    $members = portfolio_elegant_member_data();
    if (!isset($members[$slug])) {
        return;
    }
    $member = $members[$slug];
    $photo = pe_member_thumb($slug, 'medium_large', 'member-card-photo');
    ?>
    <a class="member-card <?php echo esc_attr($slug); ?>" href="<?php echo esc_url(pe_member_url($slug)); ?>">
        <div class="member-art">
            <span class="member-number"><?php echo esc_html($member['number']); ?></span>
            <?php if ($photo): ?>
                <?php echo $photo; // phpcs:ignore WordPress.Security.EscapeOutput -- built by WordPress. ?>
            <?php else: ?>
                <span class="member-monogram"><?php echo esc_html(mb_substr($member['name'], 0, 1)); ?></span>
            <?php endif; ?>
            <span class="member-arrow">↗</span>
        </div>
        <div class="member-meta">
            <h3><?php echo esc_html($member['name']); ?></h3>
            <p><?php echo esc_html($member['role']); ?></p>
        </div>
    </a>
    <?php
}

/** One project card. */
function pe_project_card($project, $index)
{
    $members = portfolio_elegant_member_data();
    ?>
    <article class="project-card reveal" data-cat="<?php echo esc_attr($project['category']); ?>">
        <div class="project-top">
            <span class="project-num"><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
            <span class="project-meta"><?php echo esc_html($project['category'] . ' · ' . $project['year']); ?></span>
        </div>
        <h3 class="project-title"><?php echo esc_html($project['title']); ?></h3>
        <p class="project-summary"><?php echo esc_html($project['summary']); ?></p>
        <ul class="tag-list">
            <?php foreach ($project['tags'] as $tag): ?>
                <li><?php echo esc_html($tag); ?></li>
            <?php endforeach; ?>
        </ul>
        <div class="project-foot">
            <ul class="crew">
                <?php foreach ($project['members'] as $slug): ?>
                    <?php if (isset($members[$slug])): ?>
                        <li>
                            <a class="crew-link <?php echo esc_attr($slug); ?>" href="<?php echo esc_url(pe_member_url($slug)); ?>">
                                <?php echo esc_html($members[$slug]['first']); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <?php if (!empty($project['link'])): ?>
                <a class="project-link" href="<?php echo esc_url($project['link']); ?>" target="_blank"
                    rel="noopener noreferrer">View project ↗</a>
            <?php endif; ?>
        </div>
    </article>
    <?php
}

function pe_social_links()
{
    $networks = array(
        'instagram' => 'Instagram',
        'facebook' => 'Facebook',
        'github' => 'GitHub',
        'linkedin' => 'LinkedIn',
    );
    $out = '';
    foreach ($networks as $key => $label) {
        $url = pe_opt($key);
        if ($url) {
            $out .= '<a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer">' . esc_html($label) . '</a>';
        }
    }
    return $out;
}

/** Group photo = featured image of the About page; otherwise a coloured placeholder. */
function pe_group_photo()
{
    $about = get_page_by_path('about');
    if ($about && has_post_thumbnail($about->ID)) {
        return get_the_post_thumbnail($about->ID, 'large', array(
            'class' => 'group-photo',
            'loading' => 'lazy',
            'alt' => esc_attr(pe_opt('group_name')),
        ));
    }
    return '';
}

function pe_group_photo_placeholder()
{
    $out = '<div class="photo-ph" aria-hidden="true">';
    foreach (portfolio_elegant_member_data() as $slug => $member) {
        $out .= '<span class="' . esc_attr($slug) . '">' . esc_html(mb_substr($member['name'], 0, 1)) . '</span>';
    }
    $out .= '</div>';
    if (current_user_can('edit_pages')) {
        $out .= '<p class="photo-hint">Admin tip: add your group photo as the Featured Image of the About page.</p>';
    }
    return $out;
}


/* ==========================================================================
   5. PAGE CONTENT RENDERERS (used by page.php)
   ========================================================================== */

function pe_render_about()
{
    $photo = pe_group_photo();
    $members = portfolio_elegant_member_data();
    ?>
    <section class="content-section section-pad">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="about-photo reveal">
                        <?php echo $photo ? $photo : pe_group_photo_placeholder(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="section-kicker reveal">OUR STORY</div>
                    <h2 class="section-heading reveal">Four people.<br><span class="muted-heading">One table.</span></h2>
                    <p class="body-copy reveal">We started as four classmates with different strengths and one stubborn
                        belief: good work happens when design, code and research sit at the same table.</p>
                    <p class="body-copy reveal">Since then we have built brand concepts, websites, dashboards and research
                        reports together. Each of us brings a different way of seeing a problem, and the tension between
                        those views is exactly what makes the result better.</p>
                    <p class="body-copy reveal">This portfolio is a record of that work, and an invitation to start
                        something new with us.</p>
                </div>
            </div>

            <div class="stats-row reveal">
                <div class="stat"><strong data-count="<?php echo count($members); ?>">0</strong><span>Members</span></div>
                <div class="stat"><strong data-count="<?php echo count(pe_projects()); ?>">0</strong><span>Projects</span>
                </div>
                <div class="stat"><strong
                        data-count="<?php echo count(array_unique(wp_list_pluck(pe_projects(), 'category'))); ?>">0</strong><span>Disciplines</span>
                </div>
            </div>
        </div>
    </section>

    <section class="dark-section section-pad">
        <div class="container">
            <div class="section-topline reveal">
                <div class="section-kicker">WHAT WE BELIEVE</div>
                <span class="small-note">FOUR VALUES / ONE STANDARD</span>
            </div>
            <div class="row g-4 mt-3">
                <?php foreach (pe_values() as $i => $value): ?>
                    <div class="col-md-6 col-lg-3 reveal" data-delay="<?php echo (int) $i; ?>">
                        <div class="value-card">
                            <span
                                class="value-num"><?php echo esc_html(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                            <h3><?php echo esc_html($value[0]); ?></h3>
                            <p><?php echo esc_html($value[1]); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="content-section section-pad">
        <div class="container">
            <div class="section-kicker reveal">HOW WE WORK</div>
            <h2 class="section-heading reveal">From first idea to<br><span class="muted-heading">finished piece.</span></h2>
            <ol class="process-list">
                <?php foreach (pe_process() as $i => $step): ?>
                    <li class="process-step reveal" data-delay="<?php echo (int) $i; ?>">
                        <span class="process-num"><?php echo esc_html($step[0]); ?></span>
                        <h3><?php echo esc_html($step[1]); ?></h3>
                        <p><?php echo esc_html($step[2]); ?></p>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </section>

    <section class="dark-section section-pad">
        <div class="container">
            <div class="section-topline reveal">
                <div class="section-kicker">THE PEOPLE</div>
                <span class="small-note">FOUR PERSPECTIVES</span>
            </div>
            <div class="row g-4 mt-3">
                <?php foreach (array_keys($members) as $slug): ?>
                    <div class="col-md-6 col-lg-3 reveal"><?php pe_member_card($slug); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

function pe_render_projects()
{
    $projects = pe_projects();
    $cats = array_values(array_unique(wp_list_pluck($projects, 'category')));
    ?>
    <section class="dark-section section-pad pt-5">
        <div class="container">
            <div class="filters reveal" role="group" aria-label="Filter projects">
                <button class="pe-filter is-active" type="button" data-filter="all" aria-pressed="true">All</button>
                <?php foreach ($cats as $cat): ?>
                    <button class="pe-filter" type="button" data-filter="<?php echo esc_attr($cat); ?>"
                        aria-pressed="false"><?php echo esc_html($cat); ?></button>
                <?php endforeach; ?>
            </div>

            <div class="row g-4" id="project-grid">
                <?php foreach ($projects as $i => $project): ?>
                    <div class="col-lg-6 project-col" data-cat="<?php echo esc_attr($project['category']); ?>">
                        <?php pe_project_card($project, $i); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <p class="empty-note" id="project-empty" hidden>No projects in this category yet.</p>
        </div>
    </section>

    <section class="statement-section">
        <div class="container py-5">
            <p class="eyebrow reveal">LIKE WHAT YOU SEE?</p>
            <h2 class="statement-heading reveal">Let's make the next<br>one <em>together.</em></h2>
            <a class="btn btn-burgundy mt-4 reveal" href="<?php echo esc_url(pe_page_url('contact')); ?>">Start a
                conversation <span>↗</span></a>
        </div>
    </section>
    <?php
}

function pe_render_contact()
{
    $status = isset($_GET['pe_status']) ? sanitize_key(wp_unslash($_GET['pe_status'])) : ''; // phpcs:ignore WordPress.Security.NonceVerification
    $for = isset($_GET['for']) ? sanitize_key(wp_unslash($_GET['for'])) : ''; // phpcs:ignore WordPress.Security.NonceVerification
    $members = portfolio_elegant_member_data();
    $email = pe_opt('contact_email');
    $social = pe_social_links();

    $notes = array(
        'sent' => array('ok', 'Thank you! Your message is on its way and we will reply within a few working days.'),
        'invalid' => array('bad', 'Please check your name, a valid email address, and a message of at least 10 characters.'),
        'wait' => array('bad', 'That was quick! Please wait a minute before sending another message.'),
        'error' => array('bad', 'Something went wrong. Please refresh the page and try again.'),
    );

    $topics = array('Collaboration', 'Hire us for a project', 'Question about our work', 'Press or media', 'Just saying hello');
    if (isset($members[$for])) {
        array_unshift($topics, 'Working with ' . $members[$for]['first']);
    }
    ?>
    <section class="dark-section section-pad pt-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5">
                    <div class="reveal">
                        <h2 class="side-title">Reach us directly</h2>
                        <ul class="contact-list">
                            <li><span>Email</span><a
                                    href="mailto:<?php echo esc_attr(antispambot($email)); ?>"><?php echo esc_html(antispambot($email)); ?></a>
                            </li>
                            <li><span>Availability</span><?php echo esc_html(pe_opt('availability')); ?></li>
                            <li><span>Response time</span>Usually within 2–3 working days</li>
                        </ul>

                        <?php if ($social): ?>
                            <h2 class="side-title">Find us online</h2>
                            <div class="social-links">
                                <?php echo $social; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in helper. ?>
                            </div>
                        <?php endif; ?>

                        <h2 class="side-title">Or write to one of us</h2>
                        <ul class="crew crew-stack">
                            <?php foreach ($members as $slug => $member): ?>
                                <li>
                                    <a class="crew-link <?php echo esc_attr($slug); ?>"
                                        href="<?php echo esc_url(add_query_arg('for', $slug, pe_page_url('contact'))); ?>#contact-form">
                                        <?php echo esc_html($member['name']); ?>
                                        <small><?php echo esc_html($member['role']); ?></small>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="contact-card reveal" id="contact-form" data-delay="1">
                        <?php if (isset($notes[$status])): ?>
                            <div class="form-note form-note-<?php echo esc_attr($notes[$status][0]); ?>" role="status">
                                <?php echo esc_html($notes[$status][1]); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ('sent' !== $status): ?>
                            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" novalidate>
                                <input type="hidden" name="action" value="pe_contact">
                                <?php wp_nonce_field('pe_contact', 'pe_contact_nonce'); ?>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="pe_name">Your name</label>
                                        <input type="text" id="pe_name" name="pe_name" autocomplete="name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pe_email">Email</label>
                                        <input type="email" id="pe_email" name="pe_email" autocomplete="email" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="pe_topic">What is this about?</label>
                                        <select id="pe_topic" name="pe_topic">
                                            <?php foreach ($topics as $topic): ?>
                                                <option value="<?php echo esc_attr($topic); ?>"><?php echo esc_html($topic); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="pe_message">Message</label>
                                        <textarea id="pe_message" name="pe_message" rows="6" minlength="10" required></textarea>
                                    </div>
                                </div>

                                <div class="hp" aria-hidden="true">
                                    <label for="pe_website">Leave this empty</label>
                                    <input type="text" id="pe_website" name="pe_website" tabindex="-1" autocomplete="off">
                                </div>

                                <button class="btn btn-burgundy mt-4" type="submit">Send message <span>↗</span></button>
                            </form>
                        <?php else: ?>
                            <a class="btn btn-outline-light" href="<?php echo esc_url(pe_page_url('contact')); ?>">Send another
                                message</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content-section section-pad">
        <div class="container">
            <div class="section-kicker reveal">FAQ</div>
            <h2 class="section-heading reveal">Quick <span class="muted-heading">answers.</span></h2>
            <div class="faq reveal">
                <?php foreach (pe_faq() as $item): ?>
                    <details>
                        <summary><?php echo esc_html($item[0]); ?></summary>
                        <p><?php echo esc_html($item[1]); ?></p>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

function pe_privacy_html()
{
    $name = pe_opt('group_name');

    $html = '<p>This page explains what information ' . esc_html($name) . ' collects when you visit this website or use the contact form, and what we do with it. We keep it short because we collect very little.</p>';
    $html .= '<h2>What we collect</h2><ul>';
    $html .= '<li><strong>Contact form.</strong> If you send us a message, we receive your name, email address, the topic you chose and your message. We use this only to reply to you.</li>';
    $html .= '<li><strong>Spam protection.</strong> To stop automated abuse, your IP address is briefly used (in scrambled form) to limit how often the form can be sent. It is not stored with your message.</li>';
    $html .= '<li><strong>Technical logs.</strong> Our web host may keep standard server logs (such as IP address, browser type and pages requested) for security and troubleshooting.</li>';
    $html .= '</ul>';
    $html .= '<h2>What we do not do</h2><p>We do not run advertising, we do not sell or share your information, and this website does not use analytics or tracking cookies.</p>';
    $html .= '<h2>How your message is stored</h2><p>Messages are emailed to the team and also saved privately inside the website\'s administration area, so nothing is lost if an email fails to arrive. Only site administrators can see them. We keep messages for as long as needed to answer you, and delete them on request.</p>';
    $html .= '<h2>Third-party services</h2><p>To display the website, your browser loads typefaces from Google Fonts and layout files from the jsDelivr network. Those services receive your IP address when they deliver the files, as with any website. See <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer">Google\'s privacy policy</a> and <a href="https://www.jsdelivr.com/terms/privacy-policy-jsdelivr-net" target="_blank" rel="noopener noreferrer">jsDelivr\'s privacy policy</a> for details. Social links lead to other websites with their own policies.</p>';
    $html .= '<h2>Cookies and browser storage</h2><p>Visitors do not receive cookies from us. The welcome animation on the home page uses your browser\'s session storage only to remember that you have already seen it during this visit; it is cleared when you close the tab. WordPress sets cookies only for people who log in to the administration area.</p>';
    $html .= '<h2>Your rights</h2><p>You can ask us at any time what information we hold about you, to correct it, or to delete it. Contact us through the <a href="' . esc_url(pe_page_url('contact')) . '">contact page</a> and we will respond within a reasonable time.</p>';
    $html .= '<h2>Changes</h2><p>If we change how this website handles information, we will update this page. Last updated: ' . esc_html(wp_date('j F Y')) . '.</p>';

    return $html;
}


/* ==========================================================================
   6. FIRST-RUN SETUP: creates every page automatically
   ========================================================================== */

function pe_ensure_page($slug, $title, $template = '', $content = '')
{
    $existing = get_page_by_path($slug);

    if ($existing) {
        // Member pages must always use the Member Profile template.
        if ($template && get_page_template_slug($existing->ID) !== $template) {
            update_post_meta($existing->ID, '_wp_page_template', $template);
        }
        return $existing->ID;
    }

    $args = array(
        'post_title' => $title,
        'post_name' => $slug,
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_content' => $content,
    );
    if ($template) {
        $args['meta_input'] = array('_wp_page_template' => $template);
    }

    $id = wp_insert_post($args);
    return is_wp_error($id) ? 0 : $id;
}

function pe_run_setup()
{
    if (get_option('pe_setup_v2')) {
        return;
    }

    $home = pe_ensure_page('home', 'Home');
    pe_ensure_page('about', 'About');
    pe_ensure_page('projects', 'Projects');
    pe_ensure_page('contact', 'Contact');

    foreach (portfolio_elegant_member_data() as $slug => $member) {
        pe_ensure_page($slug, $member['name'], 'page-member.php');
    }

    $privacy = pe_ensure_page('privacy-policy', 'Privacy Policy', '', pe_privacy_html());
    if ($privacy && !get_option('wp_page_for_privacy_policy')) {
        update_option('wp_page_for_privacy_policy', $privacy);
    }

    if ($home && 'page' !== get_option('show_on_front')) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home);
    }

    if (!get_option('permalink_structure')) {
        update_option('permalink_structure', '/%postname%/');
    }

    update_option('pe_setup_v2', 1);
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'pe_run_setup');
add_action('admin_init', 'pe_run_setup');


/* ==========================================================================
   7. CONTACT FORM: saves every message in WordPress and emails it
   ========================================================================== */

function pe_register_messages()
{
    register_post_type('pe_message', array(
        'labels' => array(
            'name' => 'Messages',
            'singular_name' => 'Message',
            'menu_name' => 'Messages',
            'all_items' => 'All Messages',
            'edit_item' => 'View Message',
            'not_found' => 'No messages yet.',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 26,
        'menu_icon' => 'dashicons-email',
        'supports' => array('title', 'editor'),
        'capability_type' => 'post',
        'capabilities' => array('create_posts' => 'do_not_allow'),
        'map_meta_cap' => true,
    ));
}
add_action('init', 'pe_register_messages');

function pe_contact_redirect($status)
{
    $back = wp_get_referer();
    if (!$back) {
        $back = pe_page_url('contact');
    }
    $back = remove_query_arg('pe_status', $back);
    wp_safe_redirect(add_query_arg('pe_status', $status, $back) . '#contact-form');
    exit;
}

function pe_handle_contact()
{
    if (!isset($_POST['pe_contact_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['pe_contact_nonce'])), 'pe_contact')) {
        pe_contact_redirect('error');
    }

    // Honeypot: real people never fill this in.
    if (!empty($_POST['pe_website'])) {
        pe_contact_redirect('sent');
    }

    $name = isset($_POST['pe_name']) ? sanitize_text_field(wp_unslash($_POST['pe_name'])) : '';
    $email = isset($_POST['pe_email']) ? sanitize_email(wp_unslash($_POST['pe_email'])) : '';
    $topic = isset($_POST['pe_topic']) ? sanitize_text_field(wp_unslash($_POST['pe_topic'])) : 'General';
    $message = isset($_POST['pe_message']) ? sanitize_textarea_field(wp_unslash($_POST['pe_message'])) : '';

    if ('' === $name || !is_email($email) || mb_strlen($message) < 10) {
        pe_contact_redirect('invalid');
    }

    $ip = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '';
    $gate = 'pe_rl_' . md5($ip);
    if (get_transient($gate)) {
        pe_contact_redirect('wait');
    }
    set_transient($gate, 1, 45);

    // Keep a copy inside WordPress so nothing is lost if email delivery fails.
    wp_insert_post(array(
        'post_type' => 'pe_message',
        'post_status' => 'private',
        'post_title' => $topic . ' from ' . $name,
        'post_content' => "From: {$name} <{$email}>\nTopic: {$topic}\n\n{$message}",
    ));

    $to = pe_opt('contact_email');
    $to = is_email($to) ? $to : get_option('admin_email');
    $safe = str_replace(array('<', '>', ',', '"'), '', $name);
    $headers = array('Reply-To: ' . $safe . ' <' . $email . '>');
    $subject = '[' . wp_specialchars_decode(get_bloginfo('name'), ENT_QUOTES) . '] ' . $topic . ' from ' . $name;
    $body = "Name: {$name}\nEmail: {$email}\nTopic: {$topic}\n\n{$message}\n";

    // A failed email is not shown as an error: the message is already saved in the dashboard.
    wp_mail($to, $subject, $body, $headers);

    pe_contact_redirect('sent');
}
add_action('admin_post_nopriv_pe_contact', 'pe_handle_contact');
add_action('admin_post_pe_contact', 'pe_handle_contact');


/* ==========================================================================
   8. SEO / SOCIAL TAGS
   ========================================================================== */

function pe_meta_tags()
{
    $members = portfolio_elegant_member_data();
    $title = wp_get_document_title();
    $desc = 'A shared space for four individuals driven by curiosity, creativity, and the ambition to turn ideas into meaningful digital experiences.';
    $image = '';
    $url = home_url('/');

    if (is_singular()) {
        $url = get_permalink();
        $slug = get_post_field('post_name', get_queried_object_id());
        if (isset($members[$slug])) {
            $desc = $members[$slug]['name'] . ', ' . $members[$slug]['role'] . '. ' . $members[$slug]['tagline'];
            if (has_post_thumbnail()) {
                $image = get_the_post_thumbnail_url(null, 'large');
            }
        }
    }

    if (!$image) {
        $about = get_page_by_path('about');
        if ($about && has_post_thumbnail($about->ID)) {
            $image = get_the_post_thumbnail_url($about->ID, 'large');
        }
    }

    echo '<meta name="description" content="' . esc_attr(wp_trim_words($desc, 32, '')) . '">' . "\n";
    echo '<meta name="theme-color" content="#101012">' . "\n";

    $tags = array(
        'og:type' => is_front_page() ? 'website' : 'article',
        'og:site_name' => pe_opt('group_name'),
        'og:title' => $title,
        'og:description' => wp_trim_words($desc, 32, ''),
        'og:url' => $url,
        'twitter:card' => $image ? 'summary_large_image' : 'summary',
    );
    if ($image) {
        $tags['og:image'] = $image;
    }
    foreach ($tags as $property => $content) {
        printf('<meta property="%s" content="%s">' . "\n", esc_attr($property), esc_attr($content));
    }
}
add_action('wp_head', 'pe_meta_tags', 1);