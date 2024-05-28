document.addEventListener("DOMContentLoaded", function () {
    // Retrieve and apply sidebar state from localStorage
    const sidebarState = localStorage.getItem("sidebarState");
    if (sidebarState === "expand") {
        document.querySelector("#sidebar").classList.add("expand");
    } else {
        document.querySelector("#sidebar").classList.remove("expand");
    }

    // Retrieve and apply dropdown state from localStorage
    const dropdownState = localStorage.getItem("dropdownState");
    if (dropdownState) {
        const targetDropdown = document.querySelector(dropdownState);
        if (targetDropdown) {
            targetDropdown.classList.add("show");
            const parentItem = targetDropdown.closest('.sidebar-item');
            parentItem.querySelector('.sidebar-link').classList.remove("collapsed");
            parentItem.querySelector('.sidebar-link').setAttribute("aria-expanded", "true");
        }
    }

    // Add event listener to sidebar items for managing dropdowns
    const sidebarItems = document.querySelectorAll(".sidebar-item .sidebar-link");
    sidebarItems.forEach(function (item) {
        item.addEventListener("click", function (event) {
            const dataBsTarget = event.currentTarget.getAttribute("data-bs-target");
            if (dataBsTarget) {
                // Close all other dropdowns
                const dropdowns = document.querySelectorAll(".sidebar-dropdown");
                dropdowns.forEach(function (dropdown) {
                    if ("#" + dropdown.id !== dataBsTarget) {
                        dropdown.classList.remove("show");
                        dropdown.parentElement.querySelector('.sidebar-link').classList.add("collapsed");
                        dropdown.parentElement.querySelector('.sidebar-link').setAttribute("aria-expanded", "false");
                    }
                });

                // Store the dropdown state in localStorage
                localStorage.setItem("dropdownState", dataBsTarget);
            }
        });
    });
});

// Add event listener to the hamburger button for toggling sidebar state
const hamBurger = document.querySelector(".toggle-btn");
hamBurger.addEventListener("click", function () {
    const sidebar = document.querySelector("#sidebar");
    sidebar.classList.toggle("expand");

    // Store the sidebar state in localStorage
    if (sidebar.classList.contains("expand")) {
        localStorage.setItem("sidebarState", "expand");
    } else {
        localStorage.setItem("sidebarState", "collapse");
    }
});
