<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class SurveysAnswersTable extends Table
{
	
	public function initialize(array $config)
    {
	    
	    $this->table('surveysanswers');
	    
    }

}