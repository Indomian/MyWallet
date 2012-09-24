<?php
/**
 * Base class for all system controllers
 * @class Controller
 * @author BlaDe39 <blade39@yandex.ru>
 */
class Controller extends CController {
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
     * Base filters method, setups using checkAccess filter for all actions in all controllers
     * @return array()
     */
    public function filters() {
        return array(
            'checkAccess'
        );
    }
    
    /**
     * Base access check method, checks access using RBAC system
     * @param CFilterChain $filterChain
     */
    public function filtercheckAccess($filterChain) {
        if(Yii::app()->user->checkAccess($this->getId().'/'.$this->getAction()->getId())) {
            $filterChain->run();
        } else {
            throw new CHttpException(403,'Not allowed: '.$this->getId().'/'.$this->getAction()->getId(),403);
        }
    }
}