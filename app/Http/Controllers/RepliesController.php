<?php

namespace App\Http\Controllers;

use App\Like;
use App\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function like($id)
	{
		Like::create([
			'reply_id' => $id,
			'user_id' => Auth::id()
		]);

		Session::flash('success', 'You liked the reply');

		return redirect()->back();
	}

	public function unlike($id)
	{
		$like = Like::where('reply_id', $id)->where('user_id', Auth::id())->first();

		$like->delete();

		Session::flash('success', 'You unliked the reply');

		return redirect()->back();
	}
	public function best_answer($id)
	{
		$reply = Reply::find($id);

		$reply->best_answer = 1;
		$reply->save();

		Session::flash('success', 'Reply has been marked as best answer');

		return redirect()->back();
	}

	public function edit($id)
	{
		return view('replies.edit', ['r' => Reply::find($id)]);

	}

	public function update($id)
	{
		$this->validate(\request(), [
			'content' => 'required'
		]);

		$r = Reply::find($id);
		$r->content = \request()->content;
		$r->save();

		Session::flash('success', 'reply updated');

		return redirect()->route('discussion', ['slug' => $r->discussion->slug]);
	}
}
