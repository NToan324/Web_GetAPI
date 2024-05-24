<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    public function change()
    {
        $users = $this->table('USERS', ['id' => false, 'primary_key' => 'user_id']);
        $users->addColumn('user_id', 'integer', ['identity' => true])
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('avatar', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('bio', 'text', ['null' => true])
            ->addColumn('birthday', 'datetime', ['null' => true])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['email'], ['unique' => true])
            ->create();
    }
}
