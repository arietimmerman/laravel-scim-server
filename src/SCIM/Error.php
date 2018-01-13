<?php

namespace ArieTimmerman\Laravel\SCIMServer\SCIM;

use Illuminate\Contracts\Support\Jsonable;

class Error implements Jsonable{

    protected $detail, $status, $scimType;

    public function toJson($options = 0) {
        return json_encode(array_filter([
            "schemas" => ["urn:ietf:params:scim:api:messages:2.0:Error"],
            "detail" => $this->detail,
            "status" => $this->status,
            "scimType" => ($this->status == 400 ? $this->scimType : null)
        ]), $options);
    }

    function __construct($detail, $status = "404", $scimType = "invalidValue"){
        $this->detail = $detail;
        $this->status = $status;
        $this->scimType = $scimType;
    }  


}