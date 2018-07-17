<?php

use yii\db\Migration;

/**
 * Class m180717_094742_news_item
 */
class m180717_094742_news_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%news_item}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'news_id' => $this->bigInteger(),
            'publish' => $this->boolean(),
            'sort' => $this->bigInteger(),
            'type' => $this->string(),
            'languages' => $this->string(),
            'image' => $this->string(),
        ]);

        $this->createTable('{{%news_item_lang}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'news_item_id' => $this->bigInteger()->unsigned()->notNull(),
            'language' => $this->string(10),
            'title' => $this->string(),
        ]);

        $this->createIndex('news_id', '{{%news_item}}', ['news_id']);
        $this->createIndex('news_item_id', '{{%news_item_lang}}', ['news_item_id']);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news_item}}');
        $this->dropTable('{{%news_item_lang}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180717_094742_news_item cannot be reverted.\n";

        return false;
    }
    */
}
