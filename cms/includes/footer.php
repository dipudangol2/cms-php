<div id="toast"></div>
<script type="text/javascript" src="<?php echo $base_path ?>js/mdb.umd.min.js"></script>
<!-- Toast Notifications -->
<script>
   function showToast(message, position, type) {
      const toast = document.getElementById("toast");
      toast.className = toast.className + " show";

      if (message) {
         toast.innerHTML = message;
      }
      if (position !== "") {
         toast.className = toast.className + ` ${position}`;
      }
      if (type !== "") {
         toast.className = toast.className + ` ${type}`;
      }
      setTimeout(function() {
         toast.className = toast.className.replace(" show", "");
      }, 3000);
   }
</script>
<?php get_message(); ?>
</body>

</html>