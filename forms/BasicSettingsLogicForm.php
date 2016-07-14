<?php

namespace humhub\modules\logicenter\forms;

use humhub\modules\space\models\Space;
use yii\base\Model;
use Yii;
/**
 * @package humhub.modules_core.admin.forms
 * @since 0.5
 */
class BasicSettingsLogicForm extends Model
{

    public $name;
    public $baseUrl;
    public $defaultLanguage;
    public $defaultSpaceGuid;
    public $tour;
    public $dashboardShowProfilePostForm;
    public $logic_enter;
    public $logic_else;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array(['name', 'baseUrl'], 'required'),
            array('name', 'string', 'max' => 150),
            array('logic_enter', 'string', 'max' => 255),
            array('logic_else', 'string', 'max' => 255),
            array('defaultLanguage', 'in', 'range' => array_keys(Yii::$app->params['availableLanguages'])),
            array('defaultSpaceGuid', 'checkSpaceGuid'),
            array(['tour', 'dashboardShowProfilePostForm'], 'in', 'range' => array(0, 1))
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'logic_enter' => 'Custom if-then logic for default user space',
            'logic_else' => 'Custom else logic for default user space',
            'name' => Yii::t('AdminModule.forms_BasicSettingsForm', 'Name of the application'),
            'baseUrl' => Yii::t('AdminModule.forms_BasicSettingsForm', 'Base URL'),
            'defaultLanguage' => Yii::t('AdminModule.forms_BasicSettingsForm', 'Default language'),
            'defaultSpaceGuid' => Yii::t('AdminModule.forms_BasicSettingsForm', 'Default space'),
            'tour' => Yii::t('AdminModule.forms_BasicSettingsForm', 'Show introduction tour for new users'),
            'dashboardShowProfilePostForm' => Yii::t('AdminModule.forms_BasicSettingsForm', 'Show user profile post form on dashboard')
        );
    }

    /**
     * This validator function checks the defaultSpaceGuid.
     *
     * @param type $attribute
     * @param type $params
     */
    public function checkSpaceGuid($attribute, $params)
    {

        if ($this->defaultSpaceGuid != "") {

            foreach (explode(',', $this->defaultSpaceGuid) as $spaceGuid) {
                if ($spaceGuid != "") {
                    $space = Space::find()->andWhere(['guid' => $spaceGuid])->one();
                    if ($space == null) {
                        $this->addError($attribute, Yii::t('AdminModule.forms_BasicSettingsForm', "Invalid space"));
                    }
                }
            }
        }
    }

}
