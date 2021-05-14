<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Luckydraw Controller
 *
 * @property \App\Model\Table\LuckydrawTable $Luckydraw
 *
 * @method \App\Model\Entity\Luckydraw[] paginate($object = null, array $settings = [])
 */
class LuckydrawController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $luckydraw = $this->paginate($this->Luckydraw->find('all')->where(['del_flg' => 'not']));
        $this->set(compact('luckydraw'));
        $this->set('_serialize', ['luckydraw']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $luckydraw = $this->Luckydraw->newEntity();
        if ($this->request->is('post')) {
            $custom_scores = $this->request->getData('scores');
            $score_count = $this->Luckydraw->find()->where(['scores' => $custom_scores])->count();
            if ($score_count >= 1) {
                $this->Flash->success(__('This score number is already existed.Try another one!'));
            } else {
                $luckydraw = $this->Luckydraw->patchEntity($luckydraw, $this->request->getData());
                if ($this->Luckydraw->save($luckydraw)) {
                    $this->Flash->success(__('The luckydraw has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The luckydraw could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('luckydraw'));
        $this->set('_serialize', ['luckydraw']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Luckydraw id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $luckydraw = $this->Luckydraw->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $custom_scores = $this->request->getData('scores');
            $score_count = $this->Luckydraw->find()->where(['scores' => $custom_scores])->count();
            if ($score_count > 1) {
                $this->Flash->success(__('This score number is already existed.Try another one!'));
            } else {
                $luckydraw = $this->Luckydraw->patchEntity($luckydraw, $this->request->getData());
                if ($this->Luckydraw->save($luckydraw)) {
                    $this->Flash->success(__('The luckydraw has been updated.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The luckydraw could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('luckydraw'));
        $this->set('_serialize', ['luckydraw']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Luckydraw id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->request->allowMethod(['post', 'delete']);
        $luckydraw_tbl = $this->loadModel('Luckydraw');
        $luckydraw_result = $this->Luckydraw->find()->where(['id' => $id])->first();
        $luckydraw_result->del_flg = 'deleted';

        if ($luckydraw_tbl->save($luckydraw_result)) {
            $this->Flash->success(__('The luckydraw has been deleted.'));
        } else {
            $this->Flash->error(__('The luckydraw could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    /**
     * luckyDraw Spin method
     *
     */
    public function spin()
    {
        //load Luckydraw Table
        $tbl_luckydraw = $this->loadModel('luckydraw');
        $luckydraw_result = $this->luckydraw->find('all')->where(['del_flg' => 'not']);
        $luckydraw_count = $this->luckydraw->find()->where(['del_flg' => 'not'])->count();
        $this->set(compact('luckydraw_result', 'luckydraw_count'));
    }

    /**
     * Add User's Scores method
     *
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function getscores()
    {
        if ($this->request->is('post')) {
            $get_scores = $_POST['custom_scores'];
            $user_tbl = $this->loadModel('Scores');
            $user_result = $this->Scores->find()->where(['id' => 1])->first();
            $user_scores = $user_result->score;
            $user_result->score = $user_scores + $get_scores;
            $user_tbl->save($user_result);
            echo $get_scores;
        }
        return $this->redirect([
            'controller' => 'Scores',
            'action' => 'index'
        ]);
    }
}
