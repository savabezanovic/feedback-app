<?php


namespace App\Services;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

class StorageService
{
    public function deleteProfilePicture($user)
    {
        if (Storage::exists('public/profile-pictures/' . $user->company->name . '/' . $user->id . '.jpg')) {

            try {
                return Storage::delete('public/profile-pictures/' . $user->company->name . '/' . $user->id . '.jpg');
            } catch (FileNotFoundException $e) {
            }
        } else if (Storage::exists('public/profile-pictures/' . $user->company->name . '/' . $user->id . '.jpeg')) {

            try {
                return Storage::delete('public/profile-pictures/' . $user->company->name . '/' . $user->id . '.jpeg');
            } catch (FileNotFoundException $e) {
            }
        } else if (Storage::exists('public/profile-pictures/' . $user->company->name . '/' . $user->id . '.png')) {

            try {
                return Storage::delete('public/profile-pictures/' . $user->company->name . '/' . $user->id . '.png');
            } catch (FileNotFoundException $e) {
            }
        }

        return false;
    }

    public function updateCompanyDirectoryName($company, $new)
    {
        if (Storage::exists('public/profile-pictures/' . $company->name)) {

            return Storage::move('public/profile-pictures/' . $company->name, 'public/profile-pictures/' . $new);
        }

        return false;
    }

    public function deleteCompanyDirectory($company)
    {
        if (Storage::exists('public/profile-pictures/' . $company->name)) {

            return Storage::deleteDirectory('public/profile-pictures/' . $company->name);
        }

        return false;
    }

    public function storeProfilePicture($request, $user)
    {
        $picture = $request->file('picture');

        $name = $user->id . '.' . $picture->getClientOriginalExtension();

        Storage::disk('public')->putFileAs('profile-pictures/' . $user->company->name, $picture, $name);

        $pictureFile = asset('storage/profile-pictures/' . $user->company->name . '/' . $name);

        return $pictureFile;
    }

    public function updateProfilePicture($request, $user)
    {
        $this->deleteProfilePicture($user);

        return $this->storeProfilePicture($request, $user);
    }
}
