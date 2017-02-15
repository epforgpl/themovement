<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Cake\Network\Session;

class User extends Entity
{

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }
    
    public function isLoggedUser()
    {
	    
	    $session = new Session();
		$sessionData = $session->read('Auth.User');
	    
	    return( @$sessionData['id'] == $this->id );
	    
    }
    
    public function getUrl()
    {
	    
	    return '/people/' . $this->slug;
	    
    }

}