document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const followButtons = document.querySelectorAll('.follow-btn');

    followButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const tagId = this.dataset.tagId;
            const isFollowing = this.classList.contains('btn-danger');
            const url = isFollowing ? `/tags/${tagId}/unfollow` : `/tags/${tagId}/follow`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('Network error');
                if (isFollowing) {
                    btn.classList.remove('btn-danger');
                    btn.classList.add('btn-outline-success');
                    btn.innerHTML = '<i class="bi bi-star"></i> Follow';
                } else {
                    btn.classList.remove('btn-outline-success');
                    btn.classList.add('btn-danger');
                    btn.innerHTML = '<i class="bi bi-star-fill"></i> Following';
                }
            })
            .catch(err => console.error(err));
        });
    });
});
