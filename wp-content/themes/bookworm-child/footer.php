<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package bookworm
 */

?>

<?php the_widget('footer-1');?>

<footer class="site-footer site-footer--v1">
    <div class="border-top">
        <div class="border-bottom">
            <div class="container">
                <div class="row footer-supplier">
                    <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                        <?php dynamic_sidebar( 'footer-1' ); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="border-bottom main-footer">
            <div class="container">
                <div class="row footer-top-row">
                    <div class="col-lg-6 mb-6 mb-lg-0">
                        <div class="pb-6 address-company">
                            <?php echo get_custom_logo()?>
                            <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                                <?php dynamic_sidebar( 'footer-2' ); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-6 mb-lg-0 static-page">
                        <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                            <?php dynamic_sidebar( 'footer-3' ); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
        <div>
            <div class="container">
                <div class="d-lg-flex text-center text-lg-left justify-content-between align-items-center">
                    <div class="col-lg-6 mb-lg-0 ">
                        <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
                            <?php dynamic_sidebar( 'footer-4' ); ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-6 mb-lg-0 copy-right">
                        Bản quyền thuộc công ty cổ phần giáo dục Cánh Diều
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


<?php wp_footer(); ?>

</body>
</html>
