<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/18/2018
 * Time: 11:16 PM
 */

namespace TimSDK\Support;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class Dumper
{
    /**
     * Dump a value with elegance.
     *
     * @param $value
     * @return void
     */
    public function dump($value)
    {
        if (class_exists(CliDumper::class)) {
            $dumper = in_array(PHP_SAPI, ['cli', 'phpdpg']) ? new CliDumper : new HtmlDumper;

            $dumper->dump((new VarCloner)->cloneVar($value));
        } else {
            var_dump($value);
        }
    }
}
