<?php

use common\models\User;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->insert('{{%user}}', [
        	'username' => 'admin',
	        'auth_key' => Yii::$app->security->generateRandomString(),
	        'password_hash' => Yii::$app->security->generatePasswordHash('MNwo9c21mNxtS2'),
	        'email' => 'support@example.com',
	        'status' => User::STATUS_ACTIVE,
	        'created_at' => time(),
	        'updated_at' => time(),
        ]);

	    $this->createTable('{{%token}}', [
		    'id' => $this->primaryKey(),
		    'user_id' => $this->integer()->notNull(),
		    'token' => $this->string()->notNull()->unique(),
		    'expired_at' => $this->integer()->notNull(),
	    ], $tableOptions);

	    $this->addForeignKey('fk_token_user', '{{%token}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%station}}', [
        	'id' => $this->primaryKey(),
	        'name' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%carrier}}', [
        	'id' => $this->primaryKey(),
	        'name' => $this->string()->notNull(),
        ]);

        $this->createTable('{{%schedule}}', [
        	'id' => $this->primaryKey(),
	        'departure_station_id' => $this->integer()->notNull(),
	        'departure_time' => $this->integer()->notNull(),
	        'arrival_station_id' => $this->integer()->notNull(),
	        'arrival_time' => $this->integer()->notNull(),
	        'ticket_price' => $this->money()->notNull(),
	        'carrier_id' => $this->integer()->notNull(),
	        'schedule' => $this->tinyInteger()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_schedule_departure', '{{%schedule}}', 'departure_station_id', '{{%station}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_schedule_arrival', '{{%schedule}}', 'arrival_station_id', '{{%station}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_schedule_carrier', '{{%schedule}}', 'carrier_id', '{{%carrier}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%schedule}}');
        $this->dropTable('{{%station}}');
        $this->dropTable('{{%carrier}}');
	    $this->dropTable('{{%token}}');
        $this->dropTable('{{%user}}');
    }
}
