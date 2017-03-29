<?php
namespace App\Controller;

use App\Controller\AppController;

class SurveysanswersController extends AppController
{

	public function add()
    {
        $answer = $this->Surveysanswers->newEntity($this->request->data);
        if ($this->Surveysanswers->save($answer)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            'answer' => $answer,
            '_serialize' => ['message', 'answer']
        ]);
    }
    
    public function edit($id)
    {
        $answer = $this->Surveysanswers->get($id);
        if ($this->request->is(['post', 'put'])) {
            $answer = $this->Surveysanswers->patchEntity($answer, $this->request->data);
            if ($this->Surveysanswers->save($answer)) {
                $message = 'Saved';
            } else {
                $message = 'Error';
            }
        }
        
        if( 
        	isset($this->request->data['orders']) && 
        	( $orders = $this->request->data['orders'] )
    	) {
	    	foreach( $orders as $answer_id => $i ) {
		    	$this->Surveysanswers->query()->update()->set([
			    	'ord' => $i,
		    	])->where([
			    	'id' => $answer_id,
		    	])->execute();
	    	}	    	
    	}
        
        $this->set([
            'message' => $message,
            'answer' => $answer,
            '_serialize' => ['message', 'answer']
        ]);
    }
    
    public function delete($id)
    {
        $answer = $this->Surveysanswers->get($id);
        $message = 'Deleted';
        if (!$this->Surveysanswers->delete($answer)) {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            'answer' => $answer,
            '_serialize' => ['message', 'answer']
        ]);
    }
	
}