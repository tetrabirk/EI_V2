<?php
/**
 * Created by PhpStorm.
 * User: Ludovic
 * Date: 27-Jan-19
 * Time: 13:56
 */

namespace App\Service;
use Symfony\Component\Workflow\Registry;

/*
 * je ne sais pas encore exactement si je vais utiliser ceci
 * TODO: vérifier qeu j'ai besoind e ce truc
 */
class WorkflowState
{
    private $workflows;

    public function __construct(Registry $workflows)
    {
        $this->workflows = $workflows;
    }

    public function getState($entity){
        $stateMachine = $this->workflows->get($entity,'state_machine');
        return $stateMachine;
    }
}