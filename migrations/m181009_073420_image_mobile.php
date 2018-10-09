<?php

use yii\db\Migration;

/**
 * Class m181009_073420_image_mobile
 */
class m181009_073420_image_mobile extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('news', 'image_mobile', $this->string()->after('image'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181009_073420_image_mobile cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181009_073420_image_mobile cannot be reverted.\n";

        return false;
    }
    */
}
