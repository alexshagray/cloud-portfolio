<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script>
    document.documentElement.classList.add('js');
    try {
      if (!sessionStorage.getItem('peIntro') && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.documentElement.classList.add('has-intro');
      }
    } catch (e) { }
  </script>
  <?php wp_head(); ?>
</head>

<body id="top" <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <?php
  $pe_brand = pe_opt('brand_name');
  $pe_members = portfolio_elegant_member_data();
  $pe_on_member = is_page_template('page-member.php');
  ?>

  <?php if (is_front_page()): ?>
    <div class="intro" id="intro" role="presentation" aria-hidden="true">
      <div class="intro-inner">
        <span class="intro-kicker">Welcome to</span>
        <p class="intro-title">
          <?php
          $pe_letters = preg_split('//u', ucfirst(strtolower($pe_brand)), -1, PREG_SPLIT_NO_EMPTY);
          foreach ($pe_letters as $pe_i => $pe_letter) {
            echo '<span style="--i:' . (int) $pe_i . '">' . esc_html($pe_letter) . '</span>';
          }
          ?><span class="intro-dot" style="--i:<?php echo count($pe_letters); ?>">.</span>
        </p>
        <div class="intro-line">
          <?php foreach ($pe_members as $pe_slug => $pe_m): ?>
            <i class="<?php echo esc_attr($pe_slug); ?>"></i>
          <?php endforeach; ?>
        </div>
        <span class="intro-skip">Click anywhere to skip</span>
      </div>
    </div>
  <?php endif; ?>

  <div class="scroll-progress" id="progress" aria-hidden="true"></div>
  <div class="cursor-glow" id="glow" aria-hidden="true"></div>
  <a class="skip-link" href="#main"><?php esc_html_e('Skip to content', 'portfolio-elegant'); ?></a>

  <nav class="navbar navbar-expand-lg site-nav" id="site-nav"
    aria-label="<?php esc_attr_e('Primary', 'portfolio-elegant'); ?>">
    <div class="container">
      <a class="navbar-brand brand-mark"
        href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html($pe_brand); ?><span>.</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
        aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation"><span
          class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-auto align-items-lg-center">
          <li class="nav-item"><a class="nav-link<?php echo is_front_page() ? ' active' : ''; ?>"
              href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link<?php echo is_page('about') ? ' active' : ''; ?>"
              href="<?php echo esc_url(pe_page_url('about')); ?>">About</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle<?php echo $pe_on_member ? ' active' : ''; ?>" href="#" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">Our Members</a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <?php foreach ($pe_members as $pe_slug => $pe_m): ?>
                <li>
                  <a class="dropdown-item dd-<?php echo esc_attr($pe_slug); ?>"
                    href="<?php echo esc_url(pe_member_url($pe_slug)); ?>">
                    <?php echo esc_html($pe_m['name']); ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link<?php echo is_page('projects') ? ' active' : ''; ?>"
              href="<?php echo esc_url(pe_page_url('projects')); ?>">Projects</a></li>
          <li class="nav-item ms-lg-3"><a class="btn btn-outline-light btn-sm nav-contact"
              href="<?php echo esc_url(pe_page_url('contact')); ?>">Let's talk <span>↗</span></a></li>
        </ul>
      </div>
    </div>
  </nav>
  <main id="main">