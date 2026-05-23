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


const vestBtn = document.getElementById("vestBtn");
const helmetBtn = document.getElementById("helmetBtn");

const vestSection = document.getElementById("vestSection");
const helmetSection = document.getElementById("helmetSection");

if (vestBtn) {
    vestBtn.addEventListener("click", () => {

        vestBtn.classList.add("active");
        helmetBtn.classList.remove("active");

        vestSection.style.display = "grid";
        helmetSection.style.display = "none";

    });
}

if (helmetBtn) {
    helmetBtn.addEventListener("click", () => {

        helmetBtn.classList.add("active");
        vestBtn.classList.remove("active");

        helmetSection.style.display = "grid";
        vestSection.style.display = "none";

    });
}

function confirmDelete(event) {

    event.preventDefault();

    const confirmed = confirm(
        'Are you sure you want to delete this vehicle?'
    );

    if (confirmed) {
        event.target.submit();
    }
}

function initEchoListener() {
    if (window.authUserId && window.Echo) {
        console.log("Echo is ready! Subscribing to channel...");
        window.Echo
            .private(`App.Models.User.${window.authUserId}`)
            .notification((notification) => {

                if ("Notification" in window) {
                    if (Notification.permission === "granted") {
                        new Notification(notification.title || 'New Notification', {
                            body: notification.message || '',
                        });
                    } else if (Notification.permission !== "denied") {
                        Notification.requestPermission().then(permission => {
                            if (permission === "granted") {
                                new Notification(notification.title || 'New Notification', {
                                    body: notification.message || '',
                                });
                            }
                        });
                    }
                }

                const domAudio = document.getElementById('alarm-audio');
                console.log("تلقينا الإشعار! هل عنصر الصوت موجود في الصفحة؟", !!domAudio);
                if (domAudio) {
                    domAudio.currentTime = 0;
                    domAudio.play()
                        .then(() => console.log("✅ تم تشغيل الصوت بنجاح"))
                        .catch(e => console.error("❌ فشل تشغيل الصوت (الغالب أن المتصفح منعه):", e));
                }

            });
    } else if (window.authUserId) {
        // Echo is not yet defined because Vite module is still loading
        setTimeout(initEchoListener, 500);
    }
}
initEchoListener();

document.addEventListener('click', () => {
    if ("Notification" in window && Notification.permission !== "denied" && Notification.permission !== "granted") {
        Notification.requestPermission();
    }
}, { once: true });