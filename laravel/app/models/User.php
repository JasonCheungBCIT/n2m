<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	public $timestamps = true;

	public $messages;

	protected $fillable = ['email', 'password', 'confirmation_code', 'note', 'todo', 'image'];

	public static $rules = [
		'email'=>'required|email|unique:users',
		'password'=>'required|confirmed|min:6'
	];

	public function isValid() {
		$v = Validator::make($this->attributes, static::$rules);
		// Pass
		if ($v->passes())
			return true;
		// Fail
		$this->messages = $v->messages();
		return false;
	}

	public function isValidManual($input) {
		$v = Validator::make($input, static::$rules);
		// Pass
		if ($v->passes())
			return true;
		// Fail
		$this->messages = $v->messages();
		return false;
	}

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

}
