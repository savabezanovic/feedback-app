<?php


namespace App\Services;


use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * @var UserRepository
     */
    private $user;
    /**
     * @var CompanyService
     */
    private $companyService;
    /**
     * @var StorageService
     */
    private $storageService;

    public function __construct(UserRepository $user, CompanyService $companyService, StorageService $storageService)
    {
        $this->user = $user;
        $this->companyService = $companyService;
        $this->storageService = $storageService;
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
        return $this->user->findWithProfile($id);
    }

    public function admins()
    {
        return $this->user->admins();
    }

    public function hashPassword($value)
    {
        return Hash::make($value);
    }

    public function store($request)
    {
        $password = $this->hashPassword($request->password);

        $user = $this->user->store($request, $password);

        $picture = $this->storageService->storeProfilePicture($request, $user);

        $this->user->updatePicture($picture, $user);

        return $user;
    }

    public function storeAdmin($request)
    {
        $password = $this->hashPassword($request->password);

        return $user = $this->user->storeAdmin($request, $password);
    }

    public function delete($id)
    {
        $user = $this->find($id);

        $this->storageService->deleteProfilePicture($user);

        return $this->user->delete($user);
    }

    public function update($request, $id)
    {
        $user = $this->find($id);

        return $this->user->update($request, $user);
    }

    public function updatePassword($request, $id)
    {
        $password = $this->hashPassword($request->password);

        return $this->user->updatePassword($password, $this->find($id));
    }

    public function updatePicture($request, $id)
    {
        $user = $this->find($id);

        $picture = $this->storageService->updateProfilePicture($request, $user);

        return $this->user->updatePicture($picture, $user);
    }

    public function updateStatus($id)
    {
        $user = $this->find($id);

        if ($user->active) {

            return $this->user->updateStatus(0, $user);
        }

        return $this->user->updateStatus(1, $user);
    }

    public function createAdmin($request)
    {
        return $this->storeAdmin($request);
    }

    public function uploadPicture($request, $user)
    {
        $picture = $request->file('picture');

        $name = $user->id . '.' . $picture->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('profile-pictures/' . $user->company->name, $picture, $name);

        $pictureFile = asset('storage/profile-pictures/' . $user->company->name . '/' . $name);

        return $pictureFile;
    }

    public function highestAverageFeedbackScore()
    {
        $company = auth()->user()->company;

        $data = ['score' => 0];

        foreach ($company->adminListUsers() as $user) {

            if ($user->averageFeedbackScore() > $data['score']) {

                $data['score'] = round($user->averageFeedbackScore(), 2);

                $data['user'] = $user->first_name . ' ' . $user->last_name;
            }
        }

        return $data;
    }

    public function lowestAverageFeedbackScore()
    {
        $company = auth()->user()->company;

        $data = [];

        foreach ($company->adminListUsers() as $user) {

            if ($user->averageFeedbackScore()) {

                if (!isset($data['score'])) {

                    $data['score'] = round($user->averageFeedbackScore());

                    $data['user'] = $user->first_name . ' ' . $user->last_name;
                }

                else {

                    if ($user->averageFeedbackScore() < $data['score']) {

                        $data['score'] = $user->averageFeedbackScore();

                        $data['user'] = $user->first_name . ' ' . $user->last_name;
                    }

                }
            }

        }

        return $data;
    }
}
