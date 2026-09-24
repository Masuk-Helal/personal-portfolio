<?php
get_header();
?>

  <!-- ============ HERO ============ -->
  <section class="hero" id="home">
    <div class="hero-bg" style="background-image:url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-portrait.jpg');"></div>
    <div class="container hero-wrap d-flex flex-column justify-content-between gap-5">
      <div class="hero-copy-wrap d-flex align-items-center flex-grow-1">
        <div class="hero-copy d-flex flex-column gap-4">
          <p class="hero-kicker mb-0"><span class="bar"></span>S.M. REFAT AREFIN</p>
          <p class="hero-role mb-0">Business Analytics · Operations · Technology · Marketing</p>
          <h1 class="mb-0"><span>I TURN</span><span>COMPLEXITY</span><span>INTO <span class="accent">SYSTEMS.</span></span></h1>
          <p class="hero-desc mb-0">Business Analytics student and EdTech operations professional working at the intersection of data, operations, technology and digital content.</p>
          <div class="hero-ctas d-flex flex-wrap gap-3">
            <a href="#work" class="btn btn-primary">View My Work <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
            <a href="#about" class="btn btn-ghost">About Me <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
          </div>
        </div>
      </div>

      <div class="hero-stats d-flex flex-wrap gap-5">
        <div><div class="stat-num" data-count="3.6" data-decimals="1" data-suffix="+">3.6+</div><div class="stat-label">Years Professional Experience</div></div>
        <div><div class="stat-num">BBA</div><div class="stat-label">Business Analytics</div></div>
        <div><div class="stat-num" data-count="2">02</div><div class="stat-label">Core Industry — EdTech and Marketing</div></div>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
