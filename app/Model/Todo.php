<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class Todo extends Model
{
    protected $table = 'todo';
    protected $fillable = ['todo','category','user_id','description'];


    public function todo()
    {
         return $this->hasMany('App\Model\Todo');
    }
}