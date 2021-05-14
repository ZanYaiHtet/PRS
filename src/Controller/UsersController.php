<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Security;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    /**
     * Mu lar Sann
     * User Controller for User CRUD action
     * index is for user List
     * view is for user profile
     * add is for user registration
     * edit is for user update
     * delete is for user delete action
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Admins', 'Scores']
        ];
        $data = $this->Users->find('all', array('conditions' => array('Users.del_flg' => 'not')));
        $users = $this->paginate($data);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }
    public function search()
    {

        $this->request->allowMethod('ajax');

        $keyword = $this->request->getQuery('keyword');

        $query = $this->Users->find('all', [
            'conditions' => ([
                'Or' => [
                    ['Users.name LIKE' => '%' . $keyword . '%'],
                    ['Users.email like' => '%' . $keyword . '%'], ['Users.gender like' => '%' . $keyword . '%'],
                    ['Users.phone like' => '%' . $keyword . '%'], ['Users.premium_flg like' => '%' . $keyword . '%'],
                    ['Users.birthdate like' => '%' . $keyword . '%']
                ],
                'AND' => ['Users.del_flg' => 'not']
            ]),
            'order' => ['id' => 'DESC'],
            'limit' => 10
        ]);
        $users = $this->paginate($query);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }


    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $newUser = $this->Users->newEntity();
        if ($this->request->is('post') || $this->request->is('put')) {

            $user = $this->Users->patchEntity($newUser, $this->request->getData());
            //img upload
            $userImage = $this->request->getData('profile_img');
            $name = $userImage['name'];

            $type = pathinfo($name, PATHINFO_EXTENSION);
            $targetPath = WWW_ROOT . 'img' . DS . 'profile_img' . DS . $name;
            $token = Security::hash(Security::randomBytes(32));
            $premium_flg = "normal";
            $reward = "no reward";
            $del_flg = "not";
            $last_login = date('Y-m-d');
            $admin_id = null;
            $score = 0;
            $password = $this->request->getData('password');
            //age calculation
            $birthdate = $this->request->getData('birthdate');
            $dob_year = date('Y', strtotime($birthdate));
            $today =  date('Y-m-d');
            $today_year = date('Y', strtotime($today));
            $age = $today_year - $dob_year;

            $user->premium_flg = $premium_flg;
            $user->reward = $reward;
            $user->del_flg = $del_flg;
            $user->last_login = $last_login;
            $user->admin_id = $admin_id;
            $user->score = $score;
            $user->token = $token;
            $user->age = $age;
            $user->password = $password;

            //image upload while file type is jpeg jpg and png
            if ($type == 'jpeg' || $type == 'jpg' || $type == 'png' || $type == 'PNG' || $type == 'JPG' || $type == 'JPEG') {
                if (move_uploaded_file($userImage['tmp_name'], $targetPath)) {
                    if (!empty($name)) {
                        $user->profile_img = $name;
                    }
                }
            } /* else {
                $this->Flash->error(__('The file type could not be saved. Please, choose image file.'));
            } */
            //when user age is less than 15 and greater than 100 we are not allow the user registeration
            if ($age >= 15 and $age <= 100) {
                $phone_no = $this->request->getData('phone');
                //phone no is no longer than 15
                if (strlen($phone_no) < 15) {
                    $user->phone = $phone_no;
                    if ($this->Users->save($user)) {
                        $this->Flash->success(__('Successfully registered, login now.'));
                        /* echo '<div class="success-alert">
                        <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span><center><strong>You\'re successfully register, login now.</strong> </center></div>'; */
                        return $this->redirect('login');
                    } else {
                        $this->Flash->error(__('The user could not be saved. Please, try again.'));
                    }
                } else {
                    $this->Flash->error(__('Your phone number is too long not longer than 15 digit'));
                }
            } elseif ($age < 15 or $age > 100) {
                $this->Flash->error(__('The user is not allowed to use the System.Only User age between age 15 and 100 allow.'));
            }
        }

        $this->set(compact('newUser', $newUser));
        $this->set('_serialize', ['newUser']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [], 'formatted_date' => 'DATE_FORMAT(birthdate,"Y-m-d")'
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            //img upload
            $img_name = $this->request->getData('img_name');
            $userImage = $this->request->getData('profile_img');
            $new_img = '';
            $image = '';
            if ($userImage['name']) {
                $new_img = $userImage['name'];
            }

            if ($new_img != '') {
                $image = $new_img;
            } else {
                $image = $img_name;
            }
            $name = $image;
            $type = pathinfo($name, PATHINFO_EXTENSION);

            //age calculation
            $birthdate = $this->request->getData('birthdate');
            $dob_year = date('Y', strtotime($birthdate));
            $today =  date('Y-m-d');
            $today_year = date('Y', strtotime($today));
            $age = $today_year - $dob_year;
            //$age = date_create($birthdate)->diff(date_create($today));

            $user->age = $age;

            $targetPath = WWW_ROOT . 'img' . DS . 'profile_img' . DS . $name;
            $password = $this->request->getData('password');
            if (strlen($password) < 25) {
                $user->password = $password;
            }
            if ($new_img != null) {
                if ($type == 'jpeg' || $type == 'jpg' || $type == 'png' || $type == 'PNG' || $type == 'JPG' || $type == 'JPEG') {
                    if (move_uploaded_file($userImage['tmp_name'], $targetPath)) {
                        if (!empty($name)) {
                            $user->profile_img = $name;
                        }
                    }
                } else {
                    $this->Flash->error(__('The file type could not be saved. Please, choose image file.'));
                }
            } else {
                $user->profile_img = $name;
            }

            if ($age >= 15 and $age <= 100) {
                $phone_no = $this->request->getData('phone');

                $userType = $this->request->getData('userType');
                if ($userType) {
                    $user->premium_flg = $userType;
                }
                if (strlen($phone_no) < 15) {
                    $user->phone = $phone_no;

                    $admin_id = $this->request->getData('admin_id');
                    $user->admin_id = $admin_id ? $admin_id : null;

                    if ($this->Users->save($user)) {
                        $this->Flash->success(__('Successfully Updated.'));

                        if ($this->Auth->user('name'))
                            return $this->redirect('data_analysis');
                        else
                            return $this->redirect('users');
                    }
                } else {
                    $this->Flash->error(__('Invalid phone number'));
                }
            } elseif ($age < 15 or $age > 100) {
                $this->Flash->error(__('The user is not allowed to use the System. Please, try again.'));
            }
            $this->Flash->error(__('Could not be Updated. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        $user->del_flg = "deleted";
        $user->admin_id = $this->Auth->user('id');
        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                // return debug($this->Auth->getUser());
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__('Username or password is incorrect'));
            }
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    public function forgotPassword()
    {
        if ($this->request->is('post')) {
            $email = $this->request->getData('email');
            $token = Security::hash(Security::randomBytes(25));

            $userTable = TableRegistry::get('Users');
            if ($email == NULL) {
                $this->Flash->error(__('Please insert your email address'));
            }
            if ($user = $userTable->find('all')->where(['email' => $email])->first()) {
                $user->token = $token;

                if ($userTable->save($user)) {
                    // $mail = new Email('mailForget');
                    $mail = new Email('mailGmail');
                    $mail->setTo($email)
                        ->setSubject('Reset your password.')
                        ->setEmailFormat('html')
                        ->send('Hi ' . $user->name . ',<br/>You can reset your password by clicking link below<br/><a href="http://localhost:8765/resetPassword/' . $token . '">Reset Password</a>.');
                }
                $this->Flash->success('Reset password link has been sent to your email (' . $email . '), please check your email');
            }
            if ($userTable->find('all')->where(['email' => $email])->count() == 0) {
                $this->Flash->error(__('Email is not registered in system'));
            }
        }
    }

    public function resetPassword($token)
    {
        if ($this->request->is('post')) {
            $newPass = $this->request->getData('password');

            $userTable = TableRegistry::get('Users');
            $user = $userTable->find('all')->where(['token' => $token])->first();
            $user->password = $newPass;
            if ($userTable->save($user)) {
                $this->Flash->success('Password successfully reset. Please login using your new password.');
                return $this->redirect(['action' => 'login']);
            }
        }
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        if ($this->Auth->user())
            $this->Auth->allow(['delete', 'add', 'index', 'edit', 'view', 'search']);
    }
}
