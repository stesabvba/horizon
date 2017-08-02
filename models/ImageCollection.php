<?php
class ImageCollection extends Illuminate\Database\Eloquent\Model {

	protected $table='image_collection';

    protected $fillable = [
        'name',
    ];
	
	public function contents()
	{
		return $this->hasMany('ImageCollectionContent');
	}
}
?>