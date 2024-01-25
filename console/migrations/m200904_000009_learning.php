<?php

use yii\db\Migration;

class m200904_000009_learning extends Migration
{
    public function up()
    {
        $this->createTable('{{%learning}}', [
            'id' => $this->primaryKey()->unsigned(),
            'category_id' => $this->integer()->unsigned(),
            'name' => $this->string()->unique(),
            'image' => $this->string(),
            'link' => $this->string(),
            'order' => $this->integer()->unsigned(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('learningCategoryIdFK', '{{%learning}}', 'category_id', '{{%learning_category}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('learningCategoryIdFK', '{{%learning}}');

        $this->dropTable('{{%learning}}');
    }
}
