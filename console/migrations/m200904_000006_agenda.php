<?php

use yii\db\Migration;

class m200904_000006_agenda extends Migration
{
    public function up()
    {
        $this->createTable('{{%agenda}}', [
            'id' => $this->primaryKey()->unsigned(),
            'bootcamp_id' => $this->integer()->unsigned(),
            'title' => $this->string()->notNull(),
            'date' => $this->string()->notNull(),
            'start_time' => $this->string(10)->notNull(),
            'end_time' => $this->string(10)->notNull(),
            'content' => $this->text()->notNull(),
            'video_url' => $this->string(255)->null(),
            'order' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('agendaBootcampIdFK', '{{%agenda}}', 'bootcamp_id', '{{%bootcamp}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('agendaBootcampIdFK', '{{%agenda}}');

        $this->dropTable('{{%agenda}}');
    }
}
