<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class UserImage extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    public $timestamps = false;

    public $messages;

    protected $fillable = ['user_id', 'path'];

    public static $rules = [
        'user_id' => 'required|Integer',
        'path'   => 'required|unique:images,path'
    ];

    public function isValid() {
        $v = Validator::make($this->attributes, static::$rules);

        // Pass
        if ($v->passes())
            return true;

        // Fail
        $this->messages = $v->messages();
        dd($this->messages);
        return false;
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');

}
