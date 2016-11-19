<?php namespace \mwapp\components\uploader ;

class Uploader
{
	public function copy( $src, $dest, $maxWidth, $maxHeight )
	{
		$builder = new \Imagecraft\ImageBuilder( ['engine' => 'php_gd', 'locale' => 'en'] );

		$image = $builder->addBackgroundLayer()->filename( $src )->resize( $maxWidth , $maxHeight, 'shrink')->done()->save();
		
		return file_put_contents( $dest , $this->image->getContents() );
	}

	public function create( $src, $dest, $maxWidth, $maxHeight )
	{
		$builder = new \Imagecraft\ImageBuilder( ['engine' => 'php_gd', 'locale' => 'en'] );

		$image = $builder->addBackgroundLayer()->filename( $src )->resize( $maxWidth , $maxHeight, 'shrink')->done()->save();
		
		return file_put_contents( $dest , $this->image->getContents() );
	}
}
}
