<?php 
    /** 
    * Zend_Auth_Adapter_Doctrine 
    * http://nopaste.info/9ebe309daf_nl.html
    * @author TheQ 
    * @package auth 
    */ 
    class Unplagged_Auth_Adapter_Doctrine implements Zend_Auth_Adapter_Interface 
    { 
        /** 
        * The Entity/Classname which holds authentication data 
        * @var string 
        */ 
        private $authEntityName; 

        /** 
        * The Field/Variable name which represents identity e.g. username 
        * @var string 
        */ 
        private $authIdentityField; 
        
        /** 
        * The Field/Variable name which represents credential e.g. password 
        * @var string 
        */ 
        private $authCredentialField; 
        
        /** 
        * The identity to be checked 
        * @var string 
        */ 
        private $identity; 
        
        /** 
        * The credentials to be checked 
        * @var string 
        */ 
        private $credential; 

        /** 
        * Instance of an EntityManager 
        * @var  
        */ 
        private $entityManager; 
        
        /** 
        * Constructor. 
        */ 
        public function __construct($em=null, $authEntityName=null, $authIdentityField=null, 
                                    $authCredentialField=null, $identity=null, $credential=null) 
        { 
            $this->authEntityName = $authEntityName; 
            $this->authIdentityField = $authIdentityField; 
            $this->authCredentialField = $authCredentialField; 
            $this->identity = $identity; 
            $this->credential = $credential; 
            $this->entityManager = $em; 
        } 
        
        /** 
        * (non-PHPdoc) 
        * @see Zend_Auth_Adapter_Interface::authenticate() 
        */ 
        public function authenticate() 
        { 
            $authEntity = $this->entityManager->getRepository($this->authEntityName) 
                          ->findOneBy(array( 
                              $this->authIdentityField => $this->identity, 
                              $this->authCredentialField => $this->credential 
                          )); 
                          echo "auth me !!";
            if($authEntity !== null) { 
                return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $authEntity); 
            } else { 
                return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, null); 
            } 
        } 
        
        /** 
        * @return string 
        */ 
        public function getAuthEntityName() 
        { 
            return $this->authEntityName; 
        } 
        
        /** 
        * @return string 
        */ 
        public function getAuthIdentityField() 
        { 
            return $this->authIdentityField; 
        } 
        
        /** 
        * @return string 
        */ 
        public function getAuthCredentialField() 
        { 
            return $this->authCredentialField; 
        } 
        
        /** 
        * @return string 
        */ 
        public function getIdentity() 
        { 
            return $this->identity; 
        } 
        
        /** 
        * @return string 
        * Enter description here ... 
        */ 
        public function getCredential() 
        { 
            return $this->credential; 
        } 

        /** 
        * @param string $authEntityName 
        * @return BJ_Auth_Adapter_Doctrine 
        */ 
        public function setAuthEntityName($authEntityName) 
        { 
            $this->authEntityName = $authEntityName; 
            return $this; 
        } 
        
        /** 
        * @param string $authIdentityField 
        * @return BJ_Auth_Adapter_Doctrine 
        */ 
        public function setAuthIdentityField($authIdentityField) 
        { 
            $this->authIdentityField = $authIdentityField; 
            return $this; 
        } 
        
        /** 
        * @param string $authCredentialField 
        * @return BJ_Auth_Adapter_Doctrine 
        */ 
        public function setAuthCredentialField($authCredentialField) 
        { 
            $this->authCredentialField = $authCredentialField; 
            return $this; 
        } 
        
        /** 
        * @param string $identity 
        * @return BJ_Auth_Adapter_Doctrine 
        */ 
        public function setIdentity($identity) 
        { 
            $this->identity = $identity; 
            return $this; 
        } 
        
        /** 
        * @param string $credential 
        * @return BJ_Auth_Adapter_Doctrine 
        */ 
        public function setCredential($credential) 
        { 
            $this->credential = $credential; 
            return $this; 
        } 
        
        /** 
        * @param $em 
        * @return BJ_Auth_Adapter_Doctrine 
        */ 
        public function setEntityManager($em) 
        { 
            $this->entityManager = $em; 
            return $this; 
        } 
    }