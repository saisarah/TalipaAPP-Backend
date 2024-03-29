<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        return Question::all();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'question' => 'required',
            'answer' => 'required'
        ]);

        $faqs = new Question();
        $faqs->user_id = Auth::id();
        $faqs->question = $request->question;
        $faqs->answer = $request->answer;
        $faqs->save();

        return $faqs;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'question' => 'required',
            'answer' => 'required'
        ]);

        $faqs = Question::findOrFail($id);

        $faqs->update([
            'question' => $request->question,
            'answer' => $request->answer
        ]);
        return $faqs;
    }

    public function show($id)
    {
        return Question::findOrFail($id);
    }

    public function delete($id)
    {
        return Question::findOrFail($id)->delete();
    }
}
