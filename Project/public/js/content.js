document.querySelectorAll(".voteZone").forEach((section) => {
    const contentId = section.dataset.contentId;
    const upvoteBtn = section.querySelector(".upvoteBtn");
    const downvoteBtn = section.querySelector(".downvoteBtn");
    const ratingDisplay = section.querySelector(".rating");

    let userVote = parseInt(section.dataset.userVote) || 0;
    let curVal = parseInt(ratingDisplay.innerText);

    update();

    function update() {
        ratingDisplay.innerText = curVal;
        upvoteBtn.querySelector("i").style.color =
            userVote === 1 ? "var(--terciary-color)" : "black";
        downvoteBtn.querySelector("i").style.color =
            userVote === -1 ? "var(--primary-color)" : "black";
    }

    function sendVote(vote) {
        fetch(`/content/${contentId}/vote`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({ vote }),
        })
            .then((res) => {
                return res.json();
            })
            .then((data) => {
                curVal = data.rating;
                update();
            });
    }

    upvoteBtn.addEventListener("click", () => {
        userVote = userVote === 1 ? 0 : 1;
        sendVote(userVote);
    });

    downvoteBtn.addEventListener("click", () => {
        userVote = userVote === -1 ? 0 : -1;
        sendVote(userVote);
    });
});

document.querySelectorAll(".followBtn").forEach((button) => {
    const contentId = button.dataset.contentId;
    
    let isFollowing = button.dataset.isFollowing === "1";
    const icon = button.querySelector("i");

    function update() {
        button.innerHTML = isFollowing
            ? '<i class="bi bi-bookmark-fill fs-5"></i>'
            : '<i class="bi bi-bookmark fs-5"></i>';
        const icon = button.querySelector("i");
        icon.style.color = isFollowing ? "var(--secondary-color)" : "black";
    }

    update();

    button.addEventListener("click", () => {
        fetch(`/content/${contentId}/follow`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        })
            .then((res) => res.json())
            .then((data) => {
                isFollowing = data.isFollowing;
                button.dataset.isFollowing = isFollowing;
                update();
            });
    });
});

document.querySelectorAll(".replyBtn").forEach((btn)=>{
    btn.addEventListener("click", () => {
        const commentCard = btn.closest(".comment_card");
        const replyForm = commentCard.querySelector(".reply-form");

        document.querySelectorAll(".reply-form").forEach(f => {
            if (f !== replyForm) f.classList.add("d-none");
        });

         replyForm.classList.toggle("d-none");

        const textarea = replyForm.querySelector("textarea");
        textarea.focus();
    });
});

document.querySelectorAll(".cancel-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
        const replyForm = btn.closest(".reply-form");
        replyForm.classList.add("d-none");
    });
});