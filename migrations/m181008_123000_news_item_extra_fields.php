<?php

use yii\db\Migration;

/**
 * Class m181008_123000_news_item_extra_fields
 */
class m181008_123000_news_item_extra_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('news_item', 'template', $this->string()->after('type'));
        $this->addColumn('news_item', 'image_mobile', $this->string()->after('image'));
        $this->addColumn('news_item', 'link_page_id', $this->integer());
        $this->addColumn('news_item', 'link_page_blank', $this->boolean());

        $this->addColumn('news_item_lang', 'text', $this->text());
        $this->addColumn('news_item_lang', 'link_title', $this->string());
        $this->addColumn('news_item_lang', 'link_page_url', $this->string());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181008_123000_news_item_extra_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181008_123000_news_item_extra_fields cannot be reverted.\n";

        return false;
    }
    */
}
