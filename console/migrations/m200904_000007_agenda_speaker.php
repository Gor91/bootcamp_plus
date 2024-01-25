<?php

use yii\db\Migration;

class m200904_000007_agenda_speaker extends Migration
{
    public function up()
    {
        $this->createTable('{{%agenda_speaker}}', [
            'id' => $this->primaryKey()->unsigned(),
            'agenda_id' => $this->integer()->unsigned()->notNull(),
            'speaker_id' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('agendaSpeakerAgendaIdFK', '{{%agenda_speaker}}', 'agenda_id', '{{%agenda}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('agendaSpeakerSpeakerIdFK', '{{%agenda_speaker}}', 'speaker_id', '{{%person}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('agendaSpeakerAgendaIdFK', '{{%agenda_speaker}}');
        $this->dropForeignKey('agendaSpeakerSpeakerIdFK', '{{%agenda_speaker}}');

        $this->dropTable('{{%agenda_speaker}}');
    }
}
