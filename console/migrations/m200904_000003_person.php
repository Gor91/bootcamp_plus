<?php

use yii\db\Migration;

class m200904_000003_person extends Migration
{
    public function up()
    {
        $this->createTable('{{%person}}', [
            'id' => $this->primaryKey()->unsigned(),
            'type_id' => $this->integer()->unsigned(),
            'fName' => $this->string()->notNull(),
            'lName' => $this->string()->notNull(),
            'email' => $this->string(),
            'position' => $this->string()->notNull(),
            'company' => $this->string(),
            'image' => $this->string(),
            'link' => $this->string(),
            'order' => $this->integer()->unsigned(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('personTypeIdFK', '{{%person}}', 'type_id', '{{%person_type}}', 'id', null, 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('personTypeIdFK', '{{%person}}');

        $this->dropTable('{{%person}}');
    }
}
