<?php
    class SuicidesNEvolutionPrepared {
    private static $prepared = false;
    private static $preparedData = null;
    private static $preparedAge = null;
    private static $preparedCountry = null;

    private static $age;
    private static $ageDefault;
    private static $country;
    private static $countryDefault;


    public static function prepareQueries()
    {
        if (!self::$prepared)
        {
            $db = DBConnection::conexionBD();
            
            self::$preparedCountry = $db->prepare("SELECT DISTINCT country FROM suicides_table WHERE 
                                                    (age = ? OR 1 = ?) ORDER BY country ASC;");
            self::$preparedCountry->bind_param("si", self::$age, self::$ageDefault);

            self::$preparedAge = $db->prepare("SELECT DISTINCT age FROM suicides_table 
                                                WHERE (country = ? OR 1 = ?) 
                                                ORDER BY LENGTH(age) ASC, age ASC;");
            self::$preparedAge->bind_param("si", self::$country, self::$countryDefault);

            self::$preparedData = $db->prepare("SELECT SUM(suicides_no) as 'suicides', year FROM suicides_table 
                                                WHERE (country = ? OR 1 = ?)
                                                AND (age = ? OR 1 = ?) 
                                                GROUP BY year
                                                ORDER BY year;");
            self::$preparedData->bind_param("sisi", self::$country, self::$countryDefault, self::$age, self::$ageDefault);

            self::$prepared = true;
        }
    }

    private static function setParams($country, $age)
    {
        self::$country = $country;
        self::$countryDefault = ($country === 'Any') ? 1 : 0;
        self::$age = $age;
        self::$ageDefault = ($age === 'Any') ? 1 : 0;
    }

    public static function fetchCountry($country, $age)
    {
        if (self::$preparedCountry)
        {
            self::setParams($country, $age);
            self::$preparedCountry->execute();
            return self::$preparedCountry->get_result();
        }
        else
            return null;
    }

    public static function fetchAge($country, $age)
    {
        if (self::$preparedAge)
        {
            self::setParams($country, $age);
            self::$preparedAge->execute();
            return self::$preparedAge->get_result();
        }
        else
            return null;
    }


    public static function fetchData($country, $age)
    {
        if (self::$preparedData)
        {
            self::setParams($country, $age);
            self::$preparedData->execute();
            return self::$preparedData->get_result();
        }
        else
            return null;
    }
}