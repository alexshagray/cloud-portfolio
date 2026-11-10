<?php get_header(); ?>

<?php
$members = portfolio_elegant_member_data();
$projects = pe_projects();
$about_page = get_page_by_path('about');
?>

<section class="hero-section">
    <div class="hero-orb orb-one"></div>
    <div class="hero-orb orb-two"></div>

    <div class="container hero-content">
        <p class="eyebrow reveal">
            <span class="eyebrow-line"></span>
            INDEPENDENT CREATIVE COLLECTIVE
        </p>

        <h1 class="hero-title reveal">
            We create.<br>
            <em>We innovate.</em><br>
            We inspire<span class="accent">.</span>
        </h1>

        <div class="row align-items-end hero-bottom reveal">
            <div class="col-lg-6">
                <p class="hero-description">
                    A shared space for four individuals driven by curiosity,
                    creativity, and the ambition to turn ideas into meaningful
                    digital experiences.
                </p>
            </div>

            <div class="col-lg-6 text-lg-end">
                <a class="circle-link" href="<?php echo esc_url(pe_page_url('about')); ?>">
                    Discover<br>our story <span>↘</span>
                </a>
            </div>
        </div>

        <div class="hero-index">
            <span>01 / 04</span>
            <span class="hero-spectrum" aria-hidden="true">
                <?php foreach ($members as $slug => $member): ?>
                    <i class="<?php echo esc_attr($slug); ?>"></i>
                <?php endforeach; ?>
            </span>
            <span>SCROLL TO EXPLORE ↓</span>
        </div>
    </div>
</section>


<div class="marquee" aria-hidden="true">
    <div class="marquee-track">
        <?php for ($loop = 0; $loop < 2; $loop++): ?>
            <?php foreach (array('Design', 'Development', 'Research', 'Storytelling', 'Prototyping', 'Collaboration') as $word): ?>
                <span><?php echo esc_html($word); ?></span><b>✦</b>
            <?php endforeach; ?>
        <?php endfor; ?>
    </div>
</div>


<section class="intro-section section-pad">
    <div class="container">
        <div class="section-kicker reveal">01 — WHO WE ARE</div>

        <div class="row g-4 align-items-start">
            <div class="col-lg-7">
                <h2 class="section-heading reveal">
                    Different perspectives.<br>
                    <span class="muted-heading">One shared vision.</span>
                </h2>
            </div>

            <div class="col-lg-5 pt-lg-4">
                <p class="body-copy reveal">
                    We are a team of four individuals bringing together our
                    skills, ideas, and experiences. This portfolio is where
                    our work, growth, and creative journeys come together.
                </p>

                <a class="text-link reveal" href="<?php echo esc_url(pe_page_url('about')); ?>">
                    MORE ABOUT US <span>↗</span>
                </a>
            </div>
        </div>

        <?php if ($about_page && has_post_thumbnail($about_page->ID)): ?>
            <div class="group-photo-wrap reveal">
                <?php
                echo get_the_post_thumbnail(
                    $about_page->ID,
                    'large',
                    array(
                        'class' => 'group-photo',
                        'loading' => 'lazy',
                        'alt' => 'Portfolio group photo'
                    )
                );
                ?>
                <p class="photo-caption">THE PEOPLE BEHIND THE PORTFOLIO</p>
            </div>
        <?php endif; ?>
    </div>
</section>


<section class="members-section section-pad" id="members">
    <div class="container">

        <div class="section-topline reveal">
            <div class="section-kicker">02 — THE PEOPLE</div>
            <span class="small-note">MEET THE COLLECTIVE / 4 MEMBERS</span>
        </div>

        <div class="row g-4 mt-3">
            <?php foreach (array_keys($members) as $slug): ?>
                <div class="col-md-6 col-lg-3 reveal">
                    <?php pe_member_card($slug); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<section class="intro-section section-pad">
    <div class="container">
        <div class="section-kicker reveal">03 — WHAT WE DO</div>
        <h2 class="section-heading reveal">Three crafts,<br><span class="muted-heading">working as one.</span></h2>

        <div class="row g-4 mt-2">
            <?php foreach (pe_disciplines() as $i => $item): ?>
                <div class="col-md-4 reveal" data-delay="<?php echo (int) $i; ?>">
                    <div class="discipline">
                        <span
                            class="discipline-num"><?php echo esc_html(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                        <h3><?php echo esc_html($item[0]); ?></h3>
                        <p><?php echo esc_html($item[1]); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<section class="members-section section-pad">
    <div class="container">
        <div class="section-topline reveal">
            <div class="section-kicker">04 — SELECTED WORK</div>
            <a class="small-note small-note-link" href="<?php echo esc_url(pe_page_url('projects')); ?>">VIEW ALL
                PROJECTS ↗</a>
        </div>

        <div class="row g-4 mt-3">
            <?php foreach (array_slice($projects, 0, 3, true) as $i => $project): ?>
                <div class="col-lg-4">
                    <?php pe_project_card($project, $i); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<section class="statement-section">
    <div class="container py-5">
        <p class="eyebrow reveal">OUR APPROACH</p>

        <h2 class="statement-heading reveal">
            Good work starts<br>
            with <em>good thinking.</em>
        </h2>

        <div class="d-flex flex-wrap gap-3 mt-4 reveal">
            <a class="btn btn-burgundy" href="<?php echo esc_url(pe_page_url('projects')); ?>">
                Explore our projects <span>↗</span>
            </a>
            <a class="btn btn-outline-light btn-ghost" href="<?php echo esc_url(pe_page_url('contact')); ?>">
                Start a conversation <span>↗</span>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>