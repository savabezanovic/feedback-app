<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackSkillRequest;
use App\Services\FeedbackService;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * @var FeedbackService
     */
    private $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    public function getUser(Request $request, $id)
    {

        $feedback = $this->feedbackService->findByUser($id);

        return response()->json(['user_id' => $id, 'feedback' => $feedback]);
    }

    public function storeData(FeedbackSkillRequest $request)
    {
        $this->feedbackService->saveData($request);

        return response()->json(['success' => 'Feedback saved','result' => $request->skill_name]);
    }
}
