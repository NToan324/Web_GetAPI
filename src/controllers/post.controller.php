<?php
require_once __DIR__ . '/../models/Post.php';

class PostController {
    public function loadAllPost() {
        // cua tri luu lam
    }

    public function create($userId) {
        // Thêm bài viết cho một user cụ thể
        // TODO: createPost (lam cai nay di)
    }

    public function modify() {
        // TODO: cai nay sai PUT de tao nghien cuu ai
    }

    public function delete() {
        // TODO: cai nay sai delete
    }

    public function like($postId, $userId) {

    }
}