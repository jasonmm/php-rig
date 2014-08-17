<?php
/**
 * The interface that must be implemented by all data sources 
 * passed to RigIdentity.
 */
interface RigDataSource {
	public function getFemaleName();
	public function getMaleName();
	public function getFirstName();
	public function getLastName();
	public function getLocation();
	public function getStreet();
}
