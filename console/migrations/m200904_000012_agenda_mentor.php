<?php

use yii\db\Migration;

class m200904_000012_agenda_mentor extends Migration
{
    public function up()
    {
        $this->createTable('{{%agenda_mentor}}', [
            'id' => $this->primaryKey()->unsigned(),
            'agenda_id' => $this->integer()->unsigned()->notNull(),
            'mentor_id' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('agendaMentorAgendaIdFK', '{{%agenda_mentor}}', 'agenda_id', '{{%agenda}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('agendaMentorSpeakerIdFK', '{{%agenda_mentor}}', 'mentor_id', '{{%person}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('agendaMentorAgendaIdFK', '{{%agenda_mentor}}');
        $this->dropForeignKey('agendaMentorSpeakerIdFK', '{{%agenda_mentor}}');

        $this->dropTable('{{%agenda_mentor}}');
    }
}
