<?php
/**
 * This file contains process to handle uppercase,lowercase for string column.
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */

/* Usage
 * ->pipe(new StringCase(array(
 *         "upper"=>"name,address",
 *         "lower"=>"name,address",
 *         "first-cap"=>"name,address",
 *         "all-cap"=>"name,address",
 *  * )))
 * first-cap: Make the first character capitalize
 * all-cap: Make all the first character of each word capitalize
 */
namespace koolreport\processes;

use \koolreport\core\Process;

/**
 * This file contains process to handle uppercase,lowercase for string column.
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
class StringCase extends Process
{
    /**
     * Handle on initiation
     *
     * @return null
     */
    protected function onInit()
    {
        foreach ($this->params as $key => $value) {
            $columnList = explode(",", $value);
            foreach ($columnList as $k => $v) {
                $columnList[$k] = trim($v);
            }
            $this->params[$key] = $columnList;
        }
    }

    /**
     * Handle on data input
     *
     * @param array $data The input data row
     *
     * @return null
     */
    protected function onInput($data)
    {
        //Process data here
        foreach ($this->params as $func => $columns) {
            switch ($func) {
            case "upper":
                foreach ($columns as $col) {
                    $data[$col] = strtoupper($data[$col]);
                }
                break;
            case "lower":
                foreach ($columns as $col) {
                    $data[$col] = strtolower($data[$col]);
                }
                break;
            case "first-cap":
                foreach ($columns as $col) {
                    $data[$col] = ucfirst($data[$col]);
                }
                break;
            case "all-cap":
                foreach ($columns as $col) {
                    $data[$col] = ucwords($data[$col]);
                }
                break;
            }
        }
        $this->next($data);
    }
}
