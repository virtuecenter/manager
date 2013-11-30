<?php
/*
 * @version .1
 * @link https://raw.github.com/virtuecenter/manager/master/available/carousels.php
 * @mode upgrade
 */
namespace Manager;

class carousels {
	private $field = false;
    public $collection = 'carousels';
    public $title = 'Carousel';
    public $titleField = 'title';
    public $singular = 'Carousel';
    public $description = '4 carousels';
    public $definition = '...';
    public $acl = ['content', 'admin', 'superadmin'];
    public $icon = 'sign in';
    public $category = 'Content';
    public $after = 'function';
    public $function = 'ManagerSaved';
    public $notice = 'Carousel Saved';
    public $storage = [
        'collection' => 'carousels',
        'key' => '_id'
    ];

	function titleField () {	
		return [
			'name' => 'title',
			'label' => 'Title',
			'required' => true,
			'display' => 'InputText'
		];
	}
	
	public function image_individualField() {
		return [
			'name'		=> 'image_individual',
			'label'		=> 'Frames',
			'required'	=> false,
			'display'	=> 'Manager',
			'manager'	=> 'subcarousels'
		];
	}
	
	function descriptionField () {
		return [
			'name' => 'description',
			'label' => 'Description',
			'display' => 'Textarea'
		];
	}
		
	function tagsField () {
		return [
			'name' => 'tags',
			'label' => 'Tags',
			'required' => false,
			'transformIn' => function ($data) {
				if (is_array($data)) {
					return $data;
				}
				return $this->field->csvToArray($data);
			},
			'display' => 'InputToTags',
			'multiple' => true,
			'options' => function () {
				return $this->db->distinct('carousels', 'tags');
			}
		];
	}	

	public function carousel_individualField() {
		return [
			'name'		=> 'carousel_individual',
			'label'		=> 'carousels',
			'required'	=> false,
			'display'	=> 'Manager',
			'manager'	=> 'subcarousels'
		];
	}
	
	public function tablePartial () {
        $partial = <<<'HBS'
            <div class="top-container">
                {{#CollectionHeader}}{{/CollectionHeader}}
            </div>

            <div class="bottom-container">
                {{#if carousels}}
	                {{#CollectionPagination}}{{/CollectionPagination}}
	                {{#CollectionButtons}}{{/CollectionButtons}}
	                
	                <table class="ui large table segment manager">
	                    <col width="20%">
	                    <col width="70%">
	                    <col width="10%">
	                    <thead>
	                        <tr>
	                            <th>Title</th>
	                            <th>URL</th>
	                            <th class="trash">Delete</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                        {{#each carousels}}
	                            <tr data-id="{{dbURI}}">
	                                <td>{{title}}</td>
	                                <td>{{url}}</td>
	                                <td>
	                                    <div class="manager trash ui icon button">
	                                         <i class="trash icon"></i>
	                                     </div>
	                                 </td>
	                            </tr>
	                        {{/each}}
	                    </tbody>
	                </table>

	                {{#CollectionPagination}}{{/CollectionPagination}}
		        {{else}}
					{{#CollectionEmpty}}{{/CollectionEmpty}}
				{{/if}}
            </div>
HBS;
        return $partial;
    }

    public function formPartial () {
        $partial = <<<'HBS'
        	{{#Form}}{{/Form}}
	            <div class="top-container">
	                {{#DocumentHeader}}{{/DocumentHeader}}
	                {{#DocumentTabs}}{{/DocumentTabs}}
	            </div>

	            <div class="bottom-container">
	                {{#DocumentFormLeft}}
	                    {{#FieldLeft title Title required}}{{/FieldLeft}}
	                    {{#FieldLeft description Description required}}{{/FieldLeft}}
	                    {{#FieldEmbedded image_individual subcarousels Frames}}{{/FieldEmbedded}}
	                    {{{id}}}
	                {{/DocumentFormLeft}}                 
	                
	                {{#DocumentFormRight}}
	                	{{#DocumentButton}}{{/DocumentButton}}
	                	{{#FieldFull tags Tags}}{{/FieldFull}}
	                {{/DocumentFormRight}}
	            </div>
	        </form>
HBS;
        return $partial;
    }
}	