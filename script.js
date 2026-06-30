/* =========================================
   CARING SQUAD™ UNIVERSAL JS
========================================= */

document.addEventListener("DOMContentLoaded", () => {

    /* =====================================
       STICKY HEADER
    ===================================== */

    const header = document.querySelector(".header");
    if (header) {

    window.addEventListener("scroll", () => {

        if (window.scrollY > 20) {
            header.style.boxShadow = "0 10px 30px rgba(0,0,0,0.08)";
        } else {
            header.style.boxShadow = "none";
        }

    });

}

/* =====================================
   MOBILE MENU
===================================== */

const mobileBtn = document.getElementById("mobileMenuBtn");
const mobileNav = document.getElementById("mobileNav");

if (mobileBtn && mobileNav) {

    mobileBtn.addEventListener("click", function () {

        mobileNav.classList.toggle("active");

        const icon = mobileBtn.querySelector("i");

        if (icon) {
            icon.classList.toggle("fa-bars");
            icon.classList.toggle("fa-xmark");
        }

    });

    document.querySelectorAll(".mobile-nav a").forEach(link => {

        link.addEventListener("click", function () {

            mobileNav.classList.remove("active");

            const icon = mobileBtn.querySelector("i");

            if (icon) {
                icon.classList.remove("fa-xmark");
                icon.classList.add("fa-bars");
            }

        });

    });

}

    /* =====================================
       SCROLL ANIMATION
    ===================================== */

    const animatedItems = document.querySelectorAll(
        ".support-card, .ecosystem-card, .testimonial-card, .why-item, .mission-card, .story-card, .leader-card, .timeline-item, .stat-box, .different-item"
    );

    const observer = new IntersectionObserver((entries) => {

        entries.forEach((entry) => {

            if(entry.isIntersecting){

                entry.target.classList.add("show-item");
                 observer.unobserve(entry.target);

            }

        });

    }, {
        threshold: 0.15
    });

    animatedItems.forEach((item) => {

        item.classList.add("hidden-item");
        observer.observe(item);

    });

/* =========================================
   DOCTOR PAGINATION
========================================= */

const doctorCards = document.querySelectorAll(".doctor-list-card");

if (doctorCards.length > 0) {

    const paginationContainer = document.getElementById("paginationNumbers");
    const prevBtn = document.getElementById("prevPage");
    const nextBtn = document.getElementById("nextPage");
    const doctorListMain = document.querySelector(".doctor-list-main");

    // Safety check
    if (!paginationContainer || !prevBtn || !nextBtn) {
        return;
    }

    const doctorsPerPage = 4;
    let currentPage = 1;

    const totalPages = Math.ceil(doctorCards.length / doctorsPerPage);

    function showPage(page) {

        currentPage = page;

        doctorCards.forEach(card => {
            card.style.display = "none";
        });

        const start = (page - 1) * doctorsPerPage;
        const end = start + doctorsPerPage;

        doctorCards.forEach((card, index) => {

            if (index >= start && index < end) {
                card.style.display = "grid";
            }

        });

        renderPagination();
    }

    function scrollToDoctors(){

    if(doctorListMain){

        window.scrollTo({
            top:doctorListMain.offsetTop-120,
            behavior:"smooth"
        });

    }

}

showPage(currentPage-1);
scrollToDoctors();

showPage(currentPage+1);
scrollToDoctors();

    function renderPagination() {

        paginationContainer.innerHTML = "";

        for (let i = 1; i <= totalPages; i++) {

            const button = document.createElement("button");

            button.className = "page-number";
            button.textContent = i;

            if (i === currentPage) {
                button.classList.add("active");
            }

            button.addEventListener("click", () => {

                showPage(i);

                if (doctorListMain) {
                    window.scrollTo({
                        top: doctorListMain.offsetTop - 120,
                        behavior: "smooth"
                    });
                }

            });

            paginationContainer.appendChild(button);

        }

        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages;

    }

    prevBtn.addEventListener("click", () => {

        if (currentPage > 1) {
            showPage(currentPage - 1);
        }

    });

    nextBtn.addEventListener("click", () => {

        if (currentPage < totalPages) {
            showPage(currentPage + 1);
        }

    });

    showPage(1);

}