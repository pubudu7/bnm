<?php
/**
 * The template for displaying author info.
 * 
 * @package BNM
 */

if ( false === get_theme_mod( 'bnm_show_author_bio', true ) ) {
    return;
}

$bnm_author_avatar = get_avatar( get_the_author_meta( 'ID' ), 80 );
$bnm_posts_author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
?>

<div class="bnm-author-bio">
    <?php if ( $bnm_author_avatar ) : ?>
        <div class="bnm-author-image">
            <a href="<?php echo esc_url( $bnm_posts_author_url ); ?>" rel="author">
                <?php
                // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo $bnm_author_avatar;
                ?>
            </a>
        </div>
    <?php endif; ?>
    <div class="bnm-author-content">
        <div class="bnm-author-name"><a href="<?php echo esc_url( $bnm_posts_author_url ); ?>" rel="author"><?php echo esc_html( get_the_author() );?></a></div>
        <div class="bnm-author-description"><?php echo wp_kses_post( wpautop( get_the_author_meta( 'description' ) ) ); ?></div>
        <a class="bnm-author-link" href="<?php echo esc_url( $bnm_posts_author_url ); ?>" rel="author">
            <?php
                /* translators: %s is the current author's name. */
                printf( esc_html__( 'More by %s', 'bnm' ), esc_html( get_the_author() ) );
            ?>
        </a>
    </div>
</div>