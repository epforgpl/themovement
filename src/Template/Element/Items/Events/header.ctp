<div class="row">
	<div class="col-md-12">
		
		<?
			$params = [
				'item' => $item,
				'chapter' => 'events',
				'avatar_manage' => ( $_user && ($_user['role']=='admin') ),
				'buttons' => [],
			];
			
			if( $item['registration'] ) {					
				
				if( !@$user_registration->id ) {
				
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
					
					$params['buttons'][] = [
						'id' => 'btn-register',
						'class' => $class,
						'content' => 'Register',
						'data' => $data,
					];
				
				}
				
			} else {
								
				if( $user_follow ) {
					$class = 'btn-default';
					$content = 'Unfollow';
					$action = $item->getUrl() . '/unfollow';
				} else {
					$class = 'btn-themovement';
					$content = 'Follow';
					$action = $item->getUrl() . '/follow';
				}
				
				$params['buttons'][] = [
					'id' => 'btn-follow',
					'class' => $class,
					'content' => $content,
					'before' => '<form action="' . $action . '" method="post">',
					'after' => '</form>',
				];
				
			}
			
			if( $_user && ($_user['role']=='admin') ) {
				$params['buttons'][] = [
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
				];
			}
											
			echo $this->element('Items/header', $params);
		?>
		
	</div>
</div>