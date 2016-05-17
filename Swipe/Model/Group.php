<?php
class Group extends AppModel {

	public $displayField = 'email';
	public $actsAs = array('Containable');

}