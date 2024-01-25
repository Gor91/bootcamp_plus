<?php

use yii\db\Migration;

class m200904_000008_learning_category extends Migration
{
    public function up()
    {
        $this->createTable('{{%learning_category}}', [
            'id' => $this->primaryKey()->unsigned(),
            'bootcamp_id' => $this->integer()->unsigned(),
            'name' => $this->string()->notNull(),
            'order' => $this->integer()->unsigned(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('learningCategoryBootcampIdFK', '{{%learning_category}}', 'bootcamp_id', '{{%bootcamp}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('learningCategoryBootcampIdFK', '{{%learning_category}}');

        $this->dropTable('{{%learning_category}}');
    }
}
