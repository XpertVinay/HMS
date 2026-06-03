    </div>
</section>
<script>
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebarBtn");
    if(sidebarBtn) {
        sidebarBtn.onclick = function () {
            sidebar.classList.toggle("close");
            if (sidebar.classList.contains("close")) {
                sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else {
                sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
            }
        }
    }
</script>
</body>
</html>
