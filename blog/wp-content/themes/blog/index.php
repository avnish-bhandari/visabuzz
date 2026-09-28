<?php
/**
 * Main Template File (Blog & Articles Page)
 *
 * @package Visabuz_Blog
 */

get_header();

// Fetch published posts
$featured_query = new WP_Query( array(
    'posts_per_page'      => 1,
    'post_status'         => 'publish',
    'ignore_sticky_posts' => 1,
) );

// Default fallback images matching the approved design
$img_featured = 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1200&q=80';
$img_card_1   = 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=800&q=80';
$img_card_2   = 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=800&q=80';
$img_card_3   = 'https://images.unsplash.com/photo-1450133064473-71024230f91b?auto=format&fit=crop&w=800&q=80';

// Categories for filter pills
$wp_categories = get_categories( array( 'hide_empty' => true ) );
$default_categories = array(
    'marketing-tips'      => 'Marketing Tips',
    'business-strategies' => 'Business Strategies',
    'industry-insights'   => 'Industry Insights',
    'client-success'      => 'Client Success',
);
?>

<section class="blog-hero-section py-4 py-md-5">
    <div class="container">
        <!-- Page Heading -->
        <h1 class="page-heading mb-4">Blog & articles</h1>

        <!-- Category Filter Pills -->
        <div class="category-filters d-flex flex-wrap gap-2 mb-4 mb-lg-5">
            <a href="#" class="category-filter-btn active" data-category="all">All</a>
            <?php if ( ! empty( $wp_categories ) ) : ?>
                <?php foreach ( $wp_categories as $cat ) : ?>
                    <a href="#" class="category-filter-btn" data-category="<?php echo esc_attr( $cat->slug ); ?>">
                        <?php echo esc_html( $cat->name ); ?>
                    </a>
                <?php endforeach; ?>
            <?php else : ?>
                <?php foreach ( $default_categories as $slug => $label ) : ?>
                    <a href="#" class="category-filter-btn" data-category="<?php echo esc_attr( $slug ); ?>">
                        <?php echo esc_html( $label ); ?>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Featured Post Section -->
        <?php if ( $featured_query->have_posts() ) : ?>
            <?php while ( $featured_query->have_posts() ) : $featured_query->the_post(); 
                $categories = get_the_category();
                $cat_name   = ! empty( $categories ) ? $categories[0]->name : 'News';
                $cat_slug   = ! empty( $categories ) ? $categories[0]->slug : 'news';
                $thumb_url  = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'large' ) : $img_featured;
            ?>
                <article class="featured-post-wrap filter-item mb-5" data-category="<?php echo esc_attr( $cat_slug ); ?>">
                    <div class="row g-4 align-items-center">
                        <div class="col-12 col-lg-7">
                            <div class="featured-img-box">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php the_title_attribute(); ?>" class="featured-img">
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-lg-5 ps-lg-4">
                            <span class="post-badge mb-3"><?php echo esc_html( $cat_name ); ?></span>
                            <h2 class="featured-title mb-3">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <p class="featured-excerpt mb-4">
                                <?php echo wp_strip_all_tags( get_the_excerpt() ); ?>
                            </p>
                            <a href="<?php the_permalink(); ?>" class="btn-read-more">Read more</a>
                        </div>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata(); ?>
        <?php else : ?>
            <!-- Fallback Featured Post Matching Mockup -->
            <article class="featured-post-wrap filter-item mb-5" data-category="business-strategies">
                <div class="row g-4 align-items-center">
                    <div class="col-12 col-lg-7">
                        <div class="featured-img-box">
                            <a href="#featured">
                                <img src="<?php echo esc_url( $img_featured ); ?>" alt="Maximizing Efficiency in Operations" class="featured-img">
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5 ps-lg-4">
                        <span class="post-badge mb-3">News</span>
                        <h2 class="featured-title mb-3">
                            <a href="#featured">Maximizing Efficiency in Operations</a>
                        </h2>
                        <p class="featured-excerpt mb-4">
                            We offer a comprehensive range of services designed to meet the unique needs of your business. From strategy development to risk management, our expert team is dedicated to driving your success.
                        </p>
                        <a href="#featured" class="btn-read-more">Read more</a>
                    </div>
                </div>
            </article>
        <?php endif; ?>
    </div>
