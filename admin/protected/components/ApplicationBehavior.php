<?php
class ApplicationBehavior extends CBehavior
{       
  private $_owner;

  public function events() 
  {
    return  array(
    'onBeginRequest'=>'denyEverything',     
    );
  }

  public function denyEverything()
  {
    $owner=$this->getOwner();
    if($owner->user->getIsGuest())
      $owner->catchAllRequest=array("/user/login");
  }
}