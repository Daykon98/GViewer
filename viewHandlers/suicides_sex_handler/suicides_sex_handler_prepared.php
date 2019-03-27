<?php
    class SuicidesSexPrepared {
    private static $prepared = false;
    private static $preparedData = null;
    private static $preparedAge = null;
    private static $preparedCountry = null;
    private static $preparedYear = null;

    private static $year;
    private static $yearDefault;
    private static $age;
    private static $ageDefault;
    private static $country;
    private static $countryDefault;


    public static function prepareQueries()
    {
        if (!self::$prepared)
        {
            $db = DBConnection::conexionBD();
            if (!$db)
                return FALSE;
            
            self::$preparedCountry = $db->prepare("SELECT DISTINCT country FROM suicides_table WHERE 
                                                    (year = ? OR 1 = ?) AND 
                                                    (age = ? OR 1 = ?) ORDER BY country ASC;");
            self::$preparedCountry->bind_param("sisi", self::$year, self::$yearDefault, self::$age, self::$ageDefault);

            self::$preparedAge = $db->prepare("SELECT DISTINCT age FROM suicides_table 
                                                WHERE (year = ? OR 1 = ?) AND 
                                                (country = ? OR 1 = ?) ORDER BY LENGTH(age) ASC, age ASC;");
            self::$preparedAge->bind_param("sisi", self::$year, self::$yearDefault, self::$country, self::$countryDefault);

            self::$preparedYear = $db->prepare("SELECT DISTINCT year FROM suicides_table 
                                                WHERE (country = ? OR 1 = ?) AND 
                                                (age = ? OR 1 = ?) ORDER BY year ASC;");
            self::$preparedYear->bind_param("sisi", self::$country, self::$countryDefault, self::$age, self::$ageDefault);

            self::$preparedData = $db->prepare("SELECT SUM(suicides_no) as 'suicides', sex FROM suicides_table 
                                                WHERE (country = ? OR 1 = ?)
                                                AND (age = ? OR 1 = ?) 
                                                AND (year = ? OR 1 = ?) 
                                                GROUP BY sex
                                                ORDER BY sex");
            self::$preparedData->bind_param("sisisi", self::$country, self::$countryDefault, self::$age, self::$ageDefault, self::$year, self::$yearDefault);

            self::$prepared = true;
            
        }
        return TRUE;

    }

    private static function setParams($country, $age, $year)
    {
        self::$country = $country;
        self::$countryDefault = ($country === 'Any') ? 1 : 0;
        self::$age = $age;
        self::$ageDefault = ($age === 'Any') ? 1 : 0;
        self::$year = $year;
        self::$yearDefault = ($year === 'Any') ? 1 : 0;
    }

    public static function fetchCountry($country, $age, $year)
    {
        if (self::$preparedCountry)
        {
            self::setParams($country, $age, $year);
            self::$preparedCountry->execute();
            return self::$preparedCountry->get_result();
        }
        else
            return null;
    }

    public static function fetchAge($country, $age, $year)
    {
        if (self::$preparedAge)
        {
            self::setParams($country, $age, $year);
            self::$preparedAge->execute();
            return self::$preparedAge->get_result();
        }
        else
            return null;
    }

    public static function fetchYear($country, $age, $year)
    {
        if (self::$preparedYear)
        {
            self::setParams($country, $age, $year);
            self::$preparedYear->execute();
            return self::$preparedYear->get_result();
        }
        else
            return null;
    }

    public static function fetchData($country, $age, $year)
    {
        if (self::$preparedData)
        {
            self::setParams($country, $age, $year);
            self::$preparedData->execute();
            return self::$preparedData->get_result();
        }
        else
            return null;
    }
}