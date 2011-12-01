<?php
/**
 * This file declare the sfContextBehavior class.
 *
 * @package Loopkey
 * @subpackage lib-propel-behavior
 * @author Julien Muetton <julien_muetton@carpe-hora.com>
 * @copyright (c) Carpe Hora SARL 2011
 * @since 2011-11-30
 */

/**
 * Make table context aware
 */
class sfContextBehavior extends Behavior
{

    public function modifyDatabase()
    {
        foreach ($this->getDatabase()->getTables() as $table) {
            if ($table->hasBehavior($this->getName())) {
              // don't add the same behavior twice
              continue;
            }
            $b = clone $this;
            $table->addBehavior($b);
      }
    }

    protected function getApplicationContextFunction()
    {
      return <<<EOF
/**
 * return the current application context if any
 *
 * @return sfContext|null
 */
protected function getApplicationContext()
{
    try
    {
      if (\$sf_context = sfContext::getInstance())
      {
        return \$sf_context;
      }
    }
    catch(sfException \$e)
    {
      return null;
    }

}
EOF;
    }

    public function objectMethods($builder)
    {
      return $this->getApplicationContextFunction();
    }

    public function queryMethods($builder)
    {
      return $this->getApplicationContextFunction();
    }

    public function peerFilter(&$script)
    {
      $parser = new PropelPHPParser($script, true);
      $parser->addMethodBefore('translateFieldName', $this->getApplicationContextFunction());
      $script = $parser->getCode();
    }
} // END OF sfContextBehavior
