<?
namespace App\Shell;

use Cake\Console\Shell;

class RegistrationsShell extends Shell
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Registrations');
    }
    
    public function sendConfirmation()
    {
	    if( $id = $this->args[0] ) {
		    $this->Registrations->sendConfirmation($id);
	    }
    }
}