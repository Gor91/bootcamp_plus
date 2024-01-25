<?php

use yii\db\Migration;

class m200904_000014_bootcamp_gallery extends Migration
{
    public function up()
    {
        $this->createTable('{{%bootcamp_gallery}}', [
            'id' => $this->primaryKey()->unsigned(),
            'bootcamp_id' => $this->integer()->unsigned()->notNull(),
            'image' => $this->string()->notNull(),
            'order' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('bootcampGalleryBootcampIdFK', '{{%bootcamp_gallery}}', 'bootcamp_id', '{{%bootcamp}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('bootcampGalleryBootcampIdFK', '{{%bootcamp_gallery}}');

        $this->dropTable('{{%bootcamp_gallery}}');
    }
}
