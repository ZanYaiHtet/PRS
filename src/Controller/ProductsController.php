<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class ProductsController extends AppController
{
    // Product List Index
    public function index()
    {
        // Cakephp Product List Query Style
        $query = $this->Products
            ->find('all')
            ->select(['id' => 'Products.id', 'name' => 'Products.name', 'price' => 'Products.price', 'rating' => 'Answers.rating'])
            ->leftJoin(
                ['Answers' => 'answers'],
                ['Products.id = Answers.product_id'])
            ->where(['del_flg' => 'not'])
            ->group(['id']);

        // Pagination Product List at Limit 20
        $products = $this->paginate($query);

        // Admin User Differentiation
        $role = $this->Auth->user('name');

        // Passing Data for Admin User Role
        if ($role === '' || $role === NULL) {
            $this->set('purl', '0');
        } else {
            $this->set('purl', '1');
        }

        $this->set(compact('products'));

    }

    // Product View Button Link
    public function view($id = null, $purl)
    {
        // Join query with companies and categories tables
        $product = $this->Products->get($id, [
            'contain' => ['Companies', 'Categories'],
        ]);

        // Admin User Rold Differentiation
        $this->set('purl', $purl);

        $this->set('product', $product);
    }

    // New Product Add Link
    public function add()
    {
        $product = $this->Products->newEntity();
        
        // Request Link with POST
        if ($this->request->is('post')) {
            
            // get all insert data from user
            $product = $this->Products->patchEntity($product, $this->request->getData());

            // Default Delete Flag
            $product->del_flg = "not";
            
            // Login Admin Id
            $product->admin_id = $this->Auth->user('id');

            //Image Upload
            $fileimage = $this->request->getData('image');            
            $nameimage = $fileimage['name'];
            $target_image = WWW_ROOT . 'upload' . DS . 'images' . DS . $nameimage;
            if (move_uploaded_file($fileimage['tmp_name'], $target_image)) {
                if (!empty($nameimage)) {
                    $product->image = $nameimage;
                }
            }

            //Video Upload
            $filevideo = $this->request->getdata('video');
            $namevideo = $filevideo['name'];
            $target_video = WWW_ROOT . 'upload' . DS . 'videos' . DS . $namevideo;
            if (move_uploaded_file($filevideo['tmp_name'], $target_video)) {
                if (!empty($namevideo)) {
                    $product->video = $namevideo;
                }
            }
            
            // Saving Process
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            // Failing Process
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        
        //Drop Down List companies and categories
        $categories_list = $this->Products->Categories->find('all')->where(['del_flg' => "not"]);
        $companies_list = $this->Products->Companies->find('all')->where(['del_flg' => "not"]);
        
        $this->set(compact('product', 'categories_list', 'companies_list'));
    }

    // Product Editing Link
    public function edit($id = null)
    {
        // Join query with companies and categories tables
        $product = $this->Products->get($id, [
            'contain' => ['Companies', 'Categories'],
        ]);

        // image select query
        $query = $this->Products->find()
            ->select(['image'])
            ->where(['id' => $id]);
        $dbimage = $query->first();
        
        // video select query
        $query2 = $this->Products->find()
            ->select(['video'])
            ->where(['id' => $id]);
        $dbvideo = $query2->first();

        // Request Link with PATCH POST PUT
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            // Get All Data
            $product = $this->Products->patchEntity($product, $this->request->getData());

            // Default Delete Flag
            $product->del_flg = "not";
            
            // Loing Admin Id
            $product->admin_id = $this->Auth->user('id');

            //Image Upload
            $fileimage = $this->request->getData('image');
            $nameimage = $fileimage['name'];
            $target_image = WWW_ROOT . 'upload' . DS . 'images' . DS . $nameimage;
            if (move_uploaded_file($fileimage['tmp_name'], $target_image)) {
                if (!empty($nameimage)) {
                    $product->image = $nameimage;
                }
            } else {
                // When don't Update Image
                $product->image = $dbimage['image'];
            }

            //Video Upload
            $filevideo = $this->request->getdata('video');
            $namevideo = $filevideo['name'];
            $target_video = WWW_ROOT . 'upload' . DS . 'videos' . DS . $namevideo;
            if (move_uploaded_file($filevideo['tmp_name'], $target_video)) {
                if (!empty($namevideo)) {
                    $product->video = $namevideo;
                }
            } else {
                // When don't Update Video
                $product->video = $dbvideo['video'];
            }

            // Saving Process
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            // Failing Process
            $this->Flash->error(__('The product could not be updated. Please, try again.'));
        }
      
        //Drop Down List companies and categories
        $categories_list = $this->Products->Categories->find('all')->where(['del_flg' => "not"]);
        $companies_list = $this->Products->Companies->find('all')->where(['del_flg' => "not"]);
        
        $this->set(compact('product', 'categories_list', 'companies_list'));
    }

    // Product Deleting Link
    public function delete($id = null)
    {
        // Request Link with POST DELETE
        $this->request->allowMethod(['post', 'delete']);
        
        // Only Get Id
        $product = $this->Products->get($id);

        // Delete Disable Query
        $query = $this->Products->Answers->find('all', array('conditions' => array('Answers.product_id' => $id)))->select(['id']);
        $data = $query->toArray();
        
        // Converting String 
        $products = implode(' ', $data);
        if (!empty($products)) {
            // Failing Process
            $this->Flash->error(__('The product is being used in survey so that could not be deleted.'));
            return $this->redirect(['action' => 'index']);
        } else {
            // Update DB Delete Flag
            $product->del_flg = "deleted";
            
            // Saving Process
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been deleted.'));
                return $this->redirect(['action' => 'index']);
            } else {
                // Failing Process
                $this->Flash->error(__('The product could not be deleted. Please, try again.'));
            }
        }
    }

    // Product Searching Process
    public function search()
    {
        // Ajax allow
        $this->request->allowMethod('ajax');

        // Get string from search bar
        $keyword = $this->request->query('keyword');

        // Product Searching Query
        $query = $this->Products
            ->find('all')
            ->select(['id' => 'Products.id', 'name' => 'Products.name', 'price' => 'Products.price', 'rating' => 'Answers.rating'])
            ->leftJoin(
                ['Answers' => 'answers'],
                ['Products.id = Answers.product_id'])
            ->where([['OR' => [['name LIKE'=>'%'.$keyword.'%'],['price LIKE'=>'%'.$keyword.'%']]],['AND' => ['del_flg' => 'not']]])
            ->group(['id'])
            ->order(['name' => 'ASC']);

        // Pagination Product List at Limit 20
        $products = $this->paginate($query);

        $this->set(compact('products'));
    }

    // Product Searching Process For User
    public function searchuser()
    {
        // Ajax allow
        $this->request->allowMethod('ajax');

        // Get string from search bar
        $keyword = $this->request->query('keyword');

        // Product Searching Query
        $query = $this->Products
            ->find('all')
            ->select(['id' => 'Products.id', 'name' => 'Products.name', 'price' => 'Products.price', 'rating' => 'Answers.rating'])
            ->leftJoin(
                ['Answers' => 'answers'],
                ['Products.id = Answers.product_id'])
            ->where([['OR' => [['name LIKE'=>'%'.$keyword.'%'],['price LIKE'=>'%'.$keyword.'%']]],['AND' => ['del_flg' => 'not']]])
            ->group(['id'])
            ->order(['name' => 'ASC']);

        // Pagination Product List at Limit 20
        $products = $this->paginate($query);

        $this->set(compact('products'));
    }

    // Authorize Admin 
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        if ($this->Auth->user())
            $this->Auth->allow(['index', 'view', 'add', 'edit', 'delete', 'search']);
    }
}