</section>

<!-- Latest Insights and Trends Section -->
<section class="latest-posts-section py-4 py-md-5">
    <div class="container">
        <!-- Eyebrow & Section Heading -->
        <div class="section-eyebrow d-flex align-items-center gap-2 mb-2">
            <span class="eyebrow-dot"></span>
            <span>Blog and articles</span>
        </div>
        <h2 class="section-heading mb-4 mb-lg-5">Latest insights and trends</h2>

        <?php
        // Query next posts (excluding first featured post if posts exist)
        $grid_query = new WP_Query( array(
            'posts_per_page'      => 6,
            'offset'              => 1,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
        ) );
        ?>

        <div class="row g-4" id="articles-grid">
            <?php if ( $grid_query->have_posts() ) : ?>
                <?php while ( $grid_query->have_posts() ) : $grid_query->the_post(); 
                    $categories = get_the_category();
                    $cat_name   = ! empty( $categories ) ? $categories[0]->name : 'News';
                    $cat_slug   = ! empty( $categories ) ? $categories[0]->slug : 'news';
                    $thumb_url  = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'medium_large' ) : $img_card_1;
                ?>
                    <div class="col-12 col-md-6 col-lg-4 filter-item" data-category="<?php echo esc_attr( $cat_slug ); ?>">
                        <article class="article-card">
                            <div class="article-card-img-box mb-3">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php the_title_attribute(); ?>" class="article-card-img">
                                </a>
                            </div>
                            <div class="article-card-body">
                                <span class="post-badge mb-2"><?php echo esc_html( $cat_name ); ?></span>
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
                <!-- Fallback 3-Card Grid Matching Mockup -->
                <div class="col-12 col-md-6 col-lg-4 filter-item" data-category="marketing-tips">
                    <article class="article-card">
                        <div class="article-card-img-box mb-3">
                            <a href="#article-1">
                                <img src="<?php echo esc_url( $img_card_1 ); ?>" alt="Maximizing Efficiency in Operations" class="article-card-img">
                            </a>
                        </div>
                        <div class="article-card-body">
                            <span class="post-badge mb-2">News</span>
                            <h3 class="article-card-title mb-2">
                                <a href="#article-1" class="text-decoration-none text-reset">
                                    Maximizing Efficiency in Operations
                                </a>
                            </h3>
                            <p class="article-card-excerpt mb-0">
                                Discover strategies to streamline your business processes and enhance productivity.
                            </p>
                        </div>
                    </article>
                </div>

                <div class="col-12 col-md-6 col-lg-4 filter-item" data-category="industry-insights">
                    <article class="article-card">
                        <div class="article-card-img-box mb-3">
                            <a href="#article-2">
                                <img src="<?php echo esc_url( $img_card_2 ); ?>" alt="Maximizing Efficiency in Operations" class="article-card-img">
                            </a>
                        </div>
                        <div class="article-card-body">
                            <span class="post-badge mb-2">News</span>
                            <h3 class="article-card-title mb-2">
                                <a href="#article-2" class="text-decoration-none text-reset">
                                    Maximizing Efficiency in Operations
                                </a>
                            </h3>
                            <p class="article-card-excerpt mb-0">
                                Discover strategies to streamline your business processes and enhance productivity.
                            </p>
                        </div>
                    </article>
                </div>

                <div class="col-12 col-md-6 col-lg-4 filter-item" data-category="client-success">
                    <article class="article-card">
                        <div class="article-card-img-box mb-3">
                            <a href="#article-3">
                                <img src="<?php echo esc_url( $img_card_3 ); ?>" alt="Maximizing Efficiency in Operations" class="article-card-img">
                            </a>
                        </div>
                        <div class="article-card-body">
                            <span class="post-badge mb-2">News</span>
                            <h3 class="article-card-title mb-2">
                                <a href="#article-3" class="text-decoration-none text-reset">
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