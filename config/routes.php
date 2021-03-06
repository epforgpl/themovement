<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
	
    $routes->extensions(['json', 'html']);
	
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
     
	$routes->resources('Coupons');
	$routes->resources('Surveysquestions');
	$routes->resources('Surveysanswers');
     
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'home']);
    foreach( ['about', 'contact'] as $page )
	    $routes->connect($page, ['controller' => 'Pages', 'action' => $page]);
	    
	$routes->connect('/join', ['controller' => 'Users', 'action' => 'login']);
	$routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
	
	$routes->connect('/people/:action', [
    	'controller' => 'Users', 
	], [
		'action' => 'index|facebook-login|facebook-callback|register|without_registrations'
	]);
	
	$routes->connect('/people/:slug/edit', [
    	'controller' => 'Users', 
    	'action' => 'edit',
	], [
		// 'slug' => 'init|start|loadChapter',
		'pass' => ['slug']		
	]);
	
	$routes->connect('/people/:slug', [
    	'controller' => 'Users', 
    	'action' => 'view',
	], [
		// 'slug' => 'init|start|loadChapter',
		'pass' => ['slug']		
	]);

    $routes->connect('/topics/:slug', [
    	'controller' => 'Topics', 
    	'action' => 'view',
	], [
		// 'slug' => 'init|start|loadChapter',
		'pass' => ['slug']		
	]);
	
	$routes->connect('/events/:action', [
    	'controller' => 'Events', 
	], [
		'action' => 'index|create|register|view'
	]);
	
	$routes->connect('/events/:slug', [
    	'controller' => 'Events', 
    	'action' => 'view',
	], [
		// 'slug' => 'init|start|loadChapter',
		'pass' => ['slug']		
	]);
	
	$routes->connect('/events/:id/:action', [
    	'controller' => 'Events', 
	], [
		'id' => '[0-9]+',
		'action' => 'setActiveQuestion|getActiveQuestion',
		'pass' => ['id']		
	]);
	
	$routes->connect('/events/:slug/:action', [
    	'controller' => 'Events', 
	], [
		'action' => 'finish-registration|registrations|coupons|follow|unfollow|following|agenda|people|surveys|surveys_manager|surveys_present|coc',
		'pass' => ['slug']		
	]);
	
	$routes->connect('/images/:slug/:action', [
    	'controller' => 'Images', 
	], [
		'action' => 'download',
		'pass' => ['slug']		
	]);
	
	$routes->connect(
	    '/people', ['controller' => 'Users']
	);
	
	$routes->connect(
	    '/people/:action/*', ['controller' => 'Users']
	);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
