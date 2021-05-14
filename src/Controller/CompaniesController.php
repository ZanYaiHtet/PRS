<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

/**
 * Companies Controller
 *
 * @property \App\Model\Table\CompaniesTable $Companies
 *
 * @method \App\Model\Entity\Company[] paginate($object = null, array $settings = [])
 */
class CompaniesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $companies = $this->paginate($this->Companies->find('all', array('conditions' => array('Companies.del_flg' => 'not'))));


        $this->set(compact('companies'));
        $this->set('_serialize', ['companies']);
    }

    /**
     * View method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $company = $this->Companies->get($id, [
            'contain' => ['Products']
        ]);

        $this->set('company', $company);
        $this->set('_serialize', ['company']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        //SELECT * FROM Companies WHERE category_type LIKE '%4%';
        $currDateTime = date("Y-m-d H:i:s");
        $company = $this->Companies->newEntity();
        $cat_type = "";
        if ($this->request->is('post')) {
            $company = $this->Companies->patchEntity($company, $this->request->getData());

            if (isset($_POST["type"])) {
                // Retrieving each selected option
                foreach ($_POST['type'] as $type)
                    $cat_type .= $type . "/";
            }

            $company->created = $currDateTime;
            $company->modified = $currDateTime;
            $company->del_flg = "not";
            $company->category_type = $cat_type;

            if ($this->Companies->save($company)) {
                $this->Flash->success(__('The company has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The company could not be saved. Please, try again.'));
        }


        $this->set(compact('company'));
        $this->set('_serialize', ['company']);
        $categories = TableRegistry::get('categories');

        $query = $categories->find('all')->where(["del_flg" => "not"])->order(['name' => 'ASC']);
        $this->set('categories_list', $query);
    }

    /**
     * Edit method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $currDateTime = date("Y-m-d H:i:s");
        $cat_type = "";
        $company = $this->Companies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $company = $this->Companies->patchEntity($company, $this->request->getData());

            if (isset($_POST["type"])) {
                // Retrieving each selected option
                foreach ($_POST['type'] as $type)
                    $cat_type .= $type . "/";
            }
            $company->modified = $currDateTime;
            $company->del_flg = "not";
            $company->category_type = $cat_type;
            debug(json_encode($company));
            if ($this->Companies->save($company)) {
                $this->Flash->success(__('The company information has been updated.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The company could not be updated. Please, try again.'));
        }
        $this->set(compact('company'));
        $this->set('_serialize', ['company']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $company = $this->Companies->get($id);
        $company->del_flg = 'deleted';
        if ($this->Companies->save($company)) {
            $this->Flash->success(__('The company has been successfully deleted.'));
        } else {
            $this->Flash->error(__('The company could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        if ($this->Auth->user())
            $this->Auth->allow(['delete', 'add', 'index', 'view','edit']);
    }
}
