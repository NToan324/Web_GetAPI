<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateLikesTable extends AbstractMigration
{
    public function change()
    {
        $likes = $this->table('LIKES', ['id' => false, 'primary_key' => 'like_id']);
        $likes->addColumn('like_id', 'integer', ['identity' => true])
            ->addColumn('post_id', 'integer')
            ->addColumn('user_id', 'integer')
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
