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

/* =========================
   Reports page
========================= */

document.addEventListener("DOMContentLoaded", function () {

    const fill = document.querySelector(".fill");

    if (fill) {
        const width = fill.style.width;
        setTimeout(() => {
            fill.style.width = width;
        }, 200);
    }

});


function showDaily() {

    document.getElementById("daily").style.display = "block";
    document.getElementById("weekly").style.display = "none";

    document.getElementById("dailyBtn").classList.add("active");
    document.getElementById("weeklyBtn").classList.remove("active");
}

function showWeekly() {

    document.getElementById("daily").style.display = "none";
    document.getElementById("weekly").style.display = "block";

    document.getElementById("weeklyBtn").classList.add("active");
    document.getElementById("dailyBtn").classList.remove("active");
}