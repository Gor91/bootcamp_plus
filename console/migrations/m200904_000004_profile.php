<?php

use yii\db\Migration;

class m200904_000004_profile extends Migration
{
    public function up()
    {
        $this->createTable('{{%profile}}', [
            'id' => $this->primaryKey()->unsigned(),
            'bootcamp_id' => $this->integer()->unsigned(),
            'company_name' => $this->string()->notNull(),
            'info_url' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('profileBootcampIdFK', '{{%profile}}', 'bootcamp_id', '{{%bootcamp}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('profileBootcampIdFK', '{{%profile}}');

        $this->dropTable('{{%profile}}');
    }
}
