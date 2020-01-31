<?php

namespace App\Model;

class Model 
{
	public function __call($m,$p)
	{     
        $v = lcfirst(substr($m,3));
        if (!strncasecmp($m,'get',3))return $this->$v;
        if (!strncasecmp($m,'set',3)){
        	$this->$v = $p[0];
        	return $this;
        }
    }

    public function hydrate($data)
    {
		foreach(get_object_vars($this) as $element){

			$this->element = 
		}
	}
    }
}