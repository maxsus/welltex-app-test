<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%item_order}}`.
 */
class m241026_185208_create_item_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%item_order}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'item_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'fk-item_order-order_id',
            '{{%item_order}}',
            'order_id',
            '{{%order}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-item_order-item_id',
            '{{%item_order}}',
            'item_id',
            '{{%item}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-item_order-order_id',
            '{{%item_order}}'
        );

        $this->dropForeignKey(
            'fk-item_order-item_id',
            '{{%item_order}}'
        );

        $this->dropTable('{{%item_order}}');
    }
}
