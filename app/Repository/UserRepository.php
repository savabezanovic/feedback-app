<?php


namespace App\Repositories;


use App\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class UserRepository
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all()
    {
        return $this->user->all();
    }

    public function find($id)
    {
        return $this->user->find($id);
    }

    public function findWithProfile($id)
    {
        return $this->user->with('profile')
            ->find($id);
    }

    public function admins()
    {
        $admins = User::whereHas('role', function($q){
            $q->whereIn('name', ['admin']);
        })
        ->get();
        return $admins;
    }

    public function store($request, $password)
    {
       $user = $this->user->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $password,
            'company_id' => $request->company_id,
//            'email_verified_at' => now(),
//            'remember_token' => Str::random(10)
       ]);

       $user->profile()->create([
            'job_title_id' => $request->job_title_id,
       ]);

            return $user;
    }

    public function storeAdmin($request, $password)
    {
        $user = $this->user->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $password,
            'company_id' => $request->company_id,
//            'email_verified_at' => now(),
//            'remember_token' => Str::random(10)
        ]);

        return $user;
    }

    public function update($request, $user)
    {
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email
        ]);

        $user->profile()->update([
            'job_title_id' => $request->job_title_id,
        ]);

        return $user;
    }

    public function updatePassword($password, $user)
    {
        $user->update([
           'password' => $password
        ]);

        return $user;
    }

    public function updatePicture($picture, $user)
    {
        $user->profile()->update([
            'picture' => $picture
        ]);

        return $user;
    }

    public function updateStatus($value, $user)
    {
        return $user->update([
            'active' => $value
        ]);
    }

    public function delete($user)
    {
        $user->delete();
    }
}
