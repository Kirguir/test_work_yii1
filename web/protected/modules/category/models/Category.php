<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property integer $parent_id
 * @property string $link
 * @property string $title
 */
class Category extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('link, title', 'required'),
			array('parent_id', 'numerical', 'integerOnly'=>true),
			array('link', 'length', 'max'=>255),
			array('title', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, link, title', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Получение дерева в виде массоива для CTreeView
	 */
	public function getTree()
	{
		$criteria = new CDbCriteria();
		$criteria->order = 'parent_id DESC';
		$items = $this->findAll($criteria);
		$countIntems = count($items);
		$list = [];
		for($i = 0; $i < $countIntems; $i++)
		{
			$item = $items[$i];
			$id = $item->getPrimaryKey();
			$idParent = $item->parent_id ? $item->parent_id : 0;
			if( empty($list[$idParent]) )
			{
				$list[$idParent] = [];
			}
			$list[$idParent][] = [
				'id' => $id,
				'text' => CHtml::link($item->title, $item->link),
				'expanded' => false,
			];
		}

		$tree = $this->listToTree($list);

		return $tree;
	}

	public function listTotree(&$list, $parent_id = 0) {
		if( empty($list[$parent_id])){
			return [];
		}
		$tree = [];
		for ($i = 0; $i < count($list[$parent_id]); $i++) {
			$f			   = $list[$parent_id][$i];
			$f['children'] = $this->listTotree($list, $list[$parent_id][$i]['id']);
			$tree[]	       = $f;
		}

		return $tree;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'parent'=>array(self::BELONGS_TO, 'Category', parent_id),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Parent',
			'link' => 'Link',
			'title' => 'Title',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
