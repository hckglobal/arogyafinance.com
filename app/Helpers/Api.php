<?php 
namespace App\Helpers;

class Api
{

	public static function success($message,$data=null)
	{
		return ['success'=>true,'message'=>$message,'data'=>$data];
	}

	public static function error($message)
	{
		return ['success'=>false,'message'=>$message];
	}
}