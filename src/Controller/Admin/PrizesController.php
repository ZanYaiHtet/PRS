<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Prizes Controller
 *
 *
 * @method \App\Model\Entity\Prize[] paginate($object = null, array $settings = [])
 */
class PrizesController extends AppController
{
    public function prizelist()
    {
        $prizes = $this->paginate($this->Prizes->find('all')->where(['del_flg' => 'not']));
        $this->set(compact('prizes'));
        $this->set('_serialize', ['prizes']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function prizeadd()
    {
        $prize = $this->Prizes->newEntity();
        if ($this->request->is('post')) {

            $prizes = $this->request->getData('prize_name');
            
            $pr_count = $this->Prizes->find()->where(['prize_name' => $prizes])->count();
            $currDateTime = date("Y-m-d H:i:s");
            if ($pr_count >= 1) {
                $this->Flash->success(__('The prize name is existed.'));
            } else {
                $prize = $this->Prizes->patchEntity($prize, $this->request->getData());
                $prize->created = $currDateTime;
                $prize->modified = $currDateTime;
                if ($this->Prizes->save($prize)) {
                    $this->Flash->success(__('The prize has been saved.'));
                    return $this->redirect(['action' => 'prizelist']);
                }
                $this->Flash->error(__('The prize could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('prize'));
        $this->set('_serialize', ['prize']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Prize id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $currDateTime = date("Y-m-d H:i:s");
        $prize = $this->Prizes->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $prizes = $this->request->getData('prize_name');
            $pr_count = $this->Prizes->find()->where(['prize_name' => $prizes])->count();
            if ($pr_count > 1) {
                $this->Flash->success(__('The prize name is existed.'));
            } else {
                $prize = $this->Prizes->patchEntity($prize, $this->request->getData());
                $prize->modified = $currDateTime;
                if ($this->Prizes->save($prize)) {
                    $this->Flash->success(__('The prize has been updated'));
                    return $this->redirect(['action' => 'prizelist']);
                }
                $this->Flash->error(__('The prize could not be updated. Please, try again.'));
            }
        }
        $this->set(compact('prize'));
        $this->set('_serialize', ['prize']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Prize id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->request->allowMethod(['post', 'delete']);
        $prize_tbl = $this->loadModel('Prizes');
        $prize_result = $this->Prizes->find()->where(['id' => $id])->first();
        $prize_result->del_flg = 'deleted';
        if ($prize_tbl->save($prize_result)) {
            $this->Flash->success(__('The prize has been deleted.'));
        } else {
            $this->Flash->error(__('The prize could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'prizelist']);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        if ($this->Auth->user())
            $this->Auth->allow(['delete', 'prizeadd', 'edit', 'prizelist']);
    }
}
