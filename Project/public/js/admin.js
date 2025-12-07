document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".tab-btn");
    const content = document.getElementById("admin_content");

    buttons.forEach((btn) => {
        btn.addEventListener("click", function () {
            buttons.forEach((b) => b.classList.remove("active"));
            this.classList.add("active");

            fetch(this.dataset.url)
                .then((res) => res.text())
                .then((html) => {
                    content.innerHTML = html;
                    updateRoles();
                });
        });
    });

    buttons[0].click();
});


function updateRoles() {
    document.querySelectorAll(".user_role").forEach((p) => {
        const role = p.textContent.trim().toLowerCase();
        p.classList.remove("user", "admin", "mod");

        if (role === "user") p.classList.add("user");
        if (role === "admin") p.classList.add("admin");
        if (role === "mod") p.classList.add("mod");
    });
}


