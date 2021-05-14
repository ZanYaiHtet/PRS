<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;

/**
 * DataAnalysis Controller
 *
 *
 * @method \App\Model\Entity\DataAnalysi[] paginate($object = null, array $settings = [])
 */
class DataAnalysisController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        // 'value' => 'name'

        $currDateTime = date("Y-m-d H:i:s");
        //echo ($currDateTime);

        $categories = TableRegistry::get('categories');

        $query = $categories->find('all');
        $this->set('categories_list', $query);

        $products = TableRegistry::get('products');
        $answers = TableRegistry::get('answers');
        $connection = ConnectionManager::get('default');
        $results1 = $connection->execute('SELECT distinct image as pimage, name as pname, model_no as pmodel_no from `answers`, `products` WHERE products.id=answers.product_id and
         answers.rating>3 and del_flg=\'not\' GroupBy survey_id')->fetchAll('assoc');
        // echo ($results1);

        $this->set('product_list', $results1);
    }
    public function menu()
    {
        $categories = TableRegistry::get('categories');

        $query = $categories->find('all');
        $this->set('categories_list', $query);

        $products = TableRegistry::get('products');
        $answers = TableRegistry::get('answers');
        $connection = ConnectionManager::get('default');
        $results1 = $connection->execute('SELECT distinct image as pimage,name as pname, model_no as pmodel_no, price as pprice from `answers`, `products` WHERE products.id=answers.product_id and
         answers.rating>3 and del_flg=\'not\'')->fetchAll('assoc');
        // echo ($results1);

        $this->set('product_list', $results1);
    }
    public function category()
    {
        $categories = TableRegistry::get('categories');
        $query = $categories->find('all')->where(['del_flg' => "not"]);
        $this->set('categories_list', $query);
    }
    public function product()
    {
        $categories = TableRegistry::get('categories');
        $products = TableRegistry::get('products');

        $query = $categories->find('all');
        $this->set('categories_list', $query);

        $query = $products->find(
            'all',
            array(
                'order' => array('Products.name ASC')
            )
        );
        $this->set('products_list', $query);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        if ($this->Auth->user())
            $this->Auth->allow(['menu', 'category', 'product']);
    }
}
