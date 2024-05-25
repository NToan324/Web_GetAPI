function renderPosts(posts, user) {
    posts.sort((a, b) => {
        const dateA = new Date(a.created_at);
        const dateB = new Date(b.created_at);
        return dateB - dateA; // Later created time comes first (descending)
    });
    const postContainer = $('.personal-page-post');
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

        let html = `
            <!-- Confirm delte post -->
            <div id="ConfirmDeletePost" class="hidden">
                <div class="confirm-delete-post">
                    <p>Are you sure you want to delete this post?</p>
                    <button id="deleteBtn">Delete</button>
                    <button id="cancelDeleteBtn">Cancel</button>
                </div>
            </div>
            <div class="post-box" data-id="${post.id}">
                <div class="post-profile">
                    <div class="post-img">
                        <img src="/Web_RestAPI/storage/users/${post.avatar}" alt="" />
                    </div>
                    <div class="post-name">
                        <h3>${post.user_name}</h3>
                        <p>${time}</p>
                    </div>
                </div>
                <div>
                ${post.content}
                </div>
                <img src="/Web_RestAPI/storage/posts/${post.image}" alt="" />
                <div class="post-info">
                    <div class="likes">
                        <i class="far fa-heart" onclick="liked(this)"></i>
                    </div>
                    <div class="comments">
                        <i class="far fa-comment-dots"></i>
                    </div>
                    <div class="edit-post">
                        <i class="far fa-edit" onclick="editPost(this)"></i>
                    </div>
                    <div class="delete-post">
                        <i class="far fa-trash-alt" onclick="deletePost()"></i>
                    </div>

                </div>
                <div class="likes-comments-info">
                    <span>${post.total_likes} Likes</span>
                    <div class="comments-show">
                        <div class="comments-user">
                            <h4>${post.user_name}</h4>
                            <p class="post-content" data-content="${post.content}">${post.content}</p>
                        </div>
                    </div>
                    <form>
                        <div class="write-comments">
                            <input type="text" placeholder="Write a comment..." />
                            <button type="submit"><i class="far fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        `;

        postContainer.append(html);
    });
}

function editPost(element) {
    const postBox = $(element).closest('.post-box');
    const contentElement = postBox.find('.post-content');
    const originalContent = contentElement.data('content');
    const formElement = $(`
        <form class="edit-form">
            <input type="text" class="edit-input" value="${originalContent}"/>
            <button type="button" class="save-button">Save</button>
        </form>
    `);

    contentElement.replaceWith(formElement);

    const inputElement = formElement.find('.edit-input');
    inputElement.focus();

    formElement.on('submit', function (event) {
        event.preventDefault();
    });

    formElement.find('.save-button').on('click', function () {
        const newContent = inputElement.val();
        formElement.replaceWith(`<p class="post-content" data-content="${newContent}">${newContent}</p>`);
        
        // TODO: Gọi API để cập nhật nội dung mới lên server
    });

    inputElement.on('blur', function () {
        const newContent = inputElement.val();
        formElement.replaceWith(`<p class="post-content" data-content="${newContent}">${newContent}</p>`);

        // console.log('New content:', newContent);

        const postId = postBox.data('id');
        $.post('/Web_RestAPI/edit-post', { id: postId, content: newContent }, (res) => {
            if (res.success) {
                console.log('Post updated successfully');
            } else {
                console.log(res);
            }
        });
    });
}

$.get('/Web_RestAPI/load-profile', (res) => {
    if (res.success) {
        renderPosts(res.data.posts, res.data.user);
    } else {
        console.log(res);
    }
});
