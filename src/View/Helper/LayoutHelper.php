<?php
namespace App\View\Helper;

use Cake\View\Helper;

class LayoutHelper extends Helper
{
	public function calendar($item) {
		
		$output = '';
		
		if( $item->begin_date ) {
			
			$parts = [ $item->begin_date->format('j') ];
			
			if( $item->end_date )
				$parts[] = $item->end_date->format('j');
				
			$parts = array_unique($parts);
							
			$output .= '
			<div class="code_avatar event">
				<div class="code_avatar_inner">
					<p class="month">' . $item->begin_date->format('M y') . '</p>
					<p class="days">' . implode('-', $parts) . '</p>
				</div>
			</div>';
		}
		
		return $output;
		
	}
	
	public function userAvatar($user, $options = []) {
		
		$options = array_merge([
			'gender' => false,
		], $options);
		
		$output = '<div class="img"';
		
		if( $user['fb_id'] )
			$output .= ' style="background-image: url(\'//graph.facebook.com/' . $user['fb_id'] . '/picture?type=normal\') "';
		
		$output .= '>';
		
		if( !$user['fb_id'] ) {
			
			if( $options['gender'] ) {
				if( $user['gender']=='male' ) {
					$class = 'icon-gender icon-account_man';
				} elseif( $user['gender']=='female' ) {
					$class = 'icon-gender icon-account_women';
				} else {
					$class = 'icon-user';
				}
			} else {
				$class = 'icon-user';
			}
			
			$output .= '<span class="' . $class . '"></span>';
			
		}
		
		$output .= '</div>';
		
		return $output;
		
	}
	
	public function href($input) {
		
		if(
			( stripos($input, 'https://')===0 ) ||
			( stripos($input, 'http://')===0 )
		)
			return $input;
		else
			return 'http://' . $input;
		
	}
}