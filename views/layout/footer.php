<?php
// views/layout/footer.php
?>
<!-- Bootstrap JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom scripts (sidebar toggle, optional) -->
<script>
  // Optional: make sidebar links active on click (visual only)
  document.querySelectorAll('.admin-sidebar a.menu-item').forEach(a=>{
    a.addEventListener('click', ()=> {
      document.querySelectorAll('.admin-sidebar a.menu-item').forEach(x=>x.classList.remove('active'));
      a.classList.add('active');
    });
  });
</script>
</body>
</html>
