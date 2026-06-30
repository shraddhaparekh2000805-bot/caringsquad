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

        const icon = this.querySelector("i");

        icon.classList.toggle("fa-bars");
        icon.classList.toggle("fa-xmark");

    });

    document.querySelectorAll(".mobile-nav a").forEach(link => {

        link.addEventListener("click", function () {

            mobileNav.classList.remove("active");

            const icon = mobileBtn.querySelector("i");

            icon.classList.remove("fa-xmark");
            icon.classList.add("fa-bars");

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



    const doctorCards =
    document.querySelectorAll(".doctor-list-card");

    const paginationContainer =
    document.getElementById("paginationNumbers");

    const prevBtn =
    document.getElementById("prevPage");

    const nextBtn =
    document.getElementById("nextPage");

    /* HOW MANY DOCTORS PER PAGE */

    const doctorsPerPage = 4;

    let currentPage = 1;

    const totalPages =
    Math.ceil(doctorCards.length / doctorsPerPage);

    /* SHOW PAGE */

    function showPage(page){

        currentPage = page;

        /* HIDE ALL */

        doctorCards.forEach((card) => {

            card.style.display = "none";

        });

        /* SHOW CURRENT PAGE */

        const start =
        (page - 1) * doctorsPerPage;

        const end =
        start + doctorsPerPage;

        doctorCards.forEach((card,index) => {

            if(index >= start && index < end){

                card.style.display = "grid";

            }

        });

        /* UPDATE BUTTONS */

        renderPagination();

    }

    /* PAGINATION BUTTONS */

    function renderPagination(){

        paginationContainer.innerHTML = "";

        for(let i = 1; i <= totalPages; i++){

            const button =
            document.createElement("button");

            button.classList.add("page-number");

            button.innerText = i;

            if(i === currentPage){

                button.classList.add("active");

            }

            button.addEventListener("click", () => {

                showPage(i);

                window.scrollTo({
                    top:
                    document.querySelector(".doctor-list-main")
                    .offsetTop - 120,

                    behavior: "smooth"
                });

            });

            paginationContainer.appendChild(button);

        }

        /* PREV/NEXT DISABLE */

        prevBtn.disabled = currentPage === 1;

        nextBtn.disabled =
        currentPage === totalPages;

    }

    /* PREVIOUS */

    prevBtn.addEventListener("click", () => {

        if(currentPage > 1){

            showPage(currentPage - 1);

        }

    });

    /* NEXT */

    nextBtn.addEventListener("click", () => {

        if(currentPage < totalPages){

            showPage(currentPage + 1);

        }

    });

    /* INITIAL */

    showPage(1);

});
