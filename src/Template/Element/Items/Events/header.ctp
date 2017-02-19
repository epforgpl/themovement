<div class="row">
	<div class="col-md-12">
		
		<?
			$params = [
				'item' => $item,
				'chapter' => 'events',
				'avatar_manage' => ( $_user && ($_user['role']=='admin') )
			];
			
			if( $item['registration'] && !@$user_registration->id ) {					
				
				if( $_user ) {
					$data = [];
					$class = 'btn-register';
				} else {
					$data = [
						'msg' => 'In order to register for this event, you need to login.',
						'next' => $item->getUrl() . '?register'
					];
					$class = 'btn-register login-required';
				}
				
				$params['title_buttons'] = [
					[
						'id' => 'btn-register',
						'class' => $class,
						'content' => 'Register',
						'data' => $data,
					]
				];
			}
			
			if( $_user && ($_user['role']=='admin') ) {
				$params['buttons'] = [
					/*
					[
						'class' => 'btn-themovement btn-main',
						'content' => '<span class="icon-text">&plus;</span> Follow',
					],
					[
						'content' => '<span class="glyphicon glyphicon-comment"></span>',
					],
					[
						'content' => '<span class="glyphicon glyphicon-share"></span>',
					],
					*/
					[
						'content' => '<span class="glyphicon glyphicon-cog"></span>',
						'attr' => 'data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"',
						'dropdown' => [
							[
								'href' => $item->getUrl() . '/registrations',
								'content' => 'Registrations',
							],
							[
								'href' => $item->getUrl() . '/coupons',
								'content' => 'Coupons',
							]
						],
					],
				];
			}
											
			echo $this->element('Items/header', $params);
		?>
		
	</div>
</div>