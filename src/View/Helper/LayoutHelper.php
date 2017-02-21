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
	
	public function userAvatar($user) {
		
		$output = '<div class="img"';
		
		if( $user['fb_id'] )
			$output .= ' style="background-image: url(\'//graph.facebook.com/' . $user['fb_id'] . '/picture\') "';
		
		$output .= '>';
		
		if( !$user['fb_id'] )
			$output .= '<span class="icon-user"></span>';
		
		$output .= '</div>';
		
		return $output;
		
	}
}