<?php
namespace frontend\helpers;

/**
 *
 * Различные полезные функции
 *
 * translit($str) - Переводим строку в url строку
 *
 * @author Ефремов Петр
 * @since 2.0
 */
class Utilities
{
    /**
     * Переводим строку в url строку
     * @param string $url
     * @return string
     */
    public static function translit( $str )
    {
        $alphavit = array(
            /*--*/
            "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d","е"=>"e",
            "ё"=>"yo","ж"=>"j","з"=>"z","и"=>"i","й"=>"i","к"=>"k","л"=>"l", "м"=>"m",
            "н"=>"n","о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t",
            "у"=>"y","ф"=>"f","х"=>"h","ц"=>"c","ч"=>"ch", "ш"=>"sh","щ"=>"sh",
            "ы"=>"i","э"=>"e","ю"=>"u","я"=>"ya",
            /*--*/
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D","Е"=>"E", "Ё"=>"Yo",
            "Ж"=>"J","З"=>"Z","И"=>"I","Й"=>"I","К"=>"K", "Л"=>"L","М"=>"M",
            "Н"=>"N","О"=>"O","П"=>"P", "Р"=>"R","С"=>"S","Т"=>"T","У"=>"Y",
            "Ф"=>"F", "Х"=>"H","Ц"=>"C","Ч"=>"Ch","Ш"=>"Sh","Щ"=>"Sh",
            "Ы"=>"I","Э"=>"E","Ю"=>"U","Я"=>"Ya",
            "ь"=>"","Ь"=>"","ъ"=>"","Ъ"=>"",
            /*--*/
            " "=>"-", ","=>"", "("=>"", ")"=>"", "\"" => "", "." => '-', "№" => "-"
        );
        return strtolower( strtr( $str, $alphavit ) );
    }

    /**
     * Назание месяца по его id
     * @param integer $month_id
     * @return string
     */
    public static function getMonthName($month_id)
    {
        $month_list = [
            1 => 'Января',
            2 => 'Февраля',
            3 => 'Марта',
            4 => 'Апреля',
            5 => 'Мая',
            6 => 'Июня',
            7 => 'Июля',
            8 => 'Августа',
            9 => 'Сентября',
            10 => 'Октября',
            11 => 'Ноября',
            12 => 'Декабря'
        ];

        return isset($month_list[$month_id])? $month_list[$month_id] : 'н.д.';
    }

    public static function daysBetweenDates($dateFrom, $dateTo)
    {
        $from = new \DateTime($dateFrom);
        $to = new \DateTime($dateTo);
        $interval = $from->diff($to);
        return $interval->days;
    }

    public static function needSnow()
    {
        $curMonth = (int)date('m');
        $curDay = (int)date('d');

        if ($curMonth == 1 && $curDay <= 15) {
            return true;
        }

        if ($curMonth == 12 && $curDay >= 15) {
            return true;
        }
        return false;
    }
}
