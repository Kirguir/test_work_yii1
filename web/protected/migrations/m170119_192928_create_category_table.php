<?php

class m170119_192928_create_category_table extends CDbMigration
{
	 /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('category', [
            'id' => 'pk',
            'parent_id' => 'integer',
            'link' => 'varchar(255) NOT NULL',
            'title' => 'varchar(64) NOT NULL',
        ]);

		$this->addForeignKey('FK_parent', 'category', 'parent_id', 'category', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('category');
    }

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}