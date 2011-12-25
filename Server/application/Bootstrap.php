<?php

/**
 * The class is the starting point for the application and initalizes base components.
 *
 * @author Benjamin Oertel <mail@benjaminoertel.com>
 * @version 1.0
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap{

  protected function _initConfig(){
    $config = new Zend_Config($this->getOptions(), true);
    Zend_Registry::set('config', $config);

    return $config;
  }

  protected function _initRights(){
    define("CRUD_MEASUREMENTS", 0);
    define("CRUD_PERSONNEL", 1);
    define("CRUD_PATIENTS", 2);
    define("CRUD_HOSPITALS", 3);
    define("CRUD_RFID", 4);
  }

  protected function _initRestRoute(){
    $this->bootstrap('frontController');
    $frontController = Zend_Controller_Front::getInstance();
    $restRouteUL = new Zend_Rest_Route($frontController, array(), array('default'=>array('patients', 'measurements', 'login')));
    $frontController->getRouter()->addRoute('rest', $restRouteUL);
  }

  /**
   * Initalize the view.
   * @author Dennis De Cock
   */
  protected function _initView(){
    $defaultConfig = $this->getOption('default');

    $view = new Zend_View();
    //ZendX_JQuery::enableView($view);
    $viewrenderer = new Zend_Controller_Action_Helper_ViewRenderer();
    $viewrenderer->setView($view);
    Zend_Controller_Action_HelperBroker::addHelper($viewrenderer);
    $this->bootstrap('layout');
    $layout = $this->getResource('layout');
    $view = $layout->getView();

    $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
    $view->headTitle()->setSeparator(' - ');
    $view->headTitle($defaultConfig['portalName']);
  }

  /**
   * Generate registry and initalize language support
   * @return Zend_Registry
   */
  protected function _initTranslate(){
    /*    $registry = Zend_Registry::getInstance();
      $locale = new Zend_Locale('de_DE');
      $translate = new Zend_Translate('csv', APPLICATION_PATH . '/../languages/de.csv', 'de');
      //$translate->addTranslation(APPLICATION_PATH . '/../languages/de.csv', 'de'); //TODO: add automatically lang support

      $registry->set('Zend_Locale', $locale);
      $registry->set('Zend_Translate', $translate);

      // translate standard zend framework messages
      $translator = new Zend_Translate(
      array(
      'adapter' => 'array',
      'content' => APPLICATION_PATH . '/../resources/languages',
      'locale'  => $locale,
      'scan'    => Zend_Translate::LOCALE_DIRECTORY

      );
      Zend_Validate_Abstract::setDefaultTranslator($translator);

      return $registry;) */
  }

  /**
   * Initialize auto loader of Doctrine to get the database connection.
   * @author: Jan Oliver Oelerich (http://www.oelerich.org/?p=193)
   *
   * @return Doctrine_Manager
   */
  public function _initDoctrine(){
    require_once('Doctrine/Common/ClassLoader.php');

    $doctrineConfig = $this->getOption('doctrine');

    $classLoader = new \Doctrine\Common\ClassLoader('Doctrine', APPLICATION_PATH . '/../library/');
    $classLoader->register();

    $classLoader = new \Doctrine\Common\ClassLoader('models', APPLICATION_PATH);
    $classLoader->register();

    $classLoader = new \Doctrine\Common\ClassLoader('proxies', APPLICATION_PATH);
    $classLoader->register();

    $config = new \Doctrine\ORM\Configuration();
    $driverImpl = $config->newDefaultAnnotationDriver(APPLICATION_PATH . "/models");
    $config->setMetadataDriverImpl($driverImpl);

    //$cache = new \Doctrine\Common\Cache\ArrayCache;
    //$config->setMetadataCacheImpl($cache);
    //$config->setQueryCacheImpl($cache);

    $config->setProxyDir(APPLICATION_PATH . '/proxies');
    $config->setProxyNamespace('Proxies');

    $connectionOptions = array(
      'driver'=>$doctrineConfig['conn']['driv'],
      'user'=>$doctrineConfig['conn']['user'],
      'password'=>$doctrineConfig['conn']['pass'],
      'dbname'=>$doctrineConfig['conn']['dbname'],
      'host'=>$doctrineConfig['conn']['host']
    );

    $em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);
    $em->getConnection()->setCharset("UTF8");
    $registry = Zend_Registry::getInstance();
    $registry->entitymanager = $em;

    return $em;
  }

}