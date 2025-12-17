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
<script>
document.addEventListener('DOMContentLoaded', function () {

    const customerList = document.getElementById('customer-list');
    const adultInput = document.getElementById('adult');
    const childInput = document.getElementById('child');
    const totalPriceInput = document.getElementById('total_price');
    const tourSelect = document.getElementById('tour_select');

    // =============================
    // CẬP NHẬT THỐNG KÊ
    // =============================
    function updateStatistic() {
        let adult = 0;
        let child = 0;

        document.querySelectorAll('.customer-type').forEach(select => {
            if (select.value === 'adult') adult++;
            else child++;
        });

        adultInput.value = adult;
        childInput.value = child;

        const price = tourSelect.selectedOptions[0]?.dataset.price || 0;
        totalPriceInput.value = (adult + child) * price;
    }

    // =============================
    // THÊM KHÁCH
    // =============================
    customerList.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-add')) {
            const item = e.target.closest('.customer-item');
            const clone = item.cloneNode(true);

            clone.querySelectorAll('input').forEach(i => i.value = '');
            clone.querySelector('.customer-type').value = 'adult';

            clone.querySelector('.btn-add').outerHTML =
                '<button type="button" class="btn btn-danger btn-remove">−</button>';

            customerList.appendChild(clone);
            updateStatistic();
        }

        // =============================
        // XOÁ KHÁCH
        // =============================
        if (e.target.classList.contains('btn-remove')) {
            e.target.closest('.customer-item').remove();
            updateStatistic();
        }
    });

    // =============================
    // ĐỔI LOẠI KHÁCH
    // =============================
    customerList.addEventListener('change', function (e) {
        if (e.target.classList.contains('customer-type')) {
            updateStatistic();
        }
    });

    // =============================
    // ĐỔI TOUR
    // =============================
    tourSelect.addEventListener('change', updateStatistic);

    updateStatistic();
});
</script>

</body>
</html>
