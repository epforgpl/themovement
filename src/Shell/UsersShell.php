<?
namespace App\Shell;

use Cake\Console\Shell;

class UsersShell extends Shell
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Users');
    }
    
    public function markRegistrationMails()
    {
	    $this->Users->markRegistrationMails();
    }
    
    public function sendRegistrationMails()
    {
	    $this->Users->sendRegistrationMails();
    }
    
    public function sendInfopackMails()
    {
	    $this->Users->sendInfopackMails();
    }
    
}