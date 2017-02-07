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
}