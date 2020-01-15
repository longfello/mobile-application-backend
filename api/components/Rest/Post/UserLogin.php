<?php
/**
 * Copyright (c) kvk-group 2017.
 */

/**
 * Created by PhpStorm.
 * User: miloslawsky
 * Date: 17.10.17
 * Time: 16:55
 */

namespace api\components\Rest\Post;

use api\components\avatar\UploadAvatar;
use api\components\ErrorCode;
use api\components\Rest\RestComponent;
use api\components\Rest\RestMethod;
use common\models\User;
use common\models\UserProfile;
use Yii;

/**
 * Class UserLogin
 *
 * ##Пользователь:
 *
 * ### Авторизация по имени пользователя и паролю
 *
 * Тип запроса | URI | Комментарий
 * --- | --- | ---
 * POST | {%api_url}user/login | Авторизация по имени пользователя и паролю
 *
 * Параметры запроса
 *
 * Ключ | Значение | Обязательный | Комметарий
 * --- | --- | --- | ---
 * email | Адрес электронной почты | + |
 * password | Пароль | + |
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
 *
 * ###Авторизация/регистрация через соцсеть
 *
 * Тип запроса | URI | Комментарий
 * --- | --- | ---
 * POST | {%api_url}user/login | Авторизация/регистрация через соцсеть
 *
 * Параметры запроса
 *
 * Ключ | Значение | Обязательный | Комметарий
 * --- | --- | --- | ---
 * network | сеть | + | Если пользователь не был зарегистрирован — будет создан новый пользователь
 * token | ключь | + |
 * first_name | Имя | - |
 * last_name | Фамилия | - |
 * photo | URL фото | - |
 * birthday | Дата рождения | - |  YYYY-MM-DD
 * email| Адрес электронной почты | - |
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
 * email| Адрес электронной почты
 *
 * В случае ошибки авторизации будет возвращен код ошибки аутентификации
 *
 * @package api\components\Rest\Post
 */
class UserLogin extends RestMethod
{
    /** @inheritdoc */
    public $sort_order = 100;

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

    /** @inheritdoc */
    public $accessEnabledBy = [RestComponent::AUTH_BASIC];

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            [['email'], 'email'],
            [['password', 'network', 'token', 'first_name', 'last_name', 'photo', 'birthday'], 'string']
        ];
    }

    /** @inheritdoc */
    public function save()
    {
        if ($this->password) {
            $model = User::findOne(['email' => $this->email, 'status' => User::STATUS_ACTIVE]);
            if ($model && $model->validatePassword($this->password)) {
                return [
                    'user_id' => $model->id,
                    'first_name' => $model->userProfile->firstname,
                    'last_name' => $model->userProfile->lastname,
                    'photo' => $model->userProfile->avatar,
                    'birthday' => $model->userProfile->birthday
                ];
            }
        } elseif ($this->network) {
            $model = User::findOne([
                'oauth_client' => $this->network,
                'oauth_client_user_id' => $this->token
            ]);
            if ($model) {
                return [
                    'user_id' => $model->id,
                    'first_name' => $model->userProfile->firstname,
                    'last_name' => $model->userProfile->lastname,
                    'photo' => $model->userProfile->avatar,
                    'birthday' => $model->userProfile->birthday,
                    'email' => $model->email
                ];
            } else {
                // регистрация по соцсети
                $upload = new UploadAvatar();
                $photo = $upload->avatar($this->photo);
                $model = new User();
                $model->oauth_client = $this->network;
                $model->oauth_client_user_id = $this->token;
                $model->status = $model::STATUS_ACTIVE;
                $model->email = $this->email;
                if ($model->save()) {
                    $modelUserProfile = new UserProfile();
                    $modelUserProfile->firstname = $this->first_name;
                    $modelUserProfile->user_id = $model->id;
                    $modelUserProfile->lastname = isset($this->last_name) ? $this->last_name : null;
                    $modelUserProfile->avatar_base_url = Yii::$app->fileStorage->baseUrl;
                    $modelUserProfile->avatar_path = $photo;
                    $modelUserProfile->birthday = isset($this->birthday) ? $this->birthday : null;
                    $modelUserProfile->detachBehavior('picture');
                    if ($modelUserProfile->save()) {
                        $model = User::findOne(['id' => $model->id]);
                        if ($model) {
                            return [
                                'user_id'    => $model->id,
                                'first_name' => $model->userProfile->firstname,
                                'last_name'  => $model->userProfile->lastname,
                                'photo'      => $model->userProfile->avatar,
                                'birthday'   => $model->userProfile->birthday,
                                'email'      => $model->email
                            ];
                        }
                    }
                } else {
                    \Yii::$app->response->throwError(ErrorCode::SAVE_DATA);
                }
            }
        }
        \Yii::$app->response->throwError(ErrorCode::AUTH_DENIED, "Auth denied");
    }
}