<?php

    function ClearString($string) {

        return filter_var($string, FILTER_SANITIZE_URL, FILTER_SANITIZE_MAGIC_QUOTES);
    }

    /**
     * Cleans an entire array recursively
     * from having string injection
     *
     * @param   array       $array      - The original array
     * @return  array                   - The escaped array
     */
    function ClearArray(array $array) {

        return filter_var_array($array, FILTER_SANITIZE_URL, FILTER_SANITIZE_MAGIC_QUOTES);
    }

    /**
     * Remove new line characters from a string
     *
     * @param   string      $string     - The original string
     * @return  string                  - The string without new lines
     */
    function RemoveNewLines($string) {
        return preg_replace('/\s+/', ' ', trim($string));
    }

    /**
     * Concatenates each line of a string into slashes
     * and a concatenation character
     *
     * @param   string    $string           - The original string
     * @return  string                      - The converted string
     */
    function BuildStringNewLines($string) {
        $result = preg_replace('/' . PHP_EOL . '|' . chr(13) . '+/', '\\' . PHP_EOL, trim($string));
        return $result;
    }

    /**
     * An "addslashes" for single quotes only
     *
     * @param   string      $string     - The original string
     * @return  string
     */
    function AddSQSlashes($string) {
        return str_replace('\'', '\\\'', $string);
    }

    /**
     * A non-validation version to format string dates
     * from dd/mm/yyyy to yyyy-mm-dd
     *
     * The purpose is to do it fast, so it's not secure
     * if the incoming string isn't correct
     *
     * @param   string      $date       - The original string date in dd/mm/yyyy format
     * @return  string                  - The string formatted to yyyy-mm-dd
     */
    function formatDateDDMMYYYY_YYYYMMDD($date) {

        return date('Y-m-d', strtotime($date));
    }

    /**
     * A non-validation version to format string dates
     * from dd/mm/yyyy hh:mm:ss to yyyy-mm-dd hh:mm:ss
     *
     * The purpose is to do it fast, so it's not secure
     * if the incoming string isn't correct
     *
     * @param   string      $date       - The original string date in dd/mm/yyyy format
     * @return  string                  - The string formatted to yyyy-mm-dd hh:mm:ss
     */
    function formatDateTimeToSave($date) {

        return date('Y-m-d H:i:s', strtotime($date));
    }

    /**
     * A non-validation version to format string dates
     * from yyyy-mm-dd to dd/mm/yyyy
     *
     * The purpose is to do it fast, so it's not secure
     * if the incoming string isn't correct
     *
     * @param   string      $date       - The original string date in yyyy-mm-dd format
     * @return  string                  - The string formatted to dd/mm/yyyy
     */
    function formatDateYYYYMMDD_DDMMYYYY($date) {

        return date('d/m/Y', strtotime($date));
    }

    /**
     * A non-validation version to format string dates
     * from yyyy-mm-dd hh:mm:ss to dd/mm/yyyy hh:mm:ss
     *
     * The purpose is to do it fast, so it's not secure
     * if the incoming string isn't correct
     *
     * @param   string      $date       - The original string date in yyyy-mm-ddd hh:mm:ss format
     * @return  string                  - The string formatted to dd/mm/yyyy hh:mm:ss
     */
    function formatDateTimeToLoad($date) {

        return date('d/m/Y H:i:s', strtotime($date));
    }

    /**
     * Applies any mask based on # character
     *
     * Such a wow I just did
     *
     * @param   string      $val        - The number value
     * @param   string      $mask       - The desired mask
     * @return  string
     */
    function mask($val, $mask) {

        $val    = preg_replace('/[^a-z0-9]/i','', $val);
        $masked = '';
        $k      = strlen($val) - 1;

        for($i = strlen($mask)-1; $i>=0; $i--) {
            if ($k < 0) break;
            $mask[$i] != '#' || $masked = $val[$k--] . $masked;
            $mask[$i] == '#' || $masked = $mask[$i]  . $masked;
        }
        return $masked;
    }

    /**
     * Converts to phone format
     *
     * @param   string      $texto
     * @return  string
     */
    function phoneFormat($texto) {

        $result = '';
        $s1 = $string = preg_replace('/[^0-9]/i','', $texto);
        $p = 0;
        for ($i = strlen($s1); $i > 0; $i--) {
            $p++;
            switch ($p) {
                case 5: $result = '-' . $result;
                    break;
                case 9: if (strlen($s1) == 10 || strlen($s1) == 12)
                    $result = ' ' . $result;
                    break;
                case 10: if (strlen($s1) == 11 || strlen($s1) == 13)
                    $result = ' ' . $result;
            }
            $result = $s1[$i - 1] . $result;
        }
        return ($result == "" ? $texto : $result);
    }

    /**
     * Converte o texto do campo conforme opcao
     *
     * @param   string      $string         - O conteÃºdo do campo
     * @param   int         $option         - A opcao
     * @return  string
     */
    function convertTextFormat($string, $option) {
        switch ($option) {
            case 'ln': //Letras e NÃºmeros
                $string = preg_replace('/[^a-z0-9\-]/i','',$string);
                break;
            case 'l': //Letras
                $string = preg_replace('/convertTe[^a-z\-]/i','',$string);
                break;
            case 'n': //NÃºmeros
                $string = preg_replace('/[^0-9\-]/i','',$string);
                break;
            case 'fone': //Telefone
                //$string = self::phoneFormat($string);
                $string = self::mask($string, '#####-####');
                break;
            case 'ddd': //Telefone com DDD
                $string = self::phoneFormat($string);
                break;
            case 'cnpj': //CNPJ
                $string = self::mask($string, '##.####.###/####-##');
                break;
            case 'cpf': //CPF
                $string = self::mask($string, '###.###.###-##');
                break;
            case 'cep': //CEP
                $string = self::mask($string, '#####-###');
                break;
            case 'currency':
                $string = number_format($string, 2, ',', '.');
                break;
            case 'email': //E-MAIL
                // Nothing we can do here
                break;
            case 'int': //Numeros Inteiros
                $string = preg_replace('/[^0-9\-]/i','',$string);
                break;
            case 'float':
                $string = number_format($string, 2, ',', '.');
                break;
        }

        return $string;
    }

    /**
     * @param   string      $value
     * @param   string      $currency
     * @return  string
     */
    function asCurrency($value, $currency = 'R$')
    {
        // DO NOT remove float conversions, they are NOT redundant
        $value = asFloat($value);
        return $currency . ' ' . convertTextFormat(floatval($value), 'currency');
    }

    /**
     * @param   string      $value
     * @return  string
     */
    function asUnsigned($value)
    {
        $value = filter_var($value, FILTER_SANITIZE_NUMBER_INT); 
        return str_replace(['+','-'], '', $value);
    }

    /**
     * @param   string      $value
     * @return  string
     */
    function asSigned($value)
    {
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT); 
    }

    /**
     * @param   string          $value
     * @param   string|bool     $ddd
     * @return  string
     */
    function asPhone($value, $ddd = false)
    {
        $prefix = '';
        if ($ddd)
            $prefix = '(' . $ddd . ')';
        
        return $prefix . self::phoneFormat($value, 'fone');
    }

    /**
     * No my proudest
     *
     * @param   string  $type
     * @return  string
     */
    function phoneType($type)
    {
        //TODO: please, remove this and make something decent
        switch ($type) {
            case 'M':
                return 'Móvel';
                break;
            case 'R':
                return 'Residencial';
                break;
            case 'C':
                return 'Comercial';
                break;
            default:
                return 'Residencial';
                break;
        }

    }

    /**
     * @param   string      $value
     * @return  string
     */
    function asCpf($value)
    {
        return self::mask($value, '###.###.###-##');
    }

    /**
     * @param   string      $value
     * @return  string
     */
    function asCnpj($value)
    {
        return self::mask($value, '##.###.###/####-##');
    }

    /**
     * @param   string      $value
     * @return  string
     */
    function asDate($value)
    {
        if (date('Y', strtotime($value)) < 100) {
            return '(Sem Data)';
        }
        return date('d/m/Y', strtotime($value));
    }

    /**
     * @param   string      $value
     * @return  string
     */
    function asDateTime($value)
    {
        return date('d/m/Y H:i:s', strtotime($value));
    }

    /**
     * @param   string      $value
     * @return  string
     */
    function asTime($value, $format = 'H:i:s')
    {
        return date($format, strtotime($value));
    }

    /**
     * @param   string      $value
     * @return  string
     */
    function toDate($value)
    {
        return date('Y-m-d', strtotime($value));
    }

    /**
     * @param   string      $value
     * @return  string
     */
    function toMonth($value)
    {
        return date('Y-m', strtotime($value));
    }

    /**
     * @param   string      $value
     * @return  string
     */
    function toTime($value)
    {
        return date('H:i:s', strtotime($value));
    }

    /**
     * @param   string  $date
     * @param   string  $format
     * @return  bool
     */
    function isValidDate($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * @param   string  $stringDate
     * @return  bool|\DateTime
     */
    function getDateTimeFromString($stringDate)
    {
        $formats = [
            'Y-m-d',
            'y-m-d',
            'Y-m-d H:i:s',
            'y-m-d H:i:s',
            'd/m/Y',
            'd/m/y',
            'd/m/Y H:i:s',
            'd/m/y H:i:s'
        ];

        foreach ($formats as $format) {
            $d = \DateTime::createFromFormat($format, $stringDate);
            if ($d && $d->format($format) == $stringDate) {
                return $d;
            }
        }

        return false;
    }

    /**
     * @param   string      $value
     * @return  string
     */
    function asCep($value)
    {
        return self::mask($value, '#####-###');
    }

    /**
     * @param   string|float    $value
     * @return  mixed
     */
    function asFloat($value)
    {
        // $fmt = new \NumberFormatter('en_US.utf8', $value); // package ins't installed
        if (strpos($value, ',') !== false) {
            $value = str_replace('.', '',  $value); // Temporary solution for no package existance
            $value = str_replace(',', '.', $value); // Temporary solution for no package existance
        }
        return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    /**
     * @param   string  $string
     * @return  bool
     */
    function isNumberWithValue($string)
    {   
        return intval($string) > 0;
    }

    /**
     * @param   string  $string
     * @return  bool
     */
    function isFloatWithValue($string)
    {
        return floatval($string) > 0;
    }

    /**
     * Valida o formato dos dados em um campo de texto
     *
     * @param   string      $string     - O conteÃºdo
     * @param   int         $option     - O valor da opcao
     * @return  bool
     */
    function validateTextFormat($string, $option) {

        switch ($option) {
            case 'ln': //Letras e NÃºmeros
                return preg_match('/[a-z0-9]/i', $string);
                break;
            case 'l': //Letras
                return preg_match('/[a-z]/i', $string);
                break;
            case 'n': //NÃºmeros
                return preg_match('/[0-9]/i', $string);
                break;
            case 'fone': //Telefone
                return preg_match('/^([0-9]{2}\s[0-9]{4}\-[0-9]{4})|([0-9]{2}\s[0-9]{5}\-[0-9]{4})$/', $string);
                break;
            case 'ddd': //Telefone com DDD
                return preg_match('/^([0-9]{2}\s[0-9]{4}\-[0-9]{4})|([0-9]{2}\s[0-9]{5}\-[0-9]{4})$/', $string);
                break;
            case 'cnpj': //CNPJ
                return preg_match('/^(\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2})$/', $string);
                break;
            case 'cpf': //CPF
                return preg_match('/^(\d{3}\.\d{3}\.\d{3}\-\d{2})$/', $string);
                break;
            case 'cnpjcpf': //CPNJ ou CPF
                return preg_match('/(^\d{3}\.\d{3}\.\d{3}\-d{2}$)|(^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$)/', $string);
                break;
            case 'cep': //CEP
                return preg_match('/^(\d{5}\-\d{3})$/', $string);
                break;
            case 'email': //E-MAIL
                return preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{1,3})+$/', $string);
                break;
            case 'int': //Numeros Inteiros
                return preg_match('/[0-9\-]/', $string);
                break;
            case 'float':
                return preg_match('/^[0-9]+\.?[0-9]*$/', $string);
                break;
            default:
                return true;
                break;
        }
    }

    /**
     * @param   string  $cpf
     * @return  bool
     */
    function cpfValid($cpf) {

        $cpf = preg_replace('/[\-\.]/','',$cpf);
        for ($t = 9; $t < 11; $t++) {

            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }
        return true;
    }

    /**
     * Checks for a valid CPF
     *
     * Not just if the format matches, but
     * really checks using the code validator
     *
     * @param   string      $cpf        - The CPF
     * @return  bool
     */
    function validateCpf($cpf){
        $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);

        if (strlen($cpf) != 11)
            return false;

        for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
            $soma += $cpf{$i} * $j;
        $resto = $soma % 11;
        if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto))
            return false;

        for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
            $soma += $cpf{$i} * $j;

        $resto = $soma % 11;
        return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
    }

    /**
     * Checks for a valid CNPJ
     *
     * Not just if the format matches, but
     * really checks using the code validator
     *
     * @param   string      $cnpj        - The CNPJ
     * @return  bool
     */
    function validateCnpj($cnpj) {

        if(empty($cnpj))
            return false;

        if($cnpj == '')
            return false;

        $cnpj = preg_replace('/[\-\.\/]/','',$cnpj);
        $cnpj = str_split($cnpj);

        if (count($cnpj) <> 14)
            return false;

        $sum1 = ($cnpj[0] * 5) + ($cnpj[1] * 4) + ($cnpj[2] * 3) + ($cnpj[3] * 2) + ($cnpj[4] * 9) + ($cnpj[5] * 8) + ($cnpj[6] * 7) + ($cnpj[7] * 6) + ($cnpj[8] * 5) + ($cnpj[9] * 4) + ($cnpj[10] * 3) + ($cnpj[11] * 2);

        $mod1 = $sum1 % 11;
        $mod1 = $mod1 < 2 ? 0 : 11 - $mod1;

        $sum2 = ($cnpj[0] * 6) + ($cnpj[1] * 5) + ($cnpj[2] * 4) + ($cnpj[3] * 3) + ($cnpj[4] * 2) + ($cnpj[5] * 9) + ($cnpj[6] * 8) + ($cnpj[7] * 7) + ($cnpj[8] * 6) + ($cnpj[9] * 5) + ($cnpj[10] * 4) + ($cnpj[11] * 3) + ($cnpj[12] * 2);

        $mod2 = $sum2 % 11;
        $mod2 = $mod2 < 2 ? 0 : 11 - $mod2;

        return $cnpj[12] == $mod1 && $cnpj[13] == $mod2;
    }

    /**
     * Returns the month acronym from month number
     *
     * @param   int     $monthNumber        - The month nymber
     * @return  string                      - The month acronym
     */
    function getMonthAcronym($monthNumber) {

        $months = array(
            '', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'
        );

        return $months[intval($monthNumber)];
    }


    /**
     * Removes empty values for arrays
     * with numeric indexes
     *
     * The indexes that contain values will
     * be moved upwards, so numeric indexes
     * will remain in sequence
     *
     * @param   array       $array      - The original array
     */
    function arrayTrimNumericIndexed(&$array) {

        $result = array();

        foreach ($array as $value) $value == '' || $result[] = $value;
        $array = $result;
    }

    /**
     * Generates numeric intervals between 2 numbers
     * with a gap of specific percentage
     *
     * @param   $min            - min value
     * @param   $max            - max value
     * @param   $percentage     - gap percentage (% of (min - max) for each value)
     * @return  array
     */
    function generateIntervals($min, $max, $percentage) {

        $interval = ((($max - $min) * $percentage) / 100);
        $start  = 1;
        $result = array();
        $result[] = $min;
        while ($min < $max) {
            $result[] = $min + $interval;
            $min += $interval;
            $start++;
        }

        return $result;
    }

    /**
     * Converts CameCase text to Uppercase-First-Letter words
     *
     * @param   string      $word           - The CamelCased Text
     * @return  string                      - The Uppercase-First-Letter text
     */
    function decamelize($word) {
        return preg_replace(
            '/(^|[a-z])([A-Z])/e',
            'strlen("\\1") ? "\\1 \\2" : "\\2"',
            $word
        );
    }

    /**
     * Converts underline_separated_text to CamelCase Text
     *
     * @param   string      $word           - The underlined_separated_text
     * @return  string                      - The CamelCased text
     */
    function camelize($word) {
        return preg_replace('/(^|_)([a-z])/e', 'strtoupper("\\2")', $word);
    }
    
    /**
     * @param   string      $string
     * @param   string      $hash
     * @return  bool
     */
    function HashCheck($string, $hash) {
        return password_verify($string, $hash);
    }

    /**
     * @param   string      $string
     * @param   bool        $decodeUrl
     * @return  bool
     */
    function isBase64Image($string, $decodeUrl = false) {

        if ($decodeUrl)
            $string = urldecode($string);

        return substr($string, 0, 10) == 'data:image';
    }

    /**
     * @param   $space
     * @return  int
     */
    function asBytes($space) {

        $char = strtoupper(substr($space,(strlen($space)-1), 1));

        $calc = [
            'K' => 1024,
            'M' => 1024^2,
            'G' => 1024^3
        ];

        if (in_array($char, array_keys($calc)))
            return intval($space) * $calc[$char];

        return $space;
    }

    /**
     * @param   string  $space
     * @return  string
     */
    function asGigaBytes($space) {

        $bytes     = self::asBytes($space);
        $gigabytes = floatval($bytes / (1024^3));

        return  $gigabytes . 'GB';
    }

    /**
     * @param   string      $used
     * @param   string      $total
     * @return  float
     */
    function CalculateSpacePercent($used, $total) {

        $used  = self::asBytes($used);
        $total = self::asBytes($total);

        if ($total == 0) return 100;

        return ($used * 100) / $total;

    }

    /**
     * @param   string          $cardNumber
     * @return  bool|string
     */
    function getCreditCardBrand($cardNumber) {

        $matchingPatterns = [
            'visa'       => '/^4[0-9]{12}(?:[0-9]{3})?$/',
            'mastercard' => '/^5[1-5][0-9]{14}$/',
            'amex'       => '/^3[47][0-9]{13}$/',
            'diners'     => '/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/',
            'discover'   => '/^6(?:011|5[0-9]{2})[0-9]{12}$/',
            'jcb'        => '/^(?:2131|1800|35\d{3})\d{11}$/',
            'any'        => '/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/'
        ];

        foreach ($matchingPatterns as $key => $pattern) {
            if (preg_match($pattern, $cardNumber)) {
                return  $key;
            }
        }

        return false;
    }

    /**
     * @param   string  $cardNumber
     * @return  string
     */
    function MaskCard($cardNumber)
    {
        return 'XXXX-XXXX-XXXX-' . substr($cardNumber, -4);
    }

    /**
     * @param   string  $sdate
     * @param   string  $edate
     * @return  mixed
     */
    function daysInterval($sdate, $edate)
    {
        $s_date = new \DateTime($sdate);
        $e_date = new \DateTime($edate);

        return $e_date->diff($s_date)->format('%a');
    }

    /**
     * @param   string  $stdDate
     * @return  bool
     */
    function isFutureDate($strDate)
    {
        $date  = new \DateTime($strDate);
        $today = new \DateTime('today');

        return $date > $today;
    }

    function isDateOlderThan($strDate, $strDateRef)
    {
        $date  = new \DateTime($strDate);
        $ref   = new \DateTime($strDateRef);

        return $date < $ref;
    }

    /**
    * @param    string  $string
    * @return   string
    */
    function asSearch($string)
    {
        $string = str_replace(['.', ',', '-'], '', $string);
        return '%' . str_replace(' ', '%', $string) . '%';
    }

    /**
    * @param    string  $string
    * @return   string
    */
    function asUtf8HtmlEntity($string)
    {
        return htmlentities(mb_convert_encoding($string, 'UTF-8', 'ASCII'), ENT_SUBSTITUTE, "UTF-8");
    }

    /**
    * @param    string  $string
    * @return   string
    */
    function asUtf8($string)
    {
        if (!is_string($string)) { 
            return $string;
        }
        return mb_convert_encoding($string, 'UTF-8', 'ASCII');
    }

    function arrayContainAllValues($array, $arrayAgainst)
    {
        return array_intersect($array, $arrayAgainst) == $array;
    }

    /**
    * @param    array|\Zend\Paginator\Adapter\DbSelect   $data
    * @param    string                                   $dateField
    * @return   string
    */
    function groupByDate($data, $dateField)
    {
        $result = [];
        if (count($data) > 0) foreach ($data as $row) {
            $date = date('Y-m-d', strtotime($row[$dateField]));
            if (!isset($result[$date])) {
                $result[$date] = [];
            }
            $result[$date][] = $row;
        }

        return $result;
    }

    /**
    * @param    string
    * @return   string
    */
    function validateFullName($name){
        $name = trim(str_replace('  ', ' ',  $name));

        if (strpos($name, ' ') !== false) {
            return true;
        }else{
            return false;
        }
    }

    function validateMobileNumber($ddd, $number) {
        if (strlen($ddd) < 2){
            return false;
        }
        else if ( strlen($number) != 9){
            return false;
        }
        else if ( substr($number,0,1) != 9){
            return false;
        }else{
            return true;
        }
    }
    
    function convert_from_latin1_to_utf8_recursively($dat){
        if (is_string($dat)) {
            return utf8_encode($dat);
        } elseif (is_array($dat)) {
            $ret = [];
            foreach ($dat as $i => $d) $ret[ $i ] = convert_from_latin1_to_utf8_recursively($d);
            return $ret;
        } elseif (is_object($dat)) {
            foreach ($dat as $i => $d) $dat->$i = convert_from_latin1_to_utf8_recursively($d);
            return $dat;
        } else {
            return $dat;
        }
    }

    function montarCGCCIC($text){
        $text = trim($text);
        
        if (strlen($text) < 11 ){
            $text = str_pad($text, 11, "0", STR_PAD_LEFT);
        }else if (strlen($text) > 11 ){
            $text = str_pad($text, 14, "0", STR_PAD_LEFT);
        }

        //$pos = strrpos($text, ".");
        if (strrpos($text, ".")) {
            return $text;
        }

        if ( (strlen($text) == 14) && (substr($text,0,3) == '000') ){
            $text = substr($text,3,11);
        }

	    if (strlen($text) == 11){
		    $result = substr($text, 0,  3) . '.' .
                      substr($text, 3,  3) . '.' .
                      substr($text, 6,  3) . '/' .
                      substr($text, 9, 2);
        }

	    if (strlen($text) == 14){
            $result = substr($text, 0, 2) . '.' .
                      substr($text, 2, 3) . '.' .
                      substr($text, 5, 3) . '/' .
                      substr($text, 8, 4) . '-' .
                      substr($text, 12, 2);
        }

	    return $result;
    }

    /**
    * @param    class                   - The class to be explode
    * @param    field                   - Field of class to be explode
    * @return   string                  
    */
    function objectToStrIn($class, $field){
        $array = [];

        foreach ($class as $item){
            $array[] = $item->$field;
        }

        return implode(',', $array);
    }

    function array_to_xml( $data, &$xml_data, $itemName = null ) {
        foreach( $data as $key => $value ) {
            if( is_numeric($key) ){
                if ($itemName){
                    $key = $itemName;
                }else{
                    $key = 'item'.$key; //dealing with <0/>..<n/> issues
                }
            }
            if( is_array($value) ) {
                $subnode = $xml_data->addChild($key);
                array_to_xml($value, $subnode);
            } else {
                $xml_data->addChild("$key",htmlspecialchars("$value"));
            }
         }
    }

    function array2xml($data, $root = null){
        $xml = new SimpleXMLElement($root ? '<' . $root . '/>' : '<root/>');
        array_walk_recursive($data, function($value, $key)use($xml){
            $xml->addChild($key, $value);
        });
        return $xml->asXML();
    }

    function formatDateAuto($date){
        if (strpos($date, '-') === false){
            $date = substr($date, 6,4) . substr($date, 3,2) . substr($date, 0,2);
        }else{
            $date = str_replace('-', '', $date);
        }

        return $date;
    }