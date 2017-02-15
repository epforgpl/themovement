<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\App;

class ImagesController extends AppController
{
    
    public function upload() {
	    
	    $res = [
		    'code' => 0,
		    'msg' => '',
	    ];
	    
	    $formats = [
		    'image/png' => 'png',
		    'image/gif' => 'gif',
		    'image/jpg' => 'jpg',
		    'image/jpeg' => 'jpg',
	    ];
	    	    
	    if( @$this->request->data['file'] ) {
		    if( @$this->request->data['file']['size'] ) {
		    	if( @array_key_exists($this->request->data['file']['type'], $formats) ) {
			    	
			    	$ext = $formats[ $this->request->data['file']['type'] ];
			    	$temp_file_id = uniqid();
			    	$temp_file_original = WWW_ROOT . '/temp/' . $temp_file_id . '-original.' . $ext;
			    	$temp_file_block = WWW_ROOT . '/temp/' . $temp_file_id . '-block.jpg';
			    				    	
					if( move_uploaded_file($this->request->data['file']['tmp_name'], $temp_file_original) ) {
						
						switch( $ext ) {
							case 'png': {
								$src = imagecreatefrompng( $temp_file_original );
								break;
							}
							case 'gif': {
								$src = imagecreatefromgif( $temp_file_original );
								break;
							}
							case 'jpg': {
								$src = imagecreatefromjpeg( $temp_file_original );
								break;
							}
						}
						
						$src_width = imagesx( $src );
						$src_height = imagesy( $src );
						
						if( $src_width >= $src_height ) {
							
							$dst_height = min(600, $src_height);
							$dst_width = round( $src_width / $src_height * $dst_height );
							
						} else {
							
							$dst_width = min(600, $src_width);
							$dst_height = round( $src_height / $src_width * $dst_width );
							
						}
						
						$img = imagecreatetruecolor($dst_width, $dst_height);
						imagecopyresampled($img, $src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
						imagedestroy( $src );
						imagejpeg($img, $temp_file_block, 90);
						imagedestroy( $img );
						
												
						$res = ['code' => 200, 'msg' => 'OK', 'id' => $temp_file_id];
						
					} else { $res = ['code' => 503, 'msg' => 'Unkonwn error']; }
				} else { $res = ['code' => 502, 'msg' => 'The file format is unsupported']; }
		    } else { $res = ['code' => 501, 'msg' => 'No file']; }
	    } else { $res = ['code' => 500, 'msg' => 'No file']; }
	    	    
	    $this->set('res', $res);
	    $this->set('_serialize', 'res');
	    
	    
    }
    
    private function getModel($chapter) {
	    
	    if( $chapter == 'events' )
	    	return 'Events';
	    elseif( $chapter == 'topics' )
	    	return 'Topics';
	    elseif( $chapter == 'people' )
	    	return 'Users';
	    else
	    	return false;
	    
    }
    
    public function save() {
	    
	    $res = [
		    'code' => 0,
		    'msg' => '',
	    ];
	    
	    if(
	    	@$this->request->data['item_id'] && 
	    	@$this->request->data['id'] && 
	    	@$this->request->data['chapter'] && 
	    	( $model = $this->getModel($this->request->data['chapter']) ) && 
	    	( $item = TableRegistry::get($model)->get( $this->request->data['item_id'] ) )
    	) {
	    	
	    	$tmp_file_block = WWW_ROOT . '/temp/' . $this->request->data['id'] . '-block.jpg';
			
			if( file_exists($tmp_file_block) ) {
			
		    	$file_block = WWW_ROOT . '/resources/' . $this->request->data['chapter'] . '/' . $item->id . '-block.jpg';	    	
		    	
		    	@unlink( $file_block );
		    	rename($tmp_file_block, $file_block);
		    	
		    	$item->img = true;
		    	$item->version++;
		    	
		    	TableRegistry::get($model)->save( $item );
		    	
		    	$res = ['code' => 200, 'msg' => 'OK'];
	    	
	    	} else {
		    	$res = ['code' => 400, 'msg' => 'No src image'];
	    	}
	    	
    	}
	    
	    $this->set('res', $res);
	    $this->set('_serialize', 'res');
	    
    }
    
}