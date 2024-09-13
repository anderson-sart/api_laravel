<?php

namespace App\Utils;

use Carbon\Carbon;
use Exception;

class DateUtils
{
    /**
     * Convert a string date to Carbon object for Date operations
     * @param $string string in format dd/mm/yyyy
     * @return Carbon Carbon instance
     */
    public static function convertStringToCarbonDate(string $string): Carbon
    {
        if($string){
            $dataHoraExplode = explode(" ", $string);
            $dataExplode = explode("/", $dataHoraExplode[0]);
            return Carbon::createFromDate($dataExplode[2], $dataExplode[1], $dataExplode[0]);
        }else{
            return '';
        }
    }

    /**
     * Convert a string date to Carbon object for Date operations
     * @param $string string in format mm/dd/yyyy
     * @return Carbon Carbon instance
     */
    public static function convertStringToCarbonDate2(string $string): Carbon
    {
        if($string){
            $dataHoraExplode = explode(" ", $string);
            $dataExplode = explode("/", $dataHoraExplode[0]);
            return Carbon::createFromDate($dataExplode[2], $dataExplode[0], $dataExplode[1]);
        }else{
            return '';
        }
    }

    /**
     * Convert a string date to Carbon object for Date operations
     * @param $string string in format dd/mm/yyyy dd/mm/yyyy-mm-dd
     * @return Carbon Carbon instance
     */
    public static function convertStringToCarbonDate3(string $string): Carbon
    {
        try {
            // Use Carbon's parse method to handle the ISO 8601 format directly
            return Carbon::parse($string);
        } catch (InvalidFormatException $e) {
            // Log the exception or handle it accordingly
            echo "Invalid date format: " . $e->getMessage();
            // Return null or handle it as needed
            return null;
        }
    }

    /**
     * Format the given string date to another date pattern given
     * @param $dateString
     * @param $pattern
     * @return string
     * @throws Exception
     */
    public static function formatDateString($dateString, $pattern): string
    {
        return Carbon::create($dateString)->format($pattern);
    }

    /**
     * Create a Carbon object from a DateTime object
     * @param $datetime
     * @return Carbon
     */
    public static function createFromDateTime($datetime): Carbon
    {
        return Carbon::createFromTimestamp($datetime);
    }

    /**
     * Return date created from format
     * @param string $format
     * @param string $date
     * @return bool|Carbon
     */
    public static function createFromFormat(string $format, string $date): bool|Carbon
    {
        return Carbon::createFromFormat($format, $date);
    }

        /**
     * Return date created from format
     * @param string $texto
     * @return string
     */
    public static function substituirMeses(string $texto)
    {
        // Array de mapeamento dos nomes dos meses em português para inglês
        $mesesMap = [
            'janeiro' => 'January',
            'fevereiro' => 'February',
            'março' => 'March',
            'abril' => 'April',
            'maio' => 'May',
            'junho' => 'June',
            'julho' => 'July',
            'agosto' => 'August',
            'setembro' => 'September',
            'outubro' => 'October',
            'novembro' => 'November',
            'dezembro' => 'December',
        ];

        // Substitua o nome do mês na string (insensível a maiúsculas/minúsculas)
        return str_ireplace(array_keys($mesesMap), array_values($mesesMap), $texto);

    }
    
    /**
     * Get the current date as a string in the format YYYY-MM-DD
     * @return string Current date in YYYY-MM-DD format
     */
    public static function getCurrentDate(): string
    {
        return Carbon::now()->toDateString();
    }
}

