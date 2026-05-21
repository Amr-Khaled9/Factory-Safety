console.log("Safety Supervisor Dashboard Loaded");

/* =========================
   USER DROPDOWN
========================= */

function toggleDropdown() {

    document
        .getElementById("dropdownMenu")
        ?.classList
        .toggle("show");
}

window.addEventListener("click", function (e) {

    const dropdown = document.querySelector(".user-dropdown");

    if (dropdown && !dropdown.contains(e.target)) {

        document
            .getElementById("dropdownMenu")
            ?.classList
            .remove("show");
    }
});

/* =========================
   SAFETY CHART
========================= */

const chartElement = document.getElementById("safetyChart");

if (chartElement && window.chartData) {

    new Chart(chartElement, {

        type: "bar",

        data: {

            labels: Object.keys(window.chartData),

            datasets: [{
                label: "Today's Violations",

                data: Object.values(window.chartData),

                borderWidth: 1,
                borderRadius: 10,
                barThickness: 120,
                maxBarThickness: 140,
            }]
        },

        options: {

            responsive: true,

            plugins: {

                legend: {
                    display: false
                }
            },

            scales: {

                y: {
                    beginAtZero: true
                }
            }
        }
    });
}