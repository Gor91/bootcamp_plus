<?php

use yii\db\Migration;

class m200904_000005_profile_video extends Migration
{
    public function up()
    {
        $this->createTable('{{%profile_video}}', [
            'id' => $this->primaryKey()->unsigned(),
            'profile_id' => $this->integer()->unsigned(),
            'path' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('profileVideoProfileIdFK', '{{%profile_video}}', 'profile_id', '{{%profile}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('profileVideoProfileIdFK', '{{%profile_video}}');

        $this->dropTable('{{%profile_video}}');
    }
}
