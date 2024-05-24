<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddForeignKeys extends AbstractMigration
{
    public function change()
    {
        // Add foreign key constraints
        $this->table('POSTS')
            ->addForeignKey('user_id', 'USERS', 'user_id', ['delete' => 'CASCADE'])
            ->update();

        $this->table('COMMENTS')
            ->addForeignKey('post_id', 'POSTS', 'post_id', ['delete' => 'CASCADE'])
            ->addForeignKey('user_id', 'USERS', 'user_id', ['delete' => 'CASCADE'])
            ->update();

        $this->table('LIKES')
            ->addForeignKey('post_id', 'POSTS', 'post_id', ['delete' => 'CASCADE'])
            ->addForeignKey('user_id', 'USERS', 'user_id', ['delete' => 'CASCADE'])
            ->update();
    }
}
