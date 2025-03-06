<?php

namespace app\models;

use yii\base\Model;

class LoginForm extends Model
{
    public $phone;
    public $password;
    public $rememberMe = true;

    public function rules(): array
    {
         return [
             [['phone', 'password'], 'required'],
             [['phone'], 'string', 'max' => 20],
             [['password'], 'string', 'min' => 6],
             [['rememberMe'], 'boolean'],
         ];
    }

    public function attributeLabels(): array
    {
         return [
             'phone'      => 'Номер телефона',
             'password'   => 'Пароль',
             'rememberMe' => 'Запомнить меня',
         ];
    }
}
