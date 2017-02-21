<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['home']);
    }
    
    public function home()
    {
	    
	    $eventsTable = TableRegistry::get('Events');
	    
	    $counters = [
	    	'topics' => TableRegistry::get('Topics')->find()->count(),
	    	'events' => $eventsTable->find()->count(),
	    	'people' => TableRegistry::get('Users')->find()->count(),
	    ];
	    	    
	    $events = $eventsTable->find('all', [
		    'fields' => ['id', 'version', 'slug', 'img', 'name', 'begin_date', 'begin_time', 'end_date', 'end_time'],
			'conditions' => [],
			'order' => [
				'ord' => 'ASC',
				'begin_date' => 'ASC',
				'begin_time' => 'ASC',
				'id' => 'ASC',
			],
			'limit' => 3,
	    ]);

	    $this->set('counters', $counters);
	    $this->set('events', $events);
	    
    }
    
    public function about()
    {
	    
    }
    
    public function contact()
    {
	    
    }
    
}
