<?php

use yii\db\Migration;

class m200904_000002_person_type extends Migration
{
    public function up()
    {
        $this->createTable('{{%person_type}}', [
            'id' => $this->primaryKey()->unsigned(),
            'title' => $this->string()->notNull()->unique()
        ]);

        $this->insert('{{%person_type}}', ['title' => 'Mentor']);
        $this->insert('{{%person_type}}', ['title' => 'Speaker']);
    }

    public function down()
    {
        $this->dropTable('{{%person_type}}');
    }
}
