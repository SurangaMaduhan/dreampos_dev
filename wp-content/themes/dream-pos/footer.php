<script src="<?php echo get_bloginfo('template_directory'); ?>/src/js/popper.min.js"></script>
<script src="<?php echo get_bloginfo('template_directory'); ?>/src/js/bootstrap.min.js"></script>
<script src="<?php echo get_bloginfo('template_directory'); ?>/src/js/bootstrapV4.min.js"></script>
<!-- Bootstrap Core JS 



-->
<!-- Feather Icon JS -->
<script src="<?php echo get_bloginfo('template_directory'); ?>/src/js/feather.min.js"></script>

<!-- Slimscroll JS -->
<script src="<?php echo get_bloginfo('template_directory'); ?>/src/js/jquery.slimscroll.min.js"></script>

<!-- Datatable JS -->
<script src="<?php echo get_bloginfo('template_directory'); ?>/src/js/jquery.dataTables.min.js"></script>
<script src="<?php echo get_bloginfo('template_directory'); ?>/src/js/dataTables.bootstrap4.min.js"></script>

<!-- Chart JS -->
<script src="<?php echo get_bloginfo('template_directory'); ?>/src/js/apexcharts.min.js"></script>
<script src="<?php echo get_bloginfo('template_directory'); ?>/src/js/chart-data.js"></script>
<!-- Select2 JS -->
<script src="<?php echo get_bloginfo('template_directory'); ?>/src/js/select2.min.js"></script>

<!-- Sweetalert 2 -->
<script src="<?php echo get_bloginfo('template_directory'); ?>/src/js/sweetalert2.all.min.js"></script>
<script src="<?php echo get_bloginfo('template_directory'); ?>/src/js/sweetalerts.min.js"></script>
<script src="<?php echo get_bloginfo('template_directory'); ?>/src/js/featherlight.js"></script>
<script src="<?php echo get_bloginfo('template_directory'); ?>/src/js/slick.min.js"></script>
<!-- Custom JS -->
<script src="<?php echo get_bloginfo('template_directory'); ?>/src/js/script.js"></script>

<script>
  jQuery(document).ready(function ($) {
    $(document).on('added_to_cart', function (event, fragments, cart_hash) {
      $('.mini-cart').html(fragments['div.widget_shopping_cart_content']);
    });
  });

</script>
<?php wp_footer(); ?>
</body>

</html>