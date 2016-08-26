<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/26
 * Time: 下午4:47
 */
namespace Member\Model;
use Think\Model\ViewModel;
class BoroughViewModel extends ViewModel{
    protected $tableName='borough';
    public $viewFields = array(
        'Blog'=>array('id','name','title'),
        'Category'=>array('title'=>'category_name', '_on'=>'Blog.category_id=Category.id'),
        'User'=>array('name'=>'username', '_on'=>'Blog.user_id=User.id'),
    );
}