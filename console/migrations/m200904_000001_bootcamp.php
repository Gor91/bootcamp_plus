<?php

use yii\db\Migration;

class m200904_000001_bootcamp extends Migration
{
    public function up()
    {
        $this->createTable('{{%bootcamp}}', [
            'id' => $this->primaryKey()->unsigned(),
            'status_id' => $this->smallInteger(1)->defaultValue(1),
            'name' => $this->string()->notNull()->unique(),
            'slug' => $this->string()->notNull()->unique(),
            'header_image' => $this->string(),
            'image' => $this->string(),
            'about' => $this->text()->notNull(),
            'document' => $this->string(),
            'organizer_image' => $this->string(),
            'start_date' => $this->date()->notNull(),
            'end_date' => $this->date()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%bootcamp}}');
    }
}
