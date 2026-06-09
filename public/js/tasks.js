// Update current date and time
function updateDateTime() {
    const now = new Date();
    const dateOptions = {
        day: "numeric",
        month: "short",
        year: "numeric",
    };
    const timeOptions = {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    };

    document.getElementById("currentDate").textContent = now.toLocaleDateString(
        "id-ID",
        dateOptions,
    );
    document.getElementById("currentTime").textContent = now.toLocaleTimeString(
        "id-ID",
        timeOptions,
    );
}

// Filter tasks functionality
function filterTasks(filterType) {
    const tasks = document.querySelectorAll(".task-item");
    const emptyState = document.getElementById("emptyState");
    let visibleCount = 0;

    tasks.forEach((task) => {
        const status = task.getAttribute("data-status");
        const title = task.querySelector("h3").textContent.toLowerCase();
        const description = task.querySelector("p").textContent.toLowerCase();
        const client =
            task
                .querySelectorAll(".flex.items-center.gap-2")[1]
                ?.textContent.toLowerCase() || "";
        const project =
            task
                .querySelectorAll(".flex.items-center.gap-2")[0]
                ?.textContent.toLowerCase() || "";
        const searchQuery = document
            .getElementById("searchInput")
            .value.toLowerCase();

        const matchesFilter = filterType === "semua" || status === filterType;
        const matchesSearch =
            !searchQuery ||
            title.includes(searchQuery) ||
            description.includes(searchQuery) ||
            client.includes(searchQuery) ||
            project.includes(searchQuery);

        if (matchesFilter && matchesSearch) {
            task.style.display = "block";
            visibleCount++;
        } else {
            task.style.display = "none";
        }
    });

    // Show/hide empty state
    if (visibleCount === 0) {
        emptyState.classList.remove("hidden");
    } else {
        emptyState.classList.add("hidden");
    }

    // Update filter buttons
    document.querySelectorAll(".filter-btn").forEach((btn) => {
        const btnFilter = btn.getAttribute("data-filter");
        if (btnFilter === filterType) {
            btn.classList.remove("bg-gray-100", "text-gray-600");
            btn.classList.add("bg-blue-600", "text-white");
        } else {
            btn.classList.remove("bg-blue-600", "text-white");
            btn.classList.add("bg-gray-100", "text-gray-600");
        }
    });
}

// Initialize
document.addEventListener("DOMContentLoaded", function () {
    // Update date/time initially and every second
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Filter buttons
    document.querySelectorAll(".filter-btn").forEach((btn) => {
        btn.addEventListener("click", function () {
            const filterType = this.getAttribute("data-filter");
            filterTasks(filterType);
        });
    });

    // Search input
    document
        .getElementById("searchInput")
        .addEventListener("input", function () {
            const currentFilter =
                document
                    .querySelector(".filter-btn.bg-blue-600")
                    ?.getAttribute("data-filter") || "semua";
            filterTasks(currentFilter);
        });

    // Add task button
    document
        .getElementById("addTaskBtn")
        .addEventListener("click", function () {
            alert(
                'Fitur "Tambah Tugas" akan membuka form penambahan tugas baru.',
            );
            // In a real application, you would show a modal or navigate to a form page
        });

    // Initialize with "Semua" filter
    filterTasks("semua");

    // Add hover effects to all interactive elements
    const interactiveElements = document.querySelectorAll(
        "a, button, .task-item",
    );
    interactiveElements.forEach((el) => {
        el.addEventListener("mouseenter", () => {
            el.classList.add("hover-lift");
        });
        el.addEventListener("mouseleave", () => {
            el.classList.remove("hover-lift");
        });
    });

    // Animate progress bars on scroll
    const observerOptions = {
        threshold: 0.2,
        rootMargin: "0px 0px -50px 0px",
    };

    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const progressBar = entry.target;
                progressBar.classList.add("progress-animate");
            }
        });
    }, observerOptions);

    document.querySelectorAll(".progress-animate").forEach((bar) => {
        progressObserver.observe(bar);
    });
});
