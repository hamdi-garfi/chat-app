<?php
namespace Core;



class EntityManager {

    /**
     * 
     * @param array $donnees
     */
	public function __construct(array $donnees = []) {
		$this->hydrate($donnees);
	}

        /**
         * 
         * @param array $donnees
         */
	public function hydrate(array $donnees):void
	{
  		foreach ($donnees as $key => $value) {
		    // On récupère le nom du setter correspondant à l'attribut.
		    $method = 'set'.ucfirst(str_replace('_', '', $key));
        
		    // Si le setter correspondant existe.
		    if (method_exists($this, $method)) {
		      // On appelle le setter.
		      $this->$method($value);
		    }
  		}
  	}
}
