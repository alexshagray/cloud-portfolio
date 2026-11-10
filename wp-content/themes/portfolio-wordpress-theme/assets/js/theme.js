/**
 * Portfolio theme behaviour.
 * Welcome screen, scroll reveal (with your original stagger), counters,
 * project filters, scroll progress, nav state, cursor glow and contact form.
 * No dependencies (Bootstrap handles the mobile menu and dropdown).
 */
document.addEventListener('DOMContentLoaded', function () {

  var doc = document.documentElement;
  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var finePointer = window.matchMedia && window.matchMedia('(hover: hover) and (pointer: fine)').matches;

  function $(selector, scope) {
    return (scope || document).querySelector(selector);
  }

  function $$(selector, scope) {
    return Array.prototype.slice.call((scope || document).querySelectorAll(selector));
  }

  /* ---------------------------------------------------------------------
   * Welcome screen (home page, once per browser session)
   * ------------------------------------------------------------------ */
  var intro = $('#intro');

  if (intro && doc.classList.contains('has-intro')) {
    var closed = false;

    var closeIntro = function () {
      if (closed) {
        return;
      }
      closed = true;

      try {
        sessionStorage.setItem('peIntro', '1');
      } catch (e) { }

      intro.classList.add('is-leaving');
      doc.classList.remove('has-intro');

      window.setTimeout(function () {
        if (intro.parentNode) {
          intro.parentNode.removeChild(intro);
        }
      }, 1000);
    };

    intro.addEventListener('click', closeIntro);

    document.addEventListener('keydown', function onKey(event) {
      if (event.key === 'Escape' || event.key === 'Enter' || event.key === ' ') {
        closeIntro();
        document.removeEventListener('keydown', onKey);
      }
    });

    window.setTimeout(closeIntro, 3300);
  }

  /* ---------------------------------------------------------------------
   * Scroll reveal
   * ------------------------------------------------------------------ */
  var revealItems = $$('.reveal');
  var counters = $$('[data-count]');

  function animateCount(el) {
    var target = parseInt(el.getAttribute('data-count'), 10) || 0;

    if (reduceMotion || target < 1) {
      el.textContent = target;
      return;
    }

    var start = null;
    var duration = 1400;

    function step(ts) {
      if (start === null) {
        start = ts;
      }
      var t = Math.min((ts - start) / duration, 1);
      el.textContent = Math.round(target * (1 - Math.pow(1 - t, 3)));
      if (t < 1) {
        window.requestAnimationFrame(step);
      }
    }

    window.requestAnimationFrame(step);
  }

  // Show content immediately if the browser cannot observe scrolling, or motion is reduced.
  if (!('IntersectionObserver' in window) || reduceMotion) {
    revealItems.forEach(function (item) {
      item.classList.add('is-visible');
    });
    counters.forEach(animateCount);
  } else {
    var observer = new IntersectionObserver(function (entries, obs) {

      entries.forEach(function (entry) {

        if (!entry.isIntersecting) {
          return;
        }

        var item = entry.target;

        // Explicit delay (data-delay) wins; otherwise a slight stagger between nearby elements.
        var explicit = parseInt(item.getAttribute('data-delay'), 10);
        var delay = isNaN(explicit) ? revealItems.indexOf(item) % 4 : explicit;

        item.style.setProperty('--d', delay);
        item.classList.add('is-visible');
        obs.unobserve(item);

        // Remove the delay afterwards so hover effects stay snappy.
        window.setTimeout(function () {
          item.style.removeProperty('--d');
        }, 1500);
      });

    }, {
      threshold: 0.12,
      rootMargin: '0px 0px -5% 0px'
    });

    revealItems.forEach(function (item) {
      observer.observe(item);
    });

    var countObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          animateCount(entry.target);
          countObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.6 });

    counters.forEach(function (el) {
      countObserver.observe(el);
    });
  }

  /* ---------------------------------------------------------------------
   * Navigation state and scroll progress
   * ------------------------------------------------------------------ */
  var nav = $('#site-nav');
  var progress = $('#progress');
  var ticking = false;

  function onScroll() {
    var y = window.pageYOffset || doc.scrollTop;
    var max = doc.scrollHeight - window.innerHeight;

    if (nav) {
      nav.classList.toggle('is-scrolled', y > 30);
    }
    if (progress) {
      progress.style.setProperty('--p', max > 0 ? Math.min(y / max, 1).toFixed(4) : 0);
    }
    ticking = false;
  }

  window.addEventListener('scroll', function () {
    if (!ticking) {
      ticking = true;
      window.requestAnimationFrame(onScroll);
    }
  }, { passive: true });

  window.addEventListener('resize', onScroll);
  onScroll();

  /* ---------------------------------------------------------------------
   * Cursor glow (mouse devices only)
   * ------------------------------------------------------------------ */
  var glow = $('#glow');

  if (glow && finePointer && !reduceMotion) {
    var raf = null;
    var gx = 0;
    var gy = 0;

    document.addEventListener('mousemove', function (event) {
      gx = event.clientX;
      gy = event.clientY;
      glow.classList.add('is-on');

      if (!raf) {
        raf = window.requestAnimationFrame(function () {
          glow.style.setProperty('--gx', gx + 'px');
          glow.style.setProperty('--gy', gy + 'px');
          raf = null;
        });
      }
    }, { passive: true });

    document.addEventListener('mouseleave', function () {
      glow.classList.remove('is-on');
    });
  }

  /* ---------------------------------------------------------------------
   * Project filters
   * ------------------------------------------------------------------ */
  var filters = $$('.pe-filter');
  var columns = $$('#project-grid .project-col');
  var empty = $('#project-empty');

  filters.forEach(function (button) {
    button.addEventListener('click', function () {
      var filter = button.getAttribute('data-filter');
      var shown = 0;

      filters.forEach(function (b) {
        var active = b === button;
        b.classList.toggle('is-active', active);
        b.setAttribute('aria-pressed', active ? 'true' : 'false');
      });

      columns.forEach(function (col) {
        var match = filter === 'all' || col.getAttribute('data-cat') === filter;
        col.hidden = !match;

        if (match) {
          shown++;
          // A card that was never scrolled into view must not stay invisible.
          $$('.reveal', col).forEach(function (card) {
            card.classList.add('is-visible');
          });
        }
      });

      if (empty) {
        empty.hidden = shown > 0;
      }
    });
  });

  /* ---------------------------------------------------------------------
   * Contact form: gentle validation and double-submit protection
   * ------------------------------------------------------------------ */
  var form = $('.contact-card form');

  if (form) {
    var required = $$('input[required], textarea[required]', form);

    required.forEach(function (field) {
      field.addEventListener('blur', function () {
        field.classList.toggle('is-invalid', !field.checkValidity());
      });

      field.addEventListener('input', function () {
        if (field.classList.contains('is-invalid') && field.checkValidity()) {
          field.classList.remove('is-invalid');
        }
      });
    });

    form.addEventListener('submit', function (event) {
      var firstBad = null;

      required.forEach(function (field) {
        var ok = field.checkValidity();
        field.classList.toggle('is-invalid', !ok);
        if (!ok && !firstBad) {
          firstBad = field;
        }
      });

      if (firstBad) {
        event.preventDefault();
        firstBad.focus();
        return;
      }

      var submit = $('button[type="submit"]', form);
      if (submit) {
        submit.disabled = true;
        submit.textContent = 'Sending…';
      }
    });
  }

  // After the form posts, bring the visitor to the result message.
  if (/pe_status=/.test(window.location.search)) {
    var target = $('#contact-form');
    if (target && target.scrollIntoView) {
      target.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'center' });
    }
  }

});