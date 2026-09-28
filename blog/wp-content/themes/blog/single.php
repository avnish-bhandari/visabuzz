<?php
/**
 * Single Post Template
 *
 * @package Visabuz_Blog
 */

get_header();

// Default images matching theme design
$img_featured = 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1200&q=80';
$img_card_1   = 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=800&q=80';
$img_card_2   = 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=800&q=80';
$img_card_3   = 'https://images.unsplash.com/photo-1450133064473-71024230f91b?auto=format&fit=crop&w=800&q=80';

$current_post_id = 0;
$current_cats    = array();
?>

<article class="single-post-section py-4 py-md-5">
    <div class="container">
        <!-- Back Link -->
        <div class="mb-4">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-decoration-none text-muted d-inline-flex align-items-center gap-2">
                <span>&larr;</span> Back to Blog &amp; articles
            </a>
        </div>

        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); 
                $current_post_id = get_the_ID();
                $categories      = get_the_category();
                $cat_name        = ! empty( $categories ) ? $categories[0]->name : 'News';
                $current_cats    = wp_get_post_categories( $current_post_id );
                $thumb_url       = has_post_thumbnail() ? get_the_post_thumbnail_url( $current_post_id, 'large' ) : $img_featured;

                // Extract headings for Table of Contents
                $raw_content = get_the_content();
                preg_match_all( '/<h([2-3])[^>]*>(.*?)<\/h\1>/i', $raw_content, $matches, PREG_SET_ORDER );
                $toc_items = array();
                if ( ! empty( $matches ) ) {
                    foreach ( $matches as $index => $match ) {
                        $level = $match[1];
                        $title = wp_strip_all_tags( $match[2] );
                        $slug  = sanitize_title( $title );
                        if ( empty( $slug ) ) {
                            $slug = 'section-' . ( $index + 1 );
                        }
                        $toc_items[] = array(
                            'level' => $level,
                            'title' => $title,
                            'slug'  => $slug,
                        );
                    }
                }
            ?>
                <div class="row g-4 g-lg-5">
                    <!-- Left Side: Sticky Table of Contents -->
                    <aside class="col-12 col-lg-4 col-xl-3">
                        <div class="toc-sidebar sticky-top">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h3 class="toc-title mb-0">Table of Contents</h3>
                                <span class="badge bg-white text-secondary border">On this page</span>
                            </div>
                            <nav class="toc-nav">
                                <ul class="toc-list" id="toc-list">
                                    <?php if ( ! empty( $toc_items ) ) : ?>
                                        <?php foreach ( $toc_items as $index => $item ) : ?>
                                            <li class="toc-item toc-level-<?php echo esc_attr( $item['level'] ); ?>">
                                                <a href="#<?php echo esc_attr( $item['slug'] ); ?>" class="toc-link<?php echo 0 === $index ? ' active' : ''; ?>">
                                                    <?php echo esc_html( $item['title'] ); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <!-- Default Structured Sections -->
                                        <li class="toc-item"><a href="#overview" class="toc-link active">1. Overview &amp; Objectives</a></li>
                                        <li class="toc-item"><a href="#strategic-framework" class="toc-link">2. Strategic Framework</a></li>
                                        <li class="toc-item"><a href="#implementation-steps" class="toc-link">3. Implementation Steps</a></li>
                                        <li class="toc-item"><a href="#measuring-success" class="toc-link">4. Measuring Success</a></li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    </aside>

                    <!-- Right Side: Header, Banner Image, and Content Below -->
                    <main class="col-12 col-lg-8 col-xl-9">
                        <!-- Article Header -->
                        <header class="single-post-header mb-4">
                            <span class="post-badge mb-3"><?php echo esc_html( $cat_name ); ?></span>
                            <h1 class="page-heading mb-3"><?php the_title(); ?></h1>
                            <div class="text-muted small d-flex flex-wrap align-items-center gap-3">
                                <span>Published on <?php echo get_the_date(); ?></span>
                                <span>&bull;</span>
                                <span>By <?php the_author(); ?></span>
                                <span>&bull;</span>
                                <span>4 min read</span>
                            </div>
                        </header>

                        <!-- Banner Image at Top of Right Side -->
                        <div class="single-post-image mb-4">
                            <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php the_title_attribute(); ?>" class="single-post-hero-img">
                        </div>

                        <!-- Content Below Banner Image -->
                        <div class="single-post-content" id="post-article-content">
                            <?php
                            $filtered_content = apply_filters( 'the_content', get_the_content() );

                            if ( ! empty( $matches ) ) {
                                // Add ID attributes matching TOC links to headings
                                foreach ( $matches as $index => $match ) {
                                    $level = $match[1];
                                    $title = wp_strip_all_tags( $match[2] );
                                    $slug  = sanitize_title( $title );
                                    if ( empty( $slug ) ) {
                                        $slug = 'section-' . ( $index + 1 );
                                    }
                                    $pattern          = '/' . preg_quote( $match[0], '/' ) . '/';
                                    $replacement      = sprintf( '<h%s id="%s">%s</h%s>', $level, esc_attr( $slug ), $match[2], $level );
                                    $filtered_content = preg_replace( $pattern, $replacement, $filtered_content, 1 );
                                }
                                echo $filtered_content;
                            } else {
                                echo $filtered_content;

                                // If post body is empty or lacks subsections, show structured sections matching the TOC
                                if ( empty( trim( strip_tags( $filtered_content ) ) ) ) :
                            ?>
                                    <h2 id="overview">1. Overview &amp; Objectives</h2>
                                    <p>We offer a comprehensive range of services designed to meet the unique needs of your business. From strategy development to risk management, our expert team is dedicated to driving your success.</p>
                                    
                                    <h2 id="strategic-framework">2. Strategic Framework</h2>
                                    <p>Discover strategies to streamline your business processes and enhance productivity. Operational efficiency is about doing more with less, eliminating redundancies, and ensuring seamless cross-departmental collaboration.</p>

                                    <h2 id="implementation-steps">3. Implementation Steps</h2>
                                    <p>Proper implementation requires cross-functional alignment, consistent resource allocation, and proactive performance tracking to ensure objectives are achieved without disruptions.</p>

                                    <h2 id="measuring-success">4. Measuring Success</h2>
                                    <p>Sustainable success is measured through continuous feedback loops, clear KPIs, and the ongoing adaptation of operating models to dynamic market conditions.</p>
                            <?php
                                endif;
                            }
                            ?>
                        </div>
                    </main>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <!-- Fallback Mockup Layout when running without DB post -->
            <div class="row g-4 g-lg-5">
                <!-- Left Side: Sticky Table of Contents -->
                <aside class="col-12 col-lg-4 col-xl-3">
                    <div class="toc-sidebar sticky-top">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="toc-title mb-0">Table of Contents</h3>
                            <span class="badge bg-white text-secondary border">On this page</span>
                        </div>
                        <nav class="toc-nav">
                            <ul class="toc-list" id="toc-list">
                                <li class="toc-item"><a href="#overview" class="toc-link active">1. Overview &amp; Objectives</a></li>
                                <li class="toc-item"><a href="#strategic-framework" class="toc-link">2. Strategic Framework</a></li>
                                <li class="toc-item"><a href="#implementation-steps" class="toc-link">3. Implementation Steps</a></li>
                                <li class="toc-item"><a href="#measuring-success" class="toc-link">4. Measuring Success</a></li>
                            </ul>
                        </nav>
                    </div>
                </aside>

                <!-- Right Side: Header, Banner Image, and Content Below -->
                <main class="col-12 col-lg-8 col-xl-9">
                    <header class="single-post-header mb-4">
                        <span class="post-badge mb-3">News</span>
                        <h1 class="page-heading mb-3">Maximizing Efficiency in Operations</h1>
                        <div class="text-muted small d-flex flex-wrap align-items-center gap-3">
                            <span>Published on September 19, 2026</span>
                            <span>&bull;</span>
                            <span>By Visabuz Editorial</span>
                            <span>&bull;</span>
                            <span>4 min read</span>
                        </div>
                    </header>

                    <!-- Banner Image -->
                    <div class="single-post-image mb-4">
                        <img src="<?php echo esc_url( $img_featured ); ?>" alt="Maximizing Efficiency in Operations" class="single-post-hero-img">
                    </div>

                    <!-- Content Below -->
                    <div class="single-post-content" id="post-article-content">
                        <h2 id="overview">1. Overview &amp; Objectives</h2>
                        <p>We offer a comprehensive range of services designed to meet the unique needs of your business. From strategy development to risk management, our expert team is dedicated to driving your success.</p>
                        
                        <h2 id="strategic-framework">2. Strategic Framework</h2>
                        <p>Discover strategies to streamline your business processes and enhance productivity. Operational efficiency is about doing more with less, eliminating redundancies, and ensuring seamless cross-departmental collaboration.</p>

                        <h2 id="implementation-steps">3. Implementation Steps</h2>
                        <p>Proper implementation requires cross-functional alignment, consistent resource allocation, and proactive performance tracking to ensure objectives are achieved without disruptions.</p>

                        <h2 id="measuring-success">4. Measuring Success</h2>
                        <p>Sustainable success is measured through continuous feedback loops, clear KPIs, and the ongoing adaptation of operating models to dynamic market conditions.</p>
                    </div>
                </main>
            </div>
        <?php endif; ?>
    </div>
