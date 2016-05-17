<?php
App::uses('AppModel', 'Model');
/**
 * Answer Model
 *
 */
class Track extends AppModel {

	public $actsAs = array('Containable');

	 public $belongsTo = array(
		'TrackType' => array(
			'className' => 'TrackType',
			'foreignKey' => 'track_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	); 

}
?>