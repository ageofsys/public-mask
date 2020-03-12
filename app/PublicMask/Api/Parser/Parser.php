<?php


namespace App\PublicMask\Api;


use App\PublicMask\Api\Exceptions\NotExistsRemoteModelAttribute;
use App\Sale;

abstract class Parser
{
    protected $modelClass;

    protected $rawJson;

    protected $modelInstance;

    protected $attributeMap;

    public function __construct($rawJson)
    {
        $this->rawJson = $rawJson;
    }

    public function parse($rawJson = "")
    {
        $this->modelInstance = new $this->modelClass;
        $this->setAllAttributeToModel();

        return $this->modelInstance;
    }

    public function setAllAttributeToModel()
    {
        foreach ($this->attributeMap as $key => $attribute) {
            if ( ! isset($this->rawJson[$key]) ) {
                throw new NotExistsRemoteModelAttribute("$key 속성이 존재하지 않습니다.");
            }
            $this->modelInstance[$attribute] = $this->rawJson[$key];
        }
    }
}
