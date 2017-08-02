<?php
class TagParents extends Illuminate\Database\Eloquent\Model {
	protected $table = 'tag_parents';

	public function tag() {
		return $this->hasOne('Tag', 'id', 'tag_id');
	}

	public function parent_tag() {
		return $this->hasOne('Tag', 'id', 'parent_tag_id');	


	}
}