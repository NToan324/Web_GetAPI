<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostsTable extends AbstractMigration
{
    public function change()
    {
        $posts = $this->table('POSTS', ['id' => false, 'primary_key' => 'post_id']);
        $posts->addColumn('post_id', 'integer', ['identity' => true])
            ->addColumn('user_id', 'integer')
            ->addColumn('content', 'text')
            ->addColumn('total_likes', 'integer')
            ->addColumn('image', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
