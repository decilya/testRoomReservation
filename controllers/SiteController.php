<?php

namespace app\controllers;

use app\models\BookedRooms;
use app\models\Rooms;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->layout = '@app/views/layouts/main';

        return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionBooksRoom()
    {
        /** @var Rooms $rooms */
        $rooms = Rooms::find()->with('bookedRooms')->all();

//        echo "<pre>";
//        print_r($rooms);
//        echo "</pre>";

        return $this->render('books_room', [
            'rooms' => $rooms,
        ]);
    }

    public function actionBookNow()
    {
        // Если это не аякс или post, то просто дальше не будем обрабатывать скрипт
        if ((!Yii::$app->request->isAjax) || (!Yii::$app->request->isPost)) {
            return false;
        }

        /** @var BookedRooms $bookedRooms */
        $bookedRooms = new BookedRooms();
        $bookedRooms->room_id = Yii::$app->request->post('roomId');
        $bookedRooms->phone = Yii::$app->request->post('phone');
        $bookedRooms->user_name = Yii::$app->request->post('userName');
        $bookedRooms->day = Yii::$app->request->post('day');
        $bookedRooms->day_calc = Yii::$app->request->post('dayCalc');
        if ($bookedRooms->day_calc > 0 ) {
            $bookedRooms->day_finish = date('Y-m-d', strtotime("+" . $bookedRooms->day_calc - 1 . "days"));
        }
        $bookedRooms->user_id = isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : null;

        $oldBookedRooms = BookedRooms::find()
            ->where(['day' => $bookedRooms->day])
            ->andWhere(['day_finish' => $bookedRooms->day_finish])
            ->one();

        if (empty($oldBookedRooms)) {
            if ($bookedRooms->save()) {
                return json_encode(true);
            } else {
                return json_encode($bookedRooms->errors);
            }
        } else {
            return json_encode(false);
        }
    }
}