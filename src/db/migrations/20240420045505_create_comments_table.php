<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCommentsTable extends AbstractMigration
{
    public function change()
    {
        $comments = $this->table('COMMENTS', ['id' => false, 'primary_key' => 'comment_id']);
        $comments->addColumn('comment_id', 'integer', ['identity' => true])
            ->addColumn('post_id', 'integer')
            ->addColumn('user_id', 'integer')
            ->addColumn('comment', 'text')
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
