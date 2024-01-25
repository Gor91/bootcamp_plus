<?php

use yii\db\Migration;

class m200904_000000_admin extends Migration
{
    public function up()
    {
        $this->createTable('{{%admin}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'created' => $this->integer()->unsigned(),
            'updated' => $this->integer()->unsigned()
        ]);

        $this->insert('{{%admin}}', [
            'name' => 'Bootcamp',
            'email' => 'admin@bootcamp.eif.am',
            'password' => '$2y$13$q7DEFj19FtKYiRHtxgKiIuhRToSTFPdzHb5ZhlKNf4l10RGaajM/K' // EIFBootcamp1234!
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%admin}}');
    }
}
