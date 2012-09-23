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
        $model=new LoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login()) {
                $this->redirect(Yii::app()->user->returnUrl);
            }

            Yii::app()->user->setFlash('error', 'Неправильный логин или пароль');
        }
//		echo $model->errorCode;
        // display the login form
        $this->render('login',array('model'=>$model));
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

                $form->reg_date = time();

                // В validate мы передаем название сценария. Оно нам может понадобиться
                // когда будем заниматься созданием правил валидации [читайте дальше]
                if($form->validate('registration')) {
                    // Если валидация прошла успешно...
                    // Тогда проверяем свободен ли указанный логин..

                    if (empty($form->email)) {
                        $form->addError('email', ' Email не указан');
                        $this->render("registration", array('model' => $form));

                    } elseif ($form->model()->count("email = :email", array(':email' => $form->email))) {
                        // Указанный Email уже занят. Создаем ошибку и передаем в форму
                        $form->addError('email', ' Email уже занят');
                        $this->render("registration", array('model' => $form));

                    } elseif ($form->model()->count("nick = :nick", array(':nick' => $form->nick))) {
                        // Указанный Ник уже занят. Создаем ошибку и передаем в форму
                        $form->addError('nick', 'Ник уже занят');
                        $this->render("registration", array('model' => $form));

                    } elseif (empty($form->nick)) {
                        $form->addError('nick', ' Ник не указан');
                        $this->render("registration", array('model' => $form));

                    } elseif ($form->password != $_POST['User']['password2']) {
                        // Указанный Ник уже занят. Создаем ошибку и передаем в форму
                        $form->addError('password2', 'Пароли не совпадают');
                        $this->render("registration", array('model' => $form));

                    }else {
                        $form->password = md5($form->password);
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