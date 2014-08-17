<?php
namespace Jasonmm\Rig;

/**
 * Creates and holds a randomly created identity.
 */
class RigIdentity {
	// Contants used to determine the type of first name generated.
	const GENDER_MALE = 1;
	const GENDER_FEMALE = 2;
	const GENDER_RANDOM = 3;

	// Identity variables.
	private $firstName = '';
	private $lastName = '';
	private $street = '';
	private $city = '';
	private $state = '';
	private $zip = '';
	private $phone = '';

	/**
	 * Constructor that builds the random identity.
	 * @param RigDataSource $ds the data source used to retrieve the identity data.
	 * @param int $gender the gender for the first name of the identity.
	 */
	public function __construct(RigDataSource $ds, $gender = self::GENDER_RANDOM) {
		if( $gender == self::GENDER_MALE ) {
			$this->firstName = $ds->getMaleName();
		} elseif( $gender == self::GENDER_FEMALE ) {
			$this->firstName = $ds->getFemaleName();
		} else {
			$this->firstName = $ds->getFirstName();
		}
		$this->lastName = $ds->getLastName();
		$this->street = $ds->getStreet();
		$ld = $ds->getLocation();
		list($this->city, $this->state, $areaCode, $this->zip) = explode(' ', $ld);
		$this->phone = '('.$areaCode.') '.mt_rand(100,999).'-'.mt_rand(1000,9999);
	}
}

