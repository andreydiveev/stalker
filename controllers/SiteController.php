<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
    public function actionLogin()
    {
        $model = new User();

        // Проверяем является ли пользователь гостем
        // ведь если он уже зарегистрирован - формы он не должен увидеть.
        if (!Yii::app()->user->isGuest) {
            throw new CException('Вы уже зарегистрированы!');
        } else {
            if (!empty($_POST['User'])) {
                $model->attributes = $_POST['User'];

                // Проверяем правильность данных
                if($model->validate('login')) {
                    // если всё ок - кидаем на главную страницу
                    $this->redirect(Yii::app()->homeUrl);
                }else{
                    Yii::app()->user->setFlash('error','Неправильный логин или пароль');
                    $this->refresh();
                }
            }
            $this->render('login', array('model' => $model));
        }
    }

    /**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}


    public function actionRegistration()
    {
        // тут думаю все понятно
        $form = new User();

        // Проверяем являеться ли пользователь гостем
        // ведь если он уже зарегистрирован - формы он не должен увидеть.
        if (!Yii::app()->user->isGuest) {
            throw new CException('Вы уже зарегистрированны!');
        } else {
            // Если $_POST['User'] не пустой массив - значит была отправлена форма
            // следовательно нам надо заполнить $form этими данными
            // и провести валидацию. Если валидация пройдет успешно - пользователь
            // будет зарегистрирован, не успешно - покажем ошибку на экран
            if (!empty($_POST['User'])) {

                // Заполняем $form данными которые пришли с формы
                $form->attributes = $_POST['User'];

                // В validate мы передаем название сценария. Оно нам может понадобиться
                // когда будем заниматься созданием правил валидации [читайте дальше]
                if($form->validate('registration')) {
                    // Если валидация прошла успешно...
                    // Тогда проверяем свободен ли указанный логин..

                    if ($form->model()->count("email = :email", array(':email' => $form->email))) {
                        // Указанный логин уже занят. Создаем ошибку и передаем в форму
                        $form->addError('email', 'Логин уже занят');
                        $this->render("registration", array('model' => $form));
                    } else {
                        // Выводим страницу что "все окей"
                        $form->save();
                        $this->render("registration_ok");
                    }

                } else {
                    // Если введенные данные противоречат
                    // правилам валидации (указаны в rules) тогда
                    // выводим форму и ошибки.
                    // [Внимание!] Нам ненадо передавать ошибку в отображение,
                    // Она автоматически после валидации цепляеться за
                    // $form и будет [автоматически] показана на странице с
                    // формой! Так что мы тут делаем простой рэндер.

                    $this->render("registration", array('model' => $form));
                }
            } else {
                // Если $_POST['User'] пустой массив - значит форму некто не отправлял.
                // Это значит что пользователь просто вошел на страницу регистрации
                // и ему мы должны просто показать форму.

                $this->render("registration", array('model' => $form));
            }
        }
    }
}