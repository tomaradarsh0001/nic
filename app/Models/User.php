<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    //Changes done by lalit_tiwari on 26/07/2024
    protected $guarded = [];
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'designation_id',
    // ];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function userNameById($id)
    {
        $data =  Self::select('*')->where('id', $id)->first();
        if($data){
            return $data['name'];
        } else {
            return null;
        }
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function sections(): BelongsToMany
    {
        return $this->belongsToMany(Section::class);
    }

    public function applicantUserDetails()
    {
        return $this->hasOne(ApplicantUserDetail::class, 'user_id');
    }

    //Make user & user properties relationship - Lalit (08/Nov/2024)
    public function userProperties()
    {
        return $this->hasMany(UserProperty::class, 'user_id');
    }

    // Define the relationship with the NewlyAddedProperty model
    public function newlyAddedProperties()
    {
        return $this->hasMany(NewlyAddedProperty::class, 'user_id', 'id');
    }

    // Define the relationship with the ApplicantUserDetails model
    public function applicantDetails()
    {
        return $this->hasOne(ApplicantUserDetail::class, 'user_id', 'id');
    }

    // Define the relationship to EmployeeDetails
    public function employeeDetails()
    {
        return $this->hasOne(EmployeeDetail::class, 'user_id');
    }

    
}
