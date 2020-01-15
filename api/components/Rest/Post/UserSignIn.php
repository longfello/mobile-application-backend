<?php
/**
 * Copyright (c) kvk-group 2018.
 */

/**
 * Created by PhpStorm.
 * User: miloslawsky
 * Date: 17.10.17
 * Time: 16:55
 */

namespace api\components\Rest\Post;
use common\commands\AddToTimelineCommand;
use api\components\ErrorCode;
use api\components\Rest\RestComponent;
use api\components\Rest\RestMethod;
use common\models\User;
use common\models\UserProfile;
use api\components\avatar\UploadAvatar;
use Yii;

/**
 * Class UserSignIn
 *
 * ###Регистрация пользователя по email
 *
 * Тип запроса | URI | Комментарий
 * --- | --- | ---
 * POST | {%api_url}user/sign-in |
 *
 * Параметры запроса
 *
 * Ключ | Значение | Обязательный | Комметарий
 * --- | --- | --- | ---
 * email | Имя пользователя | + |Если пользователь не был зарегистрирован — будет создан новый пользователь
 * password | Пароль | + |
 * first_name | имя | + |
 * photo | фото | - | или URL или base64encoded картинка
 * last_name | Фамилия | - |
 * birthday | Дата рождения| - | YYYY-MM-DD
 *
 * Ответ — массив элементов со следующими атрибутами (в случае удачи)
 *
 * Ключ | Значение
 * --- | ---
 * user_id | Идентификатор пользователя
 * first_name |    Имя
 * last_name | Фамилия
 * photo | URL фото
 * birthday | Дата рождения
 *
 * В случае ошибки авторизации будет возвращен код ошибки аутентификации
 *
 * @package api\components\Rest\Post
 */
class UserSignIn extends RestMethod
{

    /** @inheritdoc */
    public $sort_order = 200;

    /** @var string $email почтовый адрес пользователя */
    public $email;
    /** @var string Пароль */
    public $password;
    /** @var string Соцсеть */
    public $network;
    /** @var string Токен соцсети */
    public $token;
    /** @var string Имя */
    public $first_name;
    /** @var string Фамилия */
    public $last_name;
    /** @var string Photo */
    public $photo;
    /** @var string День рождения */
    public $birthday;

    /**
     * @var string
     */
    public $picture;

    /**
     * @var
     */
    protected $path;


    /** @inheritdoc */
    public $accessEnabledBy = [RestComponent::AUTH_BASIC];

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass'=> '\common\models\User',
                'message' => Yii::t('frontend', 'This email address has already been taken.')
            ],
            [['password', 'network', 'token', 'first_name', 'last_name', 'photo', 'birthday', 'picture'], 'string']
        ];
    }

    /** @inheritdoc */
    public function save()
    {
        if ($this->data) {
            $model = User::findOne(['email' => $this->email]);
            if (is_null($model)) {
                $upload = new UploadAvatar();
                $photo = $upload->avatar($this->photo);
//                $login = strstr($this->data['email'], '@', true);
                $modelUser = new User();
                $modelUser->email = $this->data['email'];
                $modelUser->setPassword($this->data['password']);
                $modelUser->username = $this->data['email'];
                $modelUser->status = $modelUser::STATUS_ACTIVE;
                if ($modelUser->save()) {
                    $modelUserProfile = new UserProfile();
                    $modelUserProfile->firstname = $this->first_name;
                    $modelUserProfile->user_id = $modelUser->id;
                    $modelUserProfile->lastname = isset($this->last_name) ? $this->last_name : null;
                    $modelUserProfile->birthday = isset($this->birthday) ? $this->birthday : null;
                    $modelUserProfile->avatar_base_url = Yii::$app->fileStorage->baseUrl;
                    $modelUserProfile->avatar_path = $photo;
                    $modelUserProfile->detachBehavior('picture');
                    if ($modelUserProfile->validate()) {
                        $modelUserProfile->save(true);
                        $model = User::findOne(['id' => $modelUser->id]);
                        if ($model) {

                            Yii::$app->commandBus->handle(new AddToTimelineCommand([
                                'category' => 'user',
                                'event' => 'signup',
                                'data' => [
                                    'public_identity' => $model->getPublicIdentity(),
                                    'user_id' => $model->getId(),
                                    'created_at' => $model->created_at
                                ]
                            ]));

                            return [
                                'user_id' => $model->id,
                                'first_name' => $model->userProfile->firstname,
                                'last_name' => $model->userProfile->lastname,
                                'photo' => $model->userProfile->avatar,
                                'birthday' => $model->userProfile->birthday
                            ];
                        }
                    } else {
                        $modelUserProfile->errors;
                    }



                } else {
                    \Yii::$app->response->throwError(ErrorCode::SAVE_DATA);
                }
            } else {
                $model = User::findOne(['email' => $this->email]);
                if ($model) {
                    return [
                        'user_id' => $model->id,
                        'first_name' => $model->userProfile->firstname,
                        'last_name' => $model->userProfile->lastname,
                        'photo' => $model->userProfile->avatar,
                        'birthday' => $model->userProfile->birthday
                    ];
                }
            }
        }
    }
}

