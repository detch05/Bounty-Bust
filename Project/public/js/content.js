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
        const token = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content");
      
        fetch(`/content/${contentId}/vote`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": token,
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
