<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }

    protected function _initAutoloader() {
        $resourceLoader = new Zend_Application_Module_Autoloader(
            array(
                'namespace' => 'Ilp',
                'basePath' => APPLICATION_PATH . '/ilp'
                )
            );

        $resourceLoader->addResourceType('tools', 'tools', 'Tool');
        return $resourceLoader;
    }

    protected function setconstants($constants){
        foreach ($constants as $key=>$value){
            if(!defined($key)){
                define($key, $value);
            }
        }
    }
//     protected function _initTranslate()
//     {
//         $translate = new Zend_Translate('gettext',
//             APPLICATION_PATH . "/langs/",
//             null,
//             array('scan' => Zend_Translate::LOCALE_DIRECTORY));
//         $registry = Zend_Registry::getInstance();
//         $registry->set('Zend_Translate', $translate);
//         $translate->setLocale('es');
//     }
//     public function _initRoutes()
//     {
//         $this->bootstrap('FrontController');
//         $this->_frontController = $this->getResource('FrontController');
//         $router = $this->_frontController->getRouter();

//         $langRoute = new Zend_Controller_Router_Route(
//             ':lang/',
//             array(
//                 'lang' => 'es',
//             )
//         );

//         $defaultRoute = new Zend_Controller_Router_Route(
//             ':controller/:action',
//             array(
//                 'module'=>'default',
//                 'controller'=>'index',
//                 'action'=>'index'
//             )
//         );

//         $defaultRoute = $langRoute->chain($defaultRoute);

//         $router->addRoute('langRoute', $langRoute);
//         $router->addRoute('defaultRoute', $defaultRoute);
//     }
//     protected function _initLanguage()
//     {
//         $front = Zend_Controller_Front::getInstance();
//         $front->registerPlugin(new App_Controller_Plugin_Language());
//     }
// }

// class App_Controller_Plugin_Language extends Zend_Controller_Plugin_Abstract {
//     public function routeShutdown(Zend_Controller_Request_Abstract $request)
//     {
//         $lang = $request->getParam('lang', null);

//         $translate = Zend_Registry::get('Zend_Translate');

//         if ($translate->isAvailable($lang)) {
//             $translate->setLocale($lang);
//         } else {
//             $translate->setLocale('es');
//         }

//         // Set language to global param so that our language route can
//         // fetch it nicely.
//         $front = Zend_Controller_Front::getInstance();
//         $router = $front->getRouter();
//         $router->setGlobalParam('lang', $lang);
//     }
}