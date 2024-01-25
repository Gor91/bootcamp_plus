<?php

namespace backend\models;

use yii\base\Model;

class ChangePassword extends Model
{
    /* @var $password */
    public $password;

    /* @var $confirmPassword */
    public $confirmPassword;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['password', 'confirmPassword'], 'required'],
            [['password'], 'string', 'min' => 8],
            [['confirmPassword'], 'compare', 'compareAttribute' => 'password']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'password' => \Yii::t('app','Password'),
            'confirmPassword' => \Yii::t('app','Confirm password')
        ];
    }
}