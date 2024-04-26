function renderPosts(posts) {
    const postContainer = $('.main-posts')
    posts.forEach(post => {
        let html = `
                            <div class="post-box">
                            <div class="post-profile">
                                <div class="post-img">
                                    <img src="../../../storage/users/${post.avatar}" alt="" />
                                </div>
                                <h3>${post.user_name}</h3>
                                <span>23 hours</span>
                            </div>
                            <div class="caption">
                                <p>${post.content}</p>
                            </div>
                            <img src="../../../storage/posts/${post.image}" alt="" />
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
                                        <h4>Nhật Toàn</h4>
                                        <p>${post.content}</p>
                                    </div>  
                                </div>
                                <div class="write-comments">
                                    <input type="text" placeholder="Write a comment..." />
                                    <i class="far fa-paper-plane"></i>
                                </div>
                            </div>
                        </div>
                        `

        postContainer.append(html)

    });
}

$.get('/loadAllPost', (res) => {
    if (res.success) {
        renderPosts(res.data)
    } else {
        console.log(res)
    }
})