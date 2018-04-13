<?php

use yii\db\Migration;

/**
 * Class m180413_092705_news_table
 */
class m180413_092705_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%news}}', [
            'id' => $this->bigPrimaryKey()->unsigned()->notNull(),
            'publish' => $this->boolean(),
            'type' => $this->string(),
            'create_date' => $this->date(),
            'image' => $this->string(),
            'languages' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ], $tableOptions);

        $this->createTable('{{%news_lang}}', [
            'id' => $this->bigPrimaryKey()->unsigned()->notNull(),
            'news_id' => $this->bigInteger()->unsigned()->notNull(),
            'language' => $this->string(10),
            'title' => $this->string(),
            'link' => $this->string(),
            'author' => $this->string(),
            'text' => $this->text()
        ], $tableOptions);

        $this->createIndex('news_id', '{{%news_lang}}', ['news_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180413_092705_news_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180413_092705_news_table cannot be reverted.\n";

        return false;
    }
    */
}
