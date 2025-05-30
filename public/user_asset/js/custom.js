
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.mainmenu > ul > li > a').forEach(function(link) {
            link.addEventListener('click', function() {
                document.querySelectorAll('.mainmenu > ul > li').forEach(function(li) {
                    li.classList.remove('active');
                });
                this.parentElement.classList.add('active');
            });
        });
        document.querySelectorAll('.mobile-menu ul > li > a').forEach(function(link) {
            link.addEventListener('click', function() {
                document.querySelectorAll('.mobile-menu ul > li').forEach(function(li) {
                    li.classList.remove('active');
                });
                this.parentElement.classList.add('active');
            });
        });
    });
    let topNav = document.getElementById("top-nav");
    let menuBar = document.getElementById("menu-bar");
    let lastScrollTop = 0;

    window.addEventListener("scroll", function () {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > 150) {
            menuBar.classList.add("sticky");
            topNav.style.display = "none";
        } else {
            menuBar.classList.remove("sticky");
            topNav.style.display = "block"; 
        }

        lastScrollTop = scrollTop;
    });
    