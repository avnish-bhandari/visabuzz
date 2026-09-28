<?php
/**
 * footer.php — CMS Layout Footer
 * Closes the .cms-content, .cms-main, and .cms-shell wrappers opened by header.php
 */
?>
    </main><!-- /.cms-content -->
  </div><!-- /.cms-main -->
</div><!-- /.cms-shell -->

<!-- Toast container (populated by cms.js) -->
<div id="cms-toast-container"></div>

<!-- CKEditor 5 Classic Build -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
if (typeof ClassicEditor === 'undefined') {
    document.write('<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@41.4.2/build/ckeditor.min.js"><\/script>');
}
</script>

<!-- CMS JS -->
<script src="<?= $cmsRoot ?>assets/cms.js"></script>
</body>
</html>
