<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
        
        /**
     * Establece los mensajes de acciones en el TbAlert,
     * @param boolean $resultado de la acción sobre el modelo
     * @param string $mensaje personalizado para mostrar en el TbAlert000000000000000000000000000000000000000000000000000000000000000000000000000000000000
     * @return Yii::app()->user->setFlash($resultado, $mensaje);
     */
    protected function setMessages($resultado, $respuesta, $mensaje = null) {
        switch ($resultado) {
            case true:
                $resultado = "success";
                $mensaje = (is_null($mensaje)) ? "<strong>" . Yii::t('application', 'Operation is successful') . "</strong>" : $mensaje;
                break;
            case false:
                $resultado = "danger";
                $mensaje = (is_null($mensaje)) ? "<strong>" . Yii::t('application', 'Operation can not be completed. Try again') . "</strong>" : $mensaje;
                $mensaje.= "<br><small>" . Yii::t('application', 'If the problem persists comunicate with the system administrator') . "</small>";
                break;
            default:
                $resultado = "info";
                $mensaje = (is_null($mensaje)) ? "<strong>" . Yii::t('application', 'Operation can not be completed. try again') . "</strong>" : $mensaje;
                break;
        }

        if (YII_DEBUG && !empty($respuesta)) {
            foreach ($respuesta as $key => $value) {
                $mensaje .= '<br><small>' . $value[0] . '</small>';
            }
        }

        Yii::app()->user->setFlash($resultado, $mensaje);
    }
}