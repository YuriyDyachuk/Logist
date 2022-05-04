<?php

namespace App\Services;

use MenaraSolutions\Geographer\Earth;
use MenaraSolutions\Geographer\Country;
use MenaraSolutions\Geographer\State;
use MenaraSolutions\Geographer\City;

class GeographerService {
	private $locale, $earth;

	public function __construct() {
		$this->locale = language()->getCode();

		if($this->locale == 'ua')
			$this->locale = 'uk';

		$this->earth = new Earth();
	}

	public function getCountries(){
		$data = $this->earth->setLocale($this->locale)->getCountries();
		return $data;
	}

	public function getCountryByCode($country_code){
		return $country = $this->earth->findOneByCode($country_code)->setLocale($this->locale);
	}

	public function getStates($country_code){
		$country = $this->earth->findOneByCode($country_code);
		return $country->getStates()->setLocale($this->locale)->sortBy('name')->toArray();
	}

	public function getStateByCode($state_code){
		return State::build($state_code)->setLocale($this->locale);
	}

	public function getCities($state_code){
		$state = State::build($state_code)->setLocale($this->locale);
		return $state->getCities()->setLocale($this->locale)->sortBy('name')->toArray();
	}

	public function getCityByCode($city_code){
		return City::build($city_code)->setLocale($this->locale);
	}

}