</article>

<!-- Related Posts and Blogs Section at the End -->
<section class="related-posts-section py-5 bg-light-subtle border-top">
    <div class="container">
        <!-- Eyebrow & Section Heading -->
        <div class="section-eyebrow d-flex align-items-center gap-2 mb-2">
            <span class="eyebrow-dot"></span>
            <span>Related articles</span>
        </div>
        <h2 class="section-heading mb-4 mb-lg-5">Related posts and blogs</h2>

        <?php
        // Query 3 related posts (same category, excluding current post)
        $related_query = new WP_Query( array(
            'posts_per_page'      => 3,
            'post__not_in'        => $current_post_id ? array( $current_post_id ) : array(),
            'category__in'        => ! empty( $current_cats ) ? $current_cats : array(),
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
        ) );
        ?>

        <div class="row g-4">
            <?php if ( $related_query->have_posts() ) : ?>
                <?php while ( $related_query->have_posts() ) : $related_query->the_post(); 
                    $rel_categories = get_the_category();
                    $rel_cat_name   = ! empty( $rel_categories ) ? $rel_categories[0]->name : 'News';
                    $rel_thumb_url  = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'medium_large' ) : $img_card_1;
                ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <article class="article-card">
                            <div class="article-card-img-box mb-3">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url( $rel_thumb_url ); ?>" alt="<?php the_title_attribute(); ?>" class="article-card-img">
                                </a>
                            </div>
                            <div class="article-card-body">
                                <span class="post-badge mb-2"><?php echo esc_html( $rel_cat_name ); ?></span>
                                <h3 class="article-card-title mb-2">
                                    <a href="<?php the_permalink(); ?>" class="text-decoration-none text-reset">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <p class="article-card-excerpt mb-0">
                                    <?php echo wp_strip_all_tags( get_the_excerpt() ); ?>
                                </p>
                            </div>
                        </article>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
                <!-- Fallback 3 Related Cards Matching Mockup -->
                <div class="col-12 col-md-6 col-lg-4">
                    <article class="article-card">
                        <div class="article-card-img-box mb-3">
                            <a href="#related-1">
                                <img src="<?php echo esc_url( $img_card_1 ); ?>" alt="Maximizing Efficiency in Operations" class="article-card-img">
                            </a>
                        </div>
                        <div class="article-card-body">
                            <span class="post-badge mb-2">News</span>
                            <h3 class="article-card-title mb-2">
                                <a href="#related-1" class="text-decoration-none text-reset">
                                    Maximizing Efficiency in Operations
                                </a>
                            </h3>
                            <p class="article-card-excerpt mb-0">
                                Discover strategies to streamline your business processes and enhance productivity.
                            </p>
                        </div>
                    </article>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <article class="article-card">
                        <div class="article-card-img-box mb-3">
                            <a href="#related-2">
                                <img src="<?php echo esc_url( $img_card_2 ); ?>" alt="Maximizing Efficiency in Operations" class="article-card-img">
                            </a>
                        </div>
                        <div class="article-card-body">
                            <span class="post-badge mb-2">News</span>
                            <h3 class="article-card-title mb-2">
                                <a href="#related-2" class="text-decoration-none text-reset">
                                    Maximizing Efficiency in Operations
                                </a>
                            </h3>
                            <p class="article-card-excerpt mb-0">
                                Discover strategies to streamline your business processes and enhance productivity.
                            </p>
                        </div>
                    </article>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <article class="article-card">
                        <div class="article-card-img-box mb-3">
                            <a href="#related-3">
                                <img src="<?php echo esc_url( $img_card_3 ); ?>" alt="Maximizing Efficiency in Operations" class="article-card-img">
                            </a>
                        </div>
                        <div class="article-card-body">
                            <span class="post-badge mb-2">News</span>
                            <h3 class="article-card-title mb-2">
                                <a href="#related-3" class="text-decoration-none text-reset">
                                    Maximizing Efficiency in Operations
                                </a>
                            </h3>
                            <p class="article-card-excerpt mb-0">
                                Discover strategies to streamline your business processes and enhance productivity.
                            </p>
                        </div>
                    </article>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
get_footer();
