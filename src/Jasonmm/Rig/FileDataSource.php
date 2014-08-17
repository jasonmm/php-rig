<?php
/**
 * A data source class for retrieving identity data from standard 
 * RIG .idx files.
 */
class FileDataSource implements RigDataSource {
	// These variables hold default filenames for each type.
	private $femaleNames = '/usr/share/rig/fnames.idx';
	private $maleNames = '/usr/share/rig/mnames.idx';
	private $lastNames = '/usr/share/rig/lnames.idx';
	private $locData = '/usr/share/rig/locdata.idx';
	private $street = '/usr/share/rig/street.idx';

	// These variables hold the number of lines each file has.
	private $femaleNamesLineCount = 0;
	private $maleNamesLineCount = 0;
	private $lastNamesLineCount = 0;
	private $locDataLineCount = 0;
	private $streetLineCount = 0;

	/**
	 * Initialize which files should be used to read data from.
	 * @param array $fileNames
	 */
	public function __construct(array $fileNames = array()) {
		$this->initFileName('femaleNames', $fileNames);
		$this->initFileName('maleNames', $fileNames);
		$this->initFileName('lastNames', $fileNames);
		$this->initFileName('locData', $fileNames);
		$this->initFileName('street', $fileNames);

		$this->femaleNamesLineCount = $this->countLines($this->femaleNames);
		$this->maleNamesLineCount = $this->countLines($this->maleNames);
		$this->lastNamesLineCount = $this->countLines($this->lastNames);
		$this->locDataLineCount = $this->countLines($this->locData);
		$this->streetLineCount = $this->countLines($this->street);
	}

	/**
	 * Sets the type of filename to the given filename.
	 * @param string $type one of "femaleNames", "maleName", etc...
	 * @param array $fileNames the same array passed to __construct()
	 */
	private function initFileName($type, array $fileNames) {
		if( isset($fileNames[$type]) ) {
			if( file_exists($fileNames[$type])) {
				$this->$type = $fileNames[$type];
			}
		}
	}

	/**
	 * Counts the number of lines in the given filename.
	 * http://stackoverflow.com/questions/2162497/efficiently-counting-the-number-of-lines-of-a-text-file-200mb
	 * @param string $fn
	 * @return int
	 */
	private function countLines($fn) {
		$fp = fopen($fn, 'rb');
		if( $fp === false ) {
			return 0;
		}
		$n = 0;
		while( !feof($fp) ) {
			$n += substr_count(fread($fp, 16384), "\n");
		}
		fclose($fp);
		return $n;
	}

	/**
	 * Returns the line on the given line number from the given file.
	 * @param string $fn
	 * @param string $targetLineNum
	 * @return string|null null is returned if the file cannot be opened or if EOF is reached before the target line number is reached.
	 */
	private function readTargetLine($fn, $targetLineNum) {
		$fp = fopen($fn, 'rb');
		if( $fp === false ) {
			return null;
		}
		for( $i = 0; $i < $targetLineNum; $i++ ) {
			fgets($fp);
			if( feof($fp) ) {
				return null;
			}
		}
		$line = fgets($fp, 50);
		fclose($fp);
		return trim($line);
	}
	
	/**
	 * Retrieve a female name.
	 * @return string
	 */
	public function getFemaleName() {
		$r = mt_rand(0, $this->femaleNamesLineCount);
		return $this->readTargetLine($this->femaleNames, $r);
	}

	/**
	 * Retrieve a male name.
	 * @return string
	 */
	public function getMaleName() {
		$r = mt_rand(0, $this->maleNamesLineCount);
		return $this->readTargetLine($this->maleNames, $r);
	}

	/**
	 * Retrieve a first name.  Whether the name is male or female is decided randomly.
	 * @return string
	 */
	public function getFirstName() {
		$r = mt_rand(1,2);
		if( $r == 1 ) {
			return $this->getMaleName();
		} else {
			return $this->getFemaleName();
		}
	}

	/**
	 * Retrieve a last name.
	 * @return string
	 */
	public function getLastName() {
		$r = mt_rand(0, $this->lastNamesLineCount);
		return $this->readTargetLine($this->lastNames, $r);
	}

	/**
	 * Retrieve location data.
	 * @return string
	 */
	public function getLocation() {
		$r = mt_rand(0, $this->locDataLineCount);
		return $this->readTargetLine($this->locData, $r);
	}

	/**
	 * Retrieve a street address.
	 * @return string
	 */
	public function getStreet() {
		$r = mt_rand(0, $this->streetLineCount);
		return $this->readTargetLine($this->street, $r);
	}
}
