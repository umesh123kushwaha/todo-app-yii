<?php

use yii\db\Migration;

/**
 * Class m241026_160637_todo_table
 */
class m241026_160637_todo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //created a category table
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
        // created todo table
        $this->createTable('todo', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'timestamp' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),

        ]);

        $this->createIndex(
            'idx-todo-category_id',
            'todo',
            'category_id'
        );

        $this->addForeignKey(
            'fk_todo_category',
            'todo',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `todo`
        $this->dropForeignKey(
            'fk_todo_category',
            'todo'
        );
        // drops index for column `category_id`
        $this->dropIndex(
            'idx-todo-category_id',
            'todo'
        );

        $this->dropTable('category');
        $this->dropTable('todo');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241026_160637_todo_table cannot be reverted.\n";

        return false;
    }
    */
}
