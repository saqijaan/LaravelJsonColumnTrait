<?php
namespace LaravelJsonColumn\Traits;

trait JsonColumn{

    protected $ignored = [
        'created_at' ,'updated_at','deleted_at'
    ];

    public function getExtraDataArrayAttribute(){
        return  collect(json_decode($this->attributes['extra_data']??'[]',true));
    }
    /**
     * Magic method to get Json column data as Method attribute
     */
    public function __get($key)
    {

        $jsonData = isset($this->attributes['extra_data']) && $this->attributes['extra_data']
         ? json_decode( $this->attributes['extra_data'], true )
         : [];

        if ( array_key_exists($key,$jsonData) ){
            return $jsonData[$key];
        }

        return parent::__get($key);
    }

    /**
     * Set Non exited property in Database
     * on Extra Data Column
     */
    public function updateExtra($key, $value)
    {
        return self::update([
            'extra_data' => $this->extraDataArray->merge([
                $key => $value
            ])
        ]);
    }

    /**
     * Set Non exited Peroperties in Database
     * on Extra Data Column
     */
    public function updateExtraArray(array $attributes)
    {
        return self::update([
            'extra_data' => $this->extraDataArray->merge($attributes)
        ]);
    }
}
