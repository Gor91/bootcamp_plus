<?php

use yii\db\Migration;

class m200904_000013_bootcamp_logos extends Migration
{
    public function up()
    {
        $this->createTable('{{%bootcamp_logos}}', [
            'id' => $this->primaryKey()->unsigned(),
            'bootcamp_id' => $this->integer()->unsigned()->notNull(),
            'logo' => $this->string()->notNull(),
            'link' => $this->string(),
            'order' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('bootcampLogosBootcampIdFK', '{{%bootcamp_logos}}', 'bootcamp_id', '{{%bootcamp}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('bootcampLogosBootcampIdFK', '{{%bootcamp_logos}}');

        $this->dropTable('{{%bootcamp_logos}}');
    }
}
