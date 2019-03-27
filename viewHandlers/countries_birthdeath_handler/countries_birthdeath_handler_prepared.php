<?php
    class CountriesBirthdeathPrepared {
    
    private static $prepared = false;
    private static $preparedData = null;

    private static $country;

    public static function prepareQueries()
    {
        if (!self::$prepared)
        {
            $db = DBConnection::conexionBD();
            
            self::$preparedData = $db->prepare("SELECT birthrate, deathrate FROM countries_table 
                                                WHERE country = ? 
                                                AND birthrate IS NOT NULL
                                                ");
            self::$preparedData->bind_param("s", self::$country);

            self::$prepared = true;
        }
    }

    private static function setParams($country)
    {
        self::$country = $country;
    }

    public static function fetchData($country)
    {
        if (self::$preparedData)
        {
            self::setParams($country);
            self::$preparedData->execute();
            return self::$preparedData->get_result();
        }
        else
            return null;
    }
}