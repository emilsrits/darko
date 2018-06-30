<?php
/**
 * Template for displaying footer
 *
 * @package Mloc
 */
?>

    <footer id="site-footer">
        <div class="container">
			<?php
			get_template_part( 'template-parts/footer/footer', 'widgets' );

			get_template_part( 'template-parts/footer/footer', 'info' );
			?>
        </div> <!-- .container -->
    </footer> <!-- #site-footer -->
</div> <!-- #wrapper -->
<?php wp_footer(); ?>
</body>
</html>