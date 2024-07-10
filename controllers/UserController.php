<?php

namespace app\controllers;

use app\models\ChangePasswordForm;
use app\models\ProfileForm;
use app\models\Role;
use app\models\User;
use app\models\UserRegisterForm;
use app\models\UserUpdateForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'profile',
                            'changepassword',
                        ],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->getRole()->getAttribute('name') === 'Administrator';
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionProfile()
    {
        $user = Yii::$app->user->identity;
        if (!$user) {
            throw new NotFoundHttpException('User not found.');
        }

        $model = new ProfileForm();
        $model->loadData($user);

        if ($model->load(Yii::$app->request->post()) && $model->save($user)) {
            Yii::$app->session->setFlash('success', 'Profile updated successfully.');
            return $this->redirect(['profile']);
        }
        $model->email = $user->getAttribute('email');
        $model->name = $user->getAttribute('name');
        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpdate($id)
    {
        $user = User::findOne($id);
        if ($user === null) {
            throw new NotFoundHttpException("User not found.");
        }

        $model = new UserUpdateForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->setAttribute('name', $model->name);
            $user->setAttribute('email', $model->email);
            $user->setAttribute('status', $model->status);
            $user->setAttribute('role_id', $model->role_id);

            if (!empty($model->password)) {
                $user->setAttribute('password', Yii::$app->security->generatePasswordHash($model->password));
            }

            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'User updated successfully.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to update user.');
            }
        }
        $model->name = $user->getAttribute('name');
        $model->email = $user->getAttribute('email');
        $model->status = $user->getAttribute('status');
        $model->role_id = $user->getAttribute('role_id');
        $roles = Role::find()
            ->select(['name', 'id'])
            ->indexBy('id')
            ->column();
        return $this->render('update', [
            'model' => $model,
            'roles' => $roles,
        ]);
    }

    public function actionRegister()
    {

        $model = new UserRegisterForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            $user->setAttribute('name', $model->name);
            $user->setAttribute('email', $model->email);
            $user->setAttribute('status', $model->status);
            $user->setAttribute('role_id', $model->role_id);
            $user->setAttribute('password', $model->password);
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'User registered successfully.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to register user.');
            }
        }

        $roles = Role::find()
            ->select(['name', 'id'])
            ->indexBy('id')
            ->column();
        return $this->render('register', [
            'model' => $model,
            'roles' => $roles,
        ]);
    }

    public function actionDelete($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            Yii::$app->session->setFlash('error', 'User details not found.');
            return $this->redirect(['index']);
        }
        if ($user->delete()) {
            Yii::$app->session->setFlash('success', 'User has been deleted successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to delete user.');
        }
        return $this->redirect(['index']);
    }

    public function actionChangepassword()
    {
        $model = new ChangePasswordForm();
        $model->load(Yii::$app->request->post());
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = Yii::$app->user->identity;
            if ($user->validatePassword($model->currentPassword)) {
                $user->password = Yii::$app->security->generatePasswordHash($model->newPassword);
                $user->save();
                Yii::$app->session->setFlash('success', 'Password changed successfully.');
                return $this->goBack('/');
            }
        }
        return $this->render('change_password', [
            'model' => $model,
        ]);
    }

    public function actionAjaxusers()
    {
        $request = Yii::$app->request;

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'];
        $order = $request->get('order');
        $orderColumnIndex = $order[0]['column'];
        $orderColumn = $request->get('columns')[$orderColumnIndex]['data'];
        $orderDirection = $order[0]['dir'];

        $query = User::find();

        if (!empty($searchValue)) {
            $query->andFilterWhere(['or',
                ['like', 'name', $searchValue],
                ['like', 'email', $searchValue],
                ['like', '(CASE WHEN status =1 THEN \'Active\' ELSE \'Disabled\' END )',
                    $searchValue],
                ['like', 'created_at', $searchValue]
            ]);
        }

        $totalRecords = $query->count();

        $query->orderBy([$orderColumn => ($orderDirection === 'asc' ? SORT_ASC : SORT_DESC)]);
        $query->offset($start);
        $query->limit($length);

        $users = $query->asArray()->all();
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'name' => $user['name'],
                'email' => $user['email'],
                'status' => $user['status'] == 1
                    ? '<span class="badge badge-success">Active</span>'
                    : '<span class="badge badge-danger">Disabled</span>',
                'created_at' => Yii::$app->formatter->asDatetime($user['created_at']),
                'last_login_at' => (!empty($user['last_login_at'])
                    ? Yii::$app->formatter->asDatetime($user['last_login_at'])
                    : 'Not Yet'
                ),
                'id' => $user['id'],
            ];
        }

        return $this->asJson([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ]);
    }

}