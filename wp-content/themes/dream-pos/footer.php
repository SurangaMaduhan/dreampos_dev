<script src="<?php echo get_bloginfo('template_directory'); ?>/src/js/bootstrap.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="<?php echo get_bloginfo('template_directory'); ?>/src/js/bootstrap.bundle.min.js"></script>

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
<!-- Custom JS -->
<script src="<?php echo get_bloginfo('template_directory'); ?>/src/js/script.js"></script>

<script>
  const dropArea = document.getElementById('drop-area');
  const fileInput = document.getElementById('file-input');
  const filePreview = document.getElementById('file-preview');
  const removeBtn = document.getElementById('remove-btn');
  const hide_wrap = document.getElementById('preview_wrap');

  // dropArea.addEventListener('dragover', (e) => {
  //   e.preventDefault();
  //   dropArea.classList.add('highlight');
  // });

  // dropArea.addEventListener('dragleave', () => {
  //   dropArea.classList.remove('highlight');
  // });

  // dropArea.addEventListener('drop', (e) => {
  //   e.preventDefault();
  //   dropArea.classList.remove('highlight');

  //   const files = e.dataTransfer.files;
  //   handleFiles(files);
  // });

  fileInput.addEventListener('change', () => {
    const files = fileInput.files;
    handleFiles(files);
  });

  removeBtn.addEventListener('click', () => {
    fileInput.value = ''; // Clear file input
    hideImagePreview();
  });

  function handleFiles(files) {
    if (files.length > 0) {
      const file = files[0];
      if (file.type.startsWith('image/')) {
        showImagePreview(file);
      } else {
        hideImagePreview();
      }
    } else {
      hideImagePreview();
    }
  }

  function showImagePreview(file) {
    const reader = new FileReader();

    reader.onload = function (e) {
      filePreview.src = e.target.result;
      hide_wrap.style.display = 'block'; // Show the image preview
    };

    reader.readAsDataURL(file);
  }

  function hideImagePreview() {
    filePreview.src = '';
    hide_wrap.style.display = 'none'; // Hide the image preview
  }


  jQuery(document).ready(function ($) {
    // Update mini cart when a product is added to the cart
    $(document).on('added_to_cart', function (event, fragments, cart_hash) {
      // Update the mini cart contents
      $('.mini-cart').html(fragments['div.widget_shopping_cart_content']);
    });
  });

</script>
<?php wp_footer(); ?>
</body>

</html>