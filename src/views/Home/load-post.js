function renderPosts(posts, user) {
    posts.sort((a, b) => {
        const dateA = new Date(a.created_at);
        const dateB = new Date(b.created_at);
        return dateB - dateA; // Later created time comes first (descending)
    });
    const postContainer = $('.main-posts');
    posts.forEach((post) => {
        let createdAt = new Date(post.created_at);
        let now = new Date();
        let diffInHours = Math.abs(now - createdAt) / 36e5;
        let time = '';

        if (diffInHours < 24) {
            time = Math.floor(diffInHours) + ' hours ago';
        } else {
            time = createdAt.toLocaleDateString();
        }

        fetch(`/Web_RestAPI/comments?id=${post.id}`)
            .then(response => response.json())
            .then(data => {
                let commentsHtml = '';
                if (data.data && data.data.length > 0) {
                    data.data.forEach(comment => {
                        commentsHtml += `
                            <div class="comments-group">
                                <h4>${comment.name}</h4>
                                <p>${comment.content}</p>
                            </div>`;
                    });
                }

                let html = `
                    <div class="post-box">
                        <div class="post-profile">
                            <div class="post-img">
                                <img src="/Web_RestAPI/storage/users/${post.avatar}" alt="" />
                            </div>
                            <div class="post-name">
                                <h3>${post.user_name}</h3>
                                <p>${time}</p>
                            </div>
                        </div>
                        <div>${post.content}</div>
                        <img src="/Web_RestAPI/storage/posts/${post.image}" alt="" />
                        <div class="post-info">
                            <div class="likes">
                                <i id="like-btn" class="far fa-heart" onclick="liked(this)"></i>
                            </div>
                            <div class="comments">
                                <i class="far fa-comment-dots"></i>
                            </div>
                        </div>
                        <div class="likes-comments-info">
                            <span>${post.total_likes} ${post.total_likes > 1 ? 'Likes' : 'Like'}</span>
                            <div class="comments-show">
                                <div class="comments-user">
                                    ${commentsHtml}
                                </div>
                            </div>
                            <form id="comment-form" method="post" action="/Web_RestAPI/comment">
                                <input type="hidden" name="post_id" value="${post.id}" />
                                <div class="write-comments">
                                    <input type="text" name="content" placeholder="Write a comment..." />
                                    <button type="submit"><i class="far fa-paper-plane"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>`;
                postContainer.append(html);
                checkLikeStatus(post.id)
            })
            .catch(error => {
                console.error('Error fetching comments:', error);
            });
    });
}

$.get('/Web_RestAPI/loadAllPost', (res) => {
    if (res.success) {
        renderPosts(res.data.posts, res.data.user);
    } else {
        console.log(res);
    }
});

// Add click event to like button
$(document).on('click', '#like-btn', function () {
    const postId = $(this).data('post-id'); // Get the post ID from data attribute
    fetch('/Web_RestAPI/like', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ postId: postId }) // Send the post ID in the request body
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the UI to reflect the like action
                $(this).toggleClass('liked'); // Toggle the 'liked' class to visually indicate the like status
                // Update the like count if needed
            } else {
                console.error('Error liking post:', data.message);
            }
        })
    
});


function checkLikeStatus(postId) {
    fetch(`/Web_RestAPI/check-like-status?id=${postId}`)
        .then(response => response.json())
        .then(data => {
            if (data.liked) {
                $('#like-btn').click()
            }
        })
        .catch(error => {
            console.error('Error checking like status:', error.message);
        });
}



$('#comment-form').submit(function (e) {
    e.preventDefault();
    console.log('coment');
    let formData = $(this).serialize();
    fetch($(this).attr('action'), {
        method: 'POST',
        body: formData
    })
<<<<<<< HEAD
    .then(response => response.json())
    .then(data => {
        window.location.reload(); // Reload the page after successful comment submission
        if (data.success) {
        } else {
            console.error('Error submitting comment:', data.message);
        }
    })
    .catch(error => {
        console.error('Error submitting comment:', error);
    });
=======
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                console.error('Error submitting comment:', data.message);
            }
        })
        .catch(error => {
            console.error('Error submitting comment:', error);
        });
>>>>>>> ea2ce91c5791a5565060fa491213ccdd0eb7b3b7
});


