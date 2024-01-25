<?php

use yii\db\Migration;

class m200904_000010_person_bootcamp extends Migration
{
    public function up()
    {
        $this->createTable('{{%person_bootcamp}}', [
            'id' => $this->primaryKey()->unsigned(),
            'bootcamp_id' => $this->integer()->unsigned(),
            'person_id' => $this->integer()->unsigned(),
        ]);

        $this->addForeignKey('personBootcampBootcampIdFK', '{{%person_bootcamp}}', 'bootcamp_id', '{{%bootcamp}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('personBootcampPersonIdFK', '{{%person_bootcamp}}', 'person_id', '{{%person}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('personBootcampBootcampIdFK', '{{%person_bootcamp}}');
        $this->dropForeignKey('personBootcampPersonIdFK', '{{%person_bootcamp}}');

        $this->dropTable('{{%person_bootcamp}}');
    }
}
