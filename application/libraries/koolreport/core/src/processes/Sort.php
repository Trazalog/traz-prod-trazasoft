<?php
/**
 * This file contains class to handle data sorting
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */

/* Usage
 * ->pipe(new Sort(array(
 *         "amount"=>"desc",
 *         "id"=>"asc"
 * )))
 *  */
namespace koolreport\processes;

use \koolreport\core\Process;
use \koolreport\core\Utility as Util;

/**
 * This file contains class to handle data sorting
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
class Sort extends Process
{
    protected $data = array();

    /**
     * Handle on data input
     *
     * @param array $row The input data row
     *
     * @return null
     */
    protected function onInput($row)
    {
        array_push($this->data, $row);
    }

    /**
     * Do sorting
     * 
     * @return null
     */
    public function sortProcess()
    {
        $sorts = [];
        foreach ($this->params as $field => $direction) {
            $sorts[trim($field)] = is_string($direction) ?
            trim($direction) : $direction;
        }

        usort(
            $this->data,
            function ($a1, $a2) use ($sorts) {
                $cmp = 0;
                foreach ($sorts as $field => $direction) {
                    $v1 = Util::get($a1, $field, 0);
                    $v2 = Util::get($a2, $field, 0);
                    if ($direction === 'asc' || $direction === 'desc') {
                        if (is_numeric($v1) && is_numeric($v2)) {
                            if ($v1 < $v2) {
                                $cmp = -1;
                            } elseif ($v1 > $v2) {
                                $cmp = 1;
                            }

                        } else {
                            $cmp = strcmp($v1, $v2);
                        }
                        if ($direction === 'desc') {
                            $cmp = -$cmp;
                        }

                    } else if (is_callable($direction)) {
                        $cmp = $direction($v1, $v2);
                    }

                    if ($cmp !== 0) {
                        break;
                    }

                }
                return $cmp;
            }
        );
    }

    /**
     * Handle on input end
     * 
     * @return null
     */
    public function onInputEnd()
    {
        $this->sortProcess();
        foreach ($this->data as $row) {
            $this->next($row);
        }
        unset($this->data);
    }
}
