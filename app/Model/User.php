<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
class User extends Model implements Authenticatable
{
   //
//    use Authorizable;
   use AuthenticableTrait;
   protected $fillable = ['username','email','password','userimage'];
   protected $hidden = [
   'password', 'api_key'
   ];
   /*
   * Get Todo of User
   *
   */
   public function todo()
   {
       return $this->hasMany('App\Model\Todo','user_id');
   }
}