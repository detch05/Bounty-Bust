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
            ? '<i class="bi bi-bookmark-fill fs-6"></i>'
            : '<i class="bi bi-bookmark fs-6"></i>';
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



document.addEventListener('click', function(e){
  if(e.target && e.target.id === 'showMore'){
    const extras = document.querySelectorAll('.extra-answer');
    const btn = e.target;
    const hidden = Array.from(extras).some(el => el.classList.contains('d-none'));
    extras.forEach(el => el.classList.toggle('d-none', !hidden)); // show if hidden, hide if shown
    btn.textContent = hidden ? 'Show less' : 'Show more';
  }
});


document.querySelectorAll('.mark-correct-form').forEach((form) => {
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const action = form.getAttribute('action');
        const card = form.closest('.answer-card');

        fetch(action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    // remove all "mark as correct" buttons to enforce single correct answer visually
                    document.querySelectorAll('.mark-correct-form').forEach(f => f.remove());

                    // highlight the accepted answer
                    if (card) {
                        card.classList.add('border-success', 'border-2', 'bg-success-subtle');
                        // add badge if missing
                        const existingBadge = card.querySelector('.correct-badge');
                        if (!existingBadge) {
                            const badge = document.createElement('span');
                            badge.className = 'badge bg-success ms-3 correct-badge';
                            badge.innerHTML = 'Correct Answer <i class="bi bi-check"></i>';
                            const actionsRow = card.querySelector('.d-flex.align-items-center.gap-3');
                            if (actionsRow) actionsRow.appendChild(badge);
                        }
                    }
                } else if (data.error) {
                    alert(data.error);
                }
            })
            .catch(() => {
                alert('Failed to mark as correct. Please try again.');
            });
    });
});
