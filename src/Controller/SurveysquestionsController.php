<?php
namespace App\Controller;

use App\Controller\AppController;

class SurveysquestionsController extends AppController
{

	public function add()
    {
        $question = $this->Surveysquestions->newEntity($this->request->data);
        if ($this->Surveysquestions->save($question)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            'question' => $question,
            '_serialize' => ['message', 'question']
        ]);
    }
    
    public function edit($id)
    {
        $question = $this->Surveysquestions->get($id);
        if ($this->request->is(['post', 'put'])) {
            $question = $this->Surveysquestions->patchEntity($question, $this->request->data);
            if ($this->Surveysquestions->save($question)) {
                $message = 'Saved';
            } else {
                $message = 'Error';
            }
        }
        
        if( 
        	isset($this->request->data['orders']) && 
        	( $orders = $this->request->data['orders'] )
    	) {
	    	foreach( $orders as $question_id => $i ) {
		    	$this->Surveysquestions->query()->update()->set([
			    	'ord' => $i,
		    	])->where([
			    	'id' => $question_id,
		    	])->execute();
	    	}	    	
    	}
        
        $this->set([
            'message' => $message,
            'question' => $question,
            '_serialize' => ['message', 'question']
        ]);
    }
    
    public function delete($id)
    {
        $question = $this->Surveysquestions->get($id);
        $message = 'Deleted';
        if (!$this->Surveysquestions->delete($question)) {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            'question' => $question,
            '_serialize' => ['message', 'question']
        ]);
    }
	
}