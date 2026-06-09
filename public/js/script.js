// Register GSAP Plugins
gsap.registerPlugin(ScrollTrigger);

// Loading Screen Functionality
function showLoadingScreen() {
    const loadingScreen = document.getElementById("loadingScreen");
    const loadingOverlay = document.getElementById("loadingOverlay");
    const progressBar = document.getElementById("loadingProgress");

    // Reset progress
    progressBar.style.width = "0%";
    progressBar.classList.remove("from-green-500", "to-emerald-600");
    progressBar.classList.add("from-blue-600", "to-indigo-600");

    // Show loading screen
    loadingScreen.classList.add("loading-active");
    loadingOverlay.classList.remove("hidden");

    // Animate progress bar
    let progress = 0;
    const progressInterval = setInterval(() => {
        progress += Math.random() * 15;
        if (progress > 100) progress = 100;
        progressBar.style.width = `${progress}%`;

        // Change color based on progress
        if (progress > 70) {
            progressBar.classList.add("from-green-500", "to-emerald-600");
            progressBar.classList.remove("from-blue-600", "to-indigo-600");
        }

        if (progress >= 100) {
            clearInterval(progressInterval);
        }
    }, 100);

    return () => {
        clearInterval(progressInterval);
    };
}

function hideLoadingScreen() {
    const loadingScreen = document.getElementById("loadingScreen");
    const loadingOverlay = document.getElementById("loadingOverlay");
    const progressBar = document.getElementById("loadingProgress");

    // Hide loading screen with animation
    loadingScreen.classList.remove("loading-active");
    setTimeout(() => {
        loadingOverlay.classList.add("hidden");
        progressBar.style.width = "0%";
        progressBar.classList.remove("from-green-500", "to-emerald-600");
        progressBar.classList.add("from-blue-600", "to-indigo-600");
    }, 500);
}

// Navigation with Loading
function navigateWithLoading(url) {
    const hideLoading = showLoadingScreen();

    // Simulate loading time
    setTimeout(() => {
        window.location.href = url;
    }, 1500);

    return hideLoading;
}

// Parallax effect for floating elements
gsap.utils.toArray(".floating-element").forEach((element) => {
    gsap.to(element, {
        y: 30,
        duration: 3,
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut",
    });
});

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
    // Mobile Menu Toggle
    window.toggleMobileMenu = function () {
        const mobileMenu = document.getElementById("mobileMenu");
        mobileMenu.classList.toggle("hidden");
    };

    // Smooth scrolling untuk tautan anchor
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();
            const href = this.getAttribute("href");

            // Skip if it's just "#"
            if (href === "#") return;

            // Don't prevent default for demo button in CTA section
            if (this.id === "ctaDemoBtn" || this.id === "demoBtn") {
                // Just scroll without preventing default
                return;
            }

            e.preventDefault();

            const targetId = href;
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                gsap.to(window, {
                    duration: 1,
                    scrollTo: {
                        y: targetElement,
                        offsetY: 80,
                    },
                    ease: "power2.inOut",
                });
            }
        });
    });

    // Loading screen untuk tombol
    document.querySelectorAll(".loading-button").forEach((button) => {
        button.addEventListener("click", function (e) {
            if (this.tagName === "A" && this.getAttribute("href") !== "#") {
                e.preventDefault();
                const href = this.getAttribute("href");
                navigateWithLoading(href);
            }
        });
    });

    // Initialize GSAP Animations
    initAnimations();

    // Initialize Navbar Scroll Effect
    initNavbarScroll();

    // Hide loading screen on page load
    setTimeout(hideLoadingScreen, 1000);
});

// GSAP Animations
function initAnimations() {
    // Hero section animation
    gsap.from(".hero-content", {
        duration: 0,
        y: 50,
        opacity: 0,
        ease: "power3.out",
        delay: 0,
    });

    // Hover animations for cards
    document.querySelectorAll(".hover-card").forEach((card) => {
        card.addEventListener("mouseenter", () => {
            gsap.to(card, {
                scale: 1.03,
                duration: 0.3,
                ease: "back.out(1.7)",
            });
        });

        card.addEventListener("mouseleave", () => {
            gsap.to(card, {
                scale: 1,
                duration: 0.3,
                ease: "power2.out",
            });
        });
    });

    // Button hover animations
    document.querySelectorAll(".loading-button").forEach((button) => {
        button.addEventListener("mouseenter", () => {
            gsap.to(button, {
                scale: 1.05,
                duration: 0.2,
                ease: "power2.out",
            });
        });

        button.addEventListener("mouseleave", () => {
            gsap.to(button, {
                scale: 1,
                duration: 0.2,
                ease: "power2.out",
            });
        });
    });

    // Parallax effect for hero image
    gsap.to(".animate-float", {
        yPercent: -10,
        ease: "none",
        scrollTrigger: {
            trigger: ".hero-content",
            start: "top bottom",
            end: "bottom top",
            scrub: true,
        },
    });
}

// ===== NAVBAR SCROLL EFFECT =====
function initNavbarScroll() {
    const navbar = document.getElementById("navbar");
    let ticking = false;

    function updateNavbar() {
        const currentScroll = window.pageYOffset;

        // Add or remove 'scrolled' class based on scroll position
        if (currentScroll > 50) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }

        // lastScroll = currentScroll;
        ticking = false;
    }

    // Use requestAnimationFrame for better performance
    window.addEventListener("scroll", function () {
        if (!ticking) {
            window.requestAnimationFrame(updateNavbar);
            ticking = true;
        }
    });

    // Initialize navbar state on page load
    updateNavbar();
}

// Handle page transitions
window.addEventListener("beforeunload", function () {
    showLoadingScreen();
});

// Handle back/forward navigation
window.addEventListener("pageshow", function (event) {
    if (event.persisted) {
        hideLoadingScreen();
    }
});
