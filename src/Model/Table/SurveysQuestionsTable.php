<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class SurveysQuestionsTable extends Table
{
	
	public function initialize(array $config)
    {
	    
	    $this->table('surveysquestions');
	    $this->hasMany('SurveysAnswers', [
		    'foreignKey' => 'question_id',
	    ]);
	    
    }

}