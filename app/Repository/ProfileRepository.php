<?php


namespace App\Repositories;


use App\Profile;

class ProfileRepository
{
    /**
     * @var Profile
     */
    private $profile;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }
    public function createProfile($request) {
        $profile = new Profile;
        $profile->picture = "https://lorempixel.com/640/480/?36443";
    }
}
