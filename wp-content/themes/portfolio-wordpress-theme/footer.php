</main>
<?php
$pe_social = pe_social_links();
$pe_email = pe_opt('contact_email');
?>
<footer class="site-footer">
    <div class="container py-5">
        <div class="row gy-5">
            <div class="col-lg-5">
                <a class="brand-mark footer-brand"
                    href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html(pe_opt('brand_name')); ?><span>.</span></a>
                <p class="footer-note mt-3 mb-4"><?php echo esc_html(pe_opt('tagline')); ?></p>
                <a class="footer-link" href="<?php echo esc_url(pe_page_url('contact')); ?>">Get in touch ↗</a>
            </div>

            <div class="col-6 col-lg-2">
                <h2 class="footer-title">Explore</h2>
                <ul class="footer-list">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                    <li><a href="<?php echo esc_url(pe_page_url('about')); ?>">About</a></li>
                    <li><a href="<?php echo esc_url(pe_page_url('projects')); ?>">Projects</a></li>
                    <li><a href="<?php echo esc_url(pe_page_url('contact')); ?>">Contact</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-2">
                <h2 class="footer-title">The team</h2>
                <ul class="footer-list">
                    <?php foreach (portfolio_elegant_member_data() as $pe_slug => $pe_m): ?>
                        <li>
                            <a class="crew-link <?php echo esc_attr($pe_slug); ?>"
                                href="<?php echo esc_url(pe_member_url($pe_slug)); ?>">
                                <?php echo esc_html($pe_m['name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-lg-3">
                <h2 class="footer-title">Say hello</h2>
                <p class="mb-2"><a class="footer-mail"
                        href="mailto:<?php echo esc_attr(antispambot($pe_email)); ?>"><?php echo esc_html(antispambot($pe_email)); ?></a>
                </p>
                <p class="footer-note small"><?php echo esc_html(pe_opt('availability')); ?></p>
                <?php if ($pe_social): ?>
                    <div class="social-links">
                        <?php echo $pe_social; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in helper. ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="footer-bottom mt-5 pt-3 d-flex flex-column flex-md-row justify-content-between gap-2">
            <span>© <?php echo esc_html(date('Y')); ?> <?php echo esc_html(pe_opt('group_name')); ?>. All rights
                reserved.</span>
            <span class="footer-bottom-links">
                <a href="<?php echo esc_url(pe_page_url('privacy-policy')); ?>">Privacy Policy</a>
                <a href="#top" id="to-top">Back to top ↑</a>
            </span>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>