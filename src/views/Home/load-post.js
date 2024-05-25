function renderPosts(posts, user) {
    posts.sort((a, b) => {
        const dateA = new Date(a.created_at);
        const dateB = new Date(b.created_at);
        return dateB - dateA; // Later created time comes first (descending)
    });
    const postContainer = $('.main-posts')
    posts.forEach((post) => {
        let createdAt = new Date(post.created_at)
        let now = new Date()
        let diffInHours = Math.abs(now - createdAt) / 36e5
        let time = ''

        if (diffInHours < 24) {
            time = Math.floor(diffInHours) + ' hours ago'
        } else {
            time = createdAt.toLocaleDateString()
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
                    <div class="caption">
                        <p>${post.content}</p>
                    </div>
                    <img src="/Web_RestAPI/storage/posts/${post.image}" alt="" />
                    <div class="post-info">
                        <div class="likes">
                            <i class="far fa-heart" onclick="liked(this)"></i>
                        </div>
                        <div class="comments">
                            <i class="far fa-comment-dots"></i>
                        </div>
                    </div>
                    <div class="likes-comments-info">
                        <span>${post.total_likes} Likes</span>
                        <div class="comments-show">
                            <div class ="comments-user">
                                <h4>${post.user_name}</h4>
                                <p>${post.content}</p>
                            </div>  
                        </div>
                        <div class="write-comments">
                        <form>
                            <input type="text" placeholder="Write a comment..." />
                            <button type="submit"><i class="far fa-paper-plane"></i></button>
                        </form>
                        </div>
                    </div>
                </div>
                `

        postContainer.append(html)
    })
}

$.get('/Web_RestAPI/loadAllPost', (res) => {
    if (res.success) {
        renderPosts(res.data.posts, res.data.user)
    } else {
        console.log(res)
    }
})
