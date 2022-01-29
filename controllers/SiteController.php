<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use app\service\CourseService;


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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this -> layout = 'main_without_video_js.php';

        $this->view->params["menu"] = 1;
        $this->view->title = "Nastya's Bagdasarova Online Platform";
        return $this->render('index');
    }
    public function actionExotic(){
        $this->view->params["menu"] = 2;

        $courseList = CourseService::findAllByIdOfTypeOfContent(2);
        $themeOfContent = "Exotic choreography";
        

        $this->view->title = "Exotic | Nastya's Bagdasarova Online Platform";
        return $this->render('courses', compact("courseList","themeOfContent"));
    }
    public function actionAcrobatics(){
        $this->view->params["menu"] = 3;

        $courseList = CourseService::findAllByIdOfTypeOfContent(3);
        $themeOfContent = "Acrobatics";

        $this->view->title = "Acrobatics | Nastya's Bagdasarova Online Platform";
        return $this->render('courses', compact("courseList","themeOfContent"));
    }
    public function actionStrip(){
        $this->view->params["menu"] = 4;

        $courseList = CourseService::findAllByIdOfTypeOfContent(1);
        $themeOfContent = "Strip choreography";

        $this->view->title = "Strip | Nastya's Bagdasarova Online Platform";
        return $this->render('courses', compact("courseList","themeOfContent"));
    }
    public function actionContacts()
    {
        $this -> layout = 'main_without_video_js.php';

        $this->view->params["menu"] = 5;
        $this->view->title = "Contacts | Nastya's Bagdasarova Online Platform";
        return $this->render('contacts');
    }
    public function actionPrivacy()
    {
        $this -> layout = 'main_without_video_js.php';
        
        $this->view->params["menu"] = 6;
        $this->view->title = "Privacy | Nastya's Bagdasarova Online Platform";
        return $this->render('privacy');
    }
    public function actionTerms()
    {
        $this -> layout = 'main_without_video_js.php';
        
        $this->view->params["menu"] = 7;
        $this->view->title = "Terms | Nastya's Bagdasarova Online Platform";
        return $this->render('terms');
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

        /*
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
        */
        $this->view->title = "Login | Nastya's Bagdasarova Online Platform";
        return $this -> render("login");
    }
    public function actionForget()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->view->title = "Forget | Nastya's Bagdasarova Online Platform";
        return $this -> render("forget");
    }


    public function actionRegistration(){
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->view->title = "Registration | Nastya's Bagdasarova Online Platform";
        return $this -> render("registration");
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
        $this->view->params["menu"] = 5;
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
}
