<?php
class blurbs {
	public $collection = 'blurbs';
	public $form = 'blurbs';
	public $headers = [];
	public $title = [];
	public $acl = ['content', 'admin', 'superadmin'];
	public $icon = 'someicon.png';
	public $category = 'Content';

	public function row (&$document) {
		return [
			'title' => $document['title']
		];
	}
